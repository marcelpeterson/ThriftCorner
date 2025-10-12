@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-8">Edit News Article</h1>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        {{-- IMPORTANT: enctype="multipart/form-data" is required for file uploads --}}
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" id="title" name="title" type="text" placeholder="Article Title" value="{{ old('title', $news->title) }}">
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="thumbnail">
                    Thumbnail (Optional: Choose a new one to replace the existing)
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('thumbnail') border-red-500 @enderror" id="thumbnail" name="thumbnail" type="file">
                @error('thumbnail')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror

                @if ($news->thumbnail)
                    <div class="mt-4">
                        <p class="text-sm font-semibold">Current Thumbnail:</p>
                        <img src="{{ asset('storage/' . $news->thumbnail) }}" alt="Current thumbnail" class="w-48 h-auto rounded mt-2">
                    </div>
                @endif
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                    Content
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('content') border-red-500 @enderror" id="content" name="content" rows="10" placeholder="Write your article content here...">{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline" type="submit">
                    Update Article
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('admin.news.index') }}">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection