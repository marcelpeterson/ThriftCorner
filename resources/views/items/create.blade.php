@extends('layouts.app')

@section('title', 'Create Listing - ' . config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-900">Create New Listing</h1>
        <p class="mt-2 text-gray-600">Fill in the details below to list your item on ThriftCorner</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-4">
            <div class="flex">
                <svg class="h-5 w-5 text-red-400" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-red-800">There were some errors with your submission:</h3>
                    <ul class="mt-2 text-sm text-red-700 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('items.create.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf

        {{-- Step 1: Images --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 font-bold mr-3">1</div>
                <h2 class="text-xl font-bold text-gray-900">Upload Images</h2>
            </div>
            <p class="text-sm text-gray-600 mb-4">Upload 1-5 images of your item. The first image will be the cover photo.</p>

            <div class="space-y-4">
                <div class="flex items-center justify-center w-full">
                    <label for="images" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-12 h-12 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP (MAX. 5MB per image)</p>
                            <p class="text-xs text-gray-500 mt-1">Up to 5 images</p>
                        </div>
                        <input id="images" name="images[]" type="file" class="hidden" accept="image/*" multiple onchange="previewImages(this)" required/>
                    </label>
                </div>

                <div id="image-preview" class="grid grid-cols-2 md:grid-cols-5 gap-4 hidden">
                    <!-- Previews will be inserted here by JavaScript -->
                </div>
            </div>
        </div>

        {{-- Step 2: Category & Item Name --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 font-bold mr-3">2</div>
                <h2 class="text-xl font-bold text-gray-900">Basic Information</h2>
            </div>

            <div class="space-y-4">
                {{-- Category --}}
                <div>
                    <label for="category_id" class="block text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Item Name --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-2">
                        Item Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required maxlength="255"
                           placeholder="e.g., MacBook Pro 13-inch, Calculus Textbook, etc."
                           class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Step 3: About Item --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-8 h-8 rounded-full bg-emerald-100 text-emerald-600 font-bold mr-3">3</div>
                <h2 class="text-xl font-bold text-gray-900">About Item</h2>
            </div>

            <div class="space-y-4">
                {{-- Condition --}}
                <div>
                    <label for="condition" class="block text-sm font-medium text-gray-700 mb-2">
                        Condition <span class="text-red-500">*</span>
                    </label>
                    <select id="condition" name="condition" required
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('condition') border-red-500 @enderror">
                        <option value="">Select condition</option>
                        <option value="Brand new" {{ old('condition') == 'Brand new' ? 'selected' : '' }}>Brand new</option>
                        <option value="Like new" {{ old('condition') == 'Like new' ? 'selected' : '' }}>Like new</option>
                        <option value="Lightly used" {{ old('condition') == 'Lightly used' ? 'selected' : '' }}>Lightly used</option>
                        <option value="Well used" {{ old('condition') == 'Well used' ? 'selected' : '' }}>Well used</option>
                        <option value="Heavily used" {{ old('condition') == 'Heavily used' ? 'selected' : '' }}>Heavily used</option>
                    </select>
                    @error('condition')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label for="price" class="block text-sm font-medium text-gray-700 mb-2">
                        Price (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-500">Rp</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" required min="0" max="99999999" step="1"
                               placeholder="0"
                               class="w-full pl-12 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price') border-red-500 @enderror">
                    </div>
                    @error('price')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="6" maxlength="2000"
                              placeholder="Describe your item in detail... (condition, features, reason for selling, etc.)"
                              class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    <p class="mt-1 text-sm text-gray-500">
                        <span id="char-count">0</span> / 2000 characters
                    </p>
                    @error('description')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex items-center justify-between">
            <a href="{{ route('home') }}" class="text-gray-600 hover:text-gray-900 font-medium">Cancel</a>
            <button type="submit"
                    class="inline-flex items-center px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg shadow-md transition-colors focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 cursor-pointer">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Create Listing
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
    // Character counter for description
    const descriptionTextarea = document.getElementById('description');
    const charCount = document.getElementById('char-count');

    if (descriptionTextarea && charCount) {
        descriptionTextarea.addEventListener('input', function() {
            charCount.textContent = this.value.length;
        });

        // Set initial count
        charCount.textContent = descriptionTextarea.value.length;
    }

    // Image preview function
    function previewImages(input) {
        const previewContainer = document.getElementById('image-preview');
        const files = Array.from(input.files);

        if (files.length === 0) {
            previewContainer.classList.add('hidden');
            return;
        }

        if (files.length > 5) {
            alert('You can only upload a maximum of 5 images.');
            input.value = '';
            previewContainer.classList.add('hidden');
            return;
        }

        previewContainer.innerHTML = '';
        previewContainer.classList.remove('hidden');

        files.forEach((file, index) => {
            const reader = new FileReader();

            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative group';
                div.innerHTML = `
                    <img src="${e.target.result}" class="w-full h-32 object-cover rounded-lg border-2 border-gray-200">
                    <div class="absolute top-2 left-2 bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded">
                        ${index === 0 ? 'Cover' : '#' + (index + 1)}
                    </div>
                `;
                previewContainer.appendChild(div);
            };

            reader.readAsDataURL(file);
        });
    }
</script>
@endpush
@endsection
