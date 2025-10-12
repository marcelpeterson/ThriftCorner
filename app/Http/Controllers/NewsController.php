<?php

namespace App\Http\Controllers;

use App\Models\NewsArticle;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index()
    {
        $articles = NewsArticle::latest()->paginate(10);
        return view('news.index', compact('articles'));
    }

    public function show(NewsArticle $article)
    {
        return view('news.show', compact('article'));
    }
}