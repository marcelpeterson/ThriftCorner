@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-4xl font-bold mb-4">{{ $article->title }}</h1>
        <p class="text-gray-600 mb-8">Published on {{ $article->created_at->format('M d, Y') }} by {{ $article->user->name }}</p>

        <div class="prose max-w-none">
            {!! nl2br(e($article->content)) !!}
        </div>
    </div>
</div>
@endsection