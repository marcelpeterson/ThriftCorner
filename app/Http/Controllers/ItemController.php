<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use App\Services\WhatsAppLinkBuilder;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    function getItemPage() {
        $items = Item::all();
        return view('home', compact('items'));
    }

    function viewItem($id) {
        $item = Item::with(['user', 'category'])->findOrFail($id);
        
        $whatsappLinkBuilder = app(WhatsAppLinkBuilder::class);
        $whatsappLink = $whatsappLinkBuilder->generateLink($item, auth()->user());
        
        return view('listing', compact('item', 'whatsappLink'));
    }

    function getCreateItemPage() {
        $categories = Category::all();
        return view('items.create', compact('categories'));
    }

    function createItem(Request $request) {
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

        Item::create($request->all());
        return redirect()->route('items.index')->with('success', 'Item created successfully.');
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
