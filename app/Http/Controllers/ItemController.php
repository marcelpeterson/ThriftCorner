<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Models\ItemImage;
use App\Services\WhatsAppLinkBuilder;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\SearchItemsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    function getItemPage(SearchItemsRequest $request) {
        $query = Item::with(['user', 'category', 'images'])
            ->available()
            ->search($request->input('q'))
            ->category($request->input('category'))
            ->condition($request->input('condition'))
            ->priceRange($request->input('min_price'), $request->input('max_price'));

        // Always show premium items first, then apply sorting
        $query->premiumFirst();
        
        // Sorting
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'price_asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price_desc':
                $query->orderBy('price', 'desc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'newest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $items = $query->paginate(12)->withQueryString();
        $categories = Category::all();
        
        // Get featured items for homepage section
        $featuredItems = Item::with(['user', 'category', 'images'])
            ->where('is_premium', true)
            ->where('premium_until', '>', now())
            ->available()
            ->latest()
            ->take(6)
            ->get();

        return view('home', compact('items', 'categories', 'featuredItems'));
    }

    function viewItem($id) {
        $item = Item::with(['user', 'category', 'images'])->findOrFail($id);
        
        $whatsappLinkBuilder = app(WhatsAppLinkBuilder::class);
        $whatsappLink = $whatsappLinkBuilder->generateLink($item, auth()->user());
        
        return view('listing', compact('item', 'whatsappLink'));
    }

    function createItemPage() {
        if (!auth()->check()) {
            return redirect()->route('login')->with('info', 'Please log in to create a listing.');
        }

        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    function createItemSubmit(StoreItemRequest $request) {
        $item = Item::create([
            'user_id' => auth()->id(),
            'category_id' => $request->category_id,
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'condition' => $request->condition,
        ]);

        // Handle image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('images/items', 'public');
                
                ItemImage::create([
                    'item_id' => $item->id,
                    'image_path' => $path,
                    'order' => $index,
                ]);
            }

            // Set the first image as the main photo_url for backward compatibility
            $firstImage = $item->images()->first();
            if ($firstImage) {
                $item->update(['photo_url' => $firstImage->image_path]);
            }
        }

        return redirect()->route('items.view', $item->id)->with('success', 'Item listed successfully!');
    }

    function getEditItemPage($id) {
        $item = Item::findOrFail($id);
        $categories = Category::all();
        return view('items.edit', compact('item', 'categories'));
    }

    function editItem(Request $request, $id) {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|exists:categories,id',
            'condition' => 'required|in:Brand new,Like new,Lightly used,Well used,Heavily used',
        ], [
            'category_id.exists' => 'The selected category is invalid.',
            'name.required' => 'The name field is required.',
            'price.required' => 'The price field is required.',
            'price.numeric' => 'The price must be a number.',
            'price.min' => 'The price must be at least 0.',
            'name.max' => 'The name may not be greater than 255 characters.',
            'condition.in' => 'The selected condition is invalid.',
        ]);

        $item = Item::findOrFail($id);
        $item->update($request->all());
        return redirect()->route('items.index')->with('success', 'Item updated successfully.');
    }

    function deleteItem($id) {
        $item = Item::findOrFail($id);
        $item->delete();
        return redirect()->route('items.index')->with('success', 'Item deleted successfully.');
    }
}
