@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <div class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-4xl font-bold mb-4 max-md:mb-2 max-md:font-extrabold max-md:text-2xl">{{ $article->title }}</h1>
        <p class="text-gray-600 mb-8 max-md:text-sm max-md:mb-5">Published on {{ $article->created_at->format('M d, Y') }} by {{ $article->user->first_name }}</p>
        @if($article->thumbnail)
            <img class="w-full h-96 object-cover mb-8 max-md:mb-5 rounded-lg" src="{{ Storage::url($article->thumbnail) }}" alt="{{ $article->title }}">
        @endif
        <div class="prose max-w-none max-md:text-sm">
            {!! nl2br(e($article->content)) !!}
        </div>
    </div>
</div>
@endsection