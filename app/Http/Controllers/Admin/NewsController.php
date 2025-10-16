<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\NewsArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class NewsController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::latest()->paginate(15);
        return view('admin.news.index', compact('articles'));
    }

    public function create()
    {
        return view('admin.news.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = null;
        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', config('filesystems.default'));
        }

        NewsArticle::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'slug' => Str::slug($validated['title']),
            'user_id' => auth()->id(),
            'thumbnail' => $path,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'News article created successfully.');
    }

    public function edit(NewsArticle $news)
    {
        return view('admin.news.edit', compact('news'));
    }

    public function update(Request $request, NewsArticle $news)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $path = $news->thumbnail;
        if ($request->hasFile('thumbnail')) {
            if ($news->thumbnail) {
                Storage::disk(config('filesystems.default'))->delete($news->thumbnail);
            }
            $path = $request->file('thumbnail')->store('thumbnails', config('filesystems.default'));
        }

        $news->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'slug' => Str::slug($validated['title']),
            'thumbnail' => $path,
        ]);

        return redirect()->route('admin.news.index')->with('success', 'News article updated successfully.');
    }

    public function destroy(NewsArticle $news)
    {
        if ($news->thumbnail) {
            Storage::disk(config('filesystems.default'))->delete($news->thumbnail);
        }

        $news->delete();
        return redirect()->route('admin.news.index')->with('success', 'News article deleted successfully.');
    }
}