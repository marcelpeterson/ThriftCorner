@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4">
    <h1 class="text-3xl font-bold my-8">Create New News Article</h1>

    <div class="bg-white shadow-md rounded px-8 pt-6 pb-8 mb-4">
        {{-- IMPORTANT: enctype="multipart/form-data" is required for file uploads --}}
        <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="title">
                    Title
                </label>
                <input class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('title') border-red-500 @enderror" id="title" name="title" type="text" placeholder="Article Title" value="{{ old('title') }}">
                @error('title')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="thumbnail">
                    Thumbnail
                </label>
                <div class="space-y-4">
                    <div class="flex items-center justify-center w-full">
                        <label for="thumbnail" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP (MAX. 5MB)</p>
                            </div>
                            <input id="thumbnail" name="thumbnail" type="file" class="hidden" accept="image/*" onchange="previewThumbnail(this)"/>
                        </label>
                    </div>

                    <div id="thumbnail-preview" class="hidden">
                        <!-- Preview will be inserted here by JavaScript -->
                    </div>
                </div>
                @error('thumbnail')
                    <p class="mt-2 text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2" for="content">
                    Content
                </label>
                <textarea class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline @error('content') border-red-500 @enderror" id="content" name="content" rows="10" placeholder="Write your article content here...">{{ old('content') }}</textarea>
                @error('content')
                    <p class="text-red-500 text-xs italic">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline cursor-pointer" type="submit">
                    Create Article
                </button>
                <a class="inline-block align-baseline font-bold text-sm text-blue-500 hover:text-blue-800" href="{{ route('admin.news.index') }}">
                    Cancel
                </a>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    // Image preview function for thumbnail
    function previewThumbnail(input) {
        const previewContainer = document.getElementById('thumbnail-preview');
        const file = input.files[0];

        if (!file) {
            previewContainer.classList.add('hidden');
            return;
        }

        const reader = new FileReader();

        reader.onload = function(e) {
            previewContainer.innerHTML = `
                <div class="relative group">
                    <img src="${e.target.result}" alt="Thumbnail preview" class="w-full h-64 object-cover rounded-lg border-2 border-gray-300">
                    <div class="absolute top-2 left-2 bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded">
                        Thumbnail Preview
                    </div>
                </div>
            `;
            previewContainer.classList.remove('hidden');
        };

        reader.readAsDataURL(file);
    }
</script>
@endpush
@endsection