@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-8">News & Articles</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse ($articles as $article)
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                {{-- Thumbnail section --}}
                @if($article->thumbnail)
                    <a href="{{ route('news.show', $article->slug) }}">
                        <img class="w-full h-48 object-cover" src="{{ asset('storage/' . $article->thumbnail) }}" alt="{{ $article->title }}">
                    </a>
                @endif

                {{-- Content section --}}
                <div class="p-6">
                    <h2 class="font-bold text-xl mb-2">{{ $article->title }}</h2>
                    <p class="text-gray-700 text-base">
                        {{ Str::limit($article->content, 150) }}
                    </p>
                    <a href="{{ route('news.show', $article->slug) }}" class="text-indigo-500 hover:text-indigo-600 font-semibold mt-4 inline-block">Read More</a>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-12">
                <p class="text-gray-500 text-lg">No news articles have been posted yet. Please check back later!</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination Links --}}
    <div class="mt-8">
        {{ $articles->links() }}
    </div>
</div>
@endsection