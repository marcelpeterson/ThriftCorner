@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-6 sm:py-8">
    {{-- Header --}}
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Edit News Article</h1>
        <p class="mt-1 text-xs sm:text-sm text-gray-600">Update article title, thumbnail, and content</p>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
        <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            {{-- Title Field --}}
            <div>
                <label for="title" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                    Article Title <span class="text-red-500">*</span>
                </label>
                <input type="text" id="title" name="title" value="{{ old('title', $news->title) }}" required
                       placeholder="Enter article title"
                       class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror">
                @error('title')
                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Thumbnail Upload --}}
            <div>
                <label class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                    Thumbnail <span class="text-gray-500 font-normal">(Optional: Upload a new image to replace)</span>
                </label>
                <div class="space-y-4">
                    <div class="flex items-center justify-center w-full">
                        <label for="thumbnail" class="flex flex-col items-center justify-center w-full h-40 sm:h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-4 sm:pt-5 pb-4 sm:pb-6 px-4">
                                <svg class="w-8 sm:w-12 h-8 sm:h-12 mb-2 sm:mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="mb-1 sm:mb-2 text-xs sm:text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP (MAX. 5MB)</p>
                            </div>
                            <input id="thumbnail" name="thumbnail" type="file" class="hidden" accept="image/*" onchange="previewThumbnail(this)"/>
                        </label>
                    </div>

                    {{-- New Thumbnail Preview --}}
                    <div id="thumbnail-preview" class="hidden">
                        <p class="text-xs sm:text-sm font-semibold text-gray-700 mb-2">New Thumbnail Preview:</p>
                        <div class="relative">
                            <img id="preview-img" src="" alt="New thumbnail preview" class="w-full aspect-video object-cover rounded-lg border-2 border-emerald-300">
                            <div class="absolute top-2 left-2 bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded">
                                New Thumbnail
                            </div>
                        </div>
                    </div>

                    {{-- Current Thumbnail --}}
                    @if ($news->thumbnail)
                        <div id="current-thumbnail">
                            <p class="text-xs sm:text-sm font-semibold text-gray-700 mb-2">Current Thumbnail:</p>
                            <div class="relative">
                                <img src="{{ Storage::url($news->thumbnail) }}" alt="Current thumbnail" class="w-full aspect-video object-cover rounded-lg border-2 border-gray-300">
                                <div class="absolute top-2 left-2 bg-blue-600 text-white text-xs font-bold px-2 py-1 rounded">
                                    Current
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
                @error('thumbnail')
                    <p class="mt-2 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Content Field --}}
            <div>
                <label for="content" class="block text-xs sm:text-sm font-semibold text-gray-700 mb-2">
                    Article Content <span class="text-red-500">*</span>
                </label>
                <textarea id="content" name="content" rows="8" required
                          placeholder="Write your article content here..."
                          class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('content') border-red-500 @enderror">{{ old('content', $news->content) }}</textarea>
                @error('content')
                    <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            {{-- Form Actions --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-3 sm:gap-4 pt-4 border-t border-gray-200">
                <a href="{{ route('admin.news.index') }}" class="w-full sm:w-auto text-xs sm:text-sm text-gray-600 hover:text-gray-900 font-medium text-center sm:text-left order-2 sm:order-1">
                    ← Back to News
                </a>
                <button type="submit" class="w-full sm:w-auto px-4 sm:px-6 py-2 sm:py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer order-1 sm:order-2">
                    <svg class="w-4 h-4 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Update Article
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    function previewThumbnail(input) {
        const previewContainer = document.getElementById('thumbnail-preview');
        const previewImg = document.getElementById('preview-img');
        const currentThumbnail = document.getElementById('current-thumbnail');
        const file = input.files[0];

        if (!file) {
            previewContainer.classList.add('hidden');
            if (currentThumbnail) {
                currentThumbnail.classList.remove('hidden');
            }
            return;
        }

        if (currentThumbnail) {
            currentThumbnail.classList.add('hidden');
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewContainer.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    }
</script>
@endpush
@endsection