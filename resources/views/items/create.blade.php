@extends('layouts.app')

@section('title', 'Create Listing - ' . config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 py-2">
    <div class="mb-6 sm:mb-8">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-900">Create New Listing</h1>
        <p class="mt-2 text-xs sm:text-sm text-gray-600">Fill in the details below to list your item on ThriftCorner</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg bg-red-50 border border-red-200 p-3 sm:p-4">
            <div class="flex flex-col sm:flex-row gap-3">
                <svg class="h-5 w-5 text-red-400 flex-shrink-0 mt-0.5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-xs sm:text-sm font-medium text-red-800">There were some errors with your submission:</h3>
                    <ul class="mt-2 text-xs sm:text-sm text-red-700 list-disc list-inside space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <form action="{{ route('items.create.submit') }}" method="POST" enctype="multipart/form-data" class="space-y-6 sm:space-y-8">
        @csrf

        {{-- Step 1: Images --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-7 sm:w-8 h-7 sm:h-8 rounded-full bg-emerald-100 text-emerald-600 font-bold mr-2 sm:mr-3 text-xs sm:text-sm">1</div>
                <h2 class="text-base sm:text-xl font-bold text-gray-900">Upload Images</h2>
            </div>
            <p class="text-xs sm:text-sm text-gray-600 mb-4">Upload 1-5 images of your item. The first image will be the cover photo.</p>

            <div class="space-y-4">
                <div class="flex items-center justify-center w-full">
                    <button type="button" onclick="showPhotoGuidelinesModal()" class="flex flex-col items-center justify-center w-full h-48 sm:h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                        <div class="flex flex-col items-center justify-center pt-4 sm:pt-5 pb-4 sm:pb-6 px-4">
                            <svg class="w-10 sm:w-12 h-10 sm:h-12 mb-2 sm:mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
                            </svg>
                            <p class="mb-1 sm:mb-2 text-xs sm:text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500">PNG, JPG, GIF, WebP (MAX. 5MB per image)</p>
                            <p class="text-xs text-gray-500 mt-1">Up to 5 images</p>
                        </div>
                    </button>
                    <input id="images" name="images[]" type="file" class="hidden" accept="image/*" multiple onchange="previewImages(this)" required/>
                </div>

                <div id="image-preview" class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-5 gap-2 sm:gap-4 hidden">
                    <!-- Previews will be inserted here by JavaScript -->
                </div>
            </div>
        </div>

        {{-- Step 2: Category & Item Name --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-7 sm:w-8 h-7 sm:h-8 rounded-full bg-emerald-100 text-emerald-600 font-bold mr-2 sm:mr-3 text-xs sm:text-sm">2</div>
                <h2 class="text-base sm:text-xl font-bold text-gray-900">Basic Information</h2>
            </div>

            <div class="space-y-4">
                {{-- Category --}}
                <div>
                    <label for="category_id" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                        Category <span class="text-red-500">*</span>
                    </label>
                    <select id="category_id" name="category_id" required
                            class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('category_id') border-red-500 @enderror">
                        <option value="">Select a category</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('category_id')
                        <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Item Name --}}
                <div>
                    <label for="name" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                        Item Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required maxlength="255"
                           placeholder="e.g., MacBook Pro 13-inch, Calculus Textbook, etc."
                           class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('name') border-red-500 @enderror">
                    @error('name')
                        <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Step 3: About Item --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 sm:p-6">
            <div class="flex items-center mb-4">
                <div class="flex items-center justify-center w-7 sm:w-8 h-7 sm:h-8 rounded-full bg-emerald-100 text-emerald-600 font-bold mr-2 sm:mr-3 text-xs sm:text-sm">3</div>
                <h2 class="text-base sm:text-xl font-bold text-gray-900">About Item</h2>
            </div>

            <div class="space-y-4">
                {{-- Condition --}}
                <div>
                    <label for="condition" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                        Condition <span class="text-red-500">*</span>
                    </label>
                    <select id="condition" name="condition" required
                            class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('condition') border-red-500 @enderror">
                        <option value="">Select condition</option>
                        <option value="Brand new" {{ old('condition') == 'Brand new' ? 'selected' : '' }}>Brand new</option>
                        <option value="Like new" {{ old('condition') == 'Like new' ? 'selected' : '' }}>Like new</option>
                        <option value="Lightly used" {{ old('condition') == 'Lightly used' ? 'selected' : '' }}>Lightly used</option>
                        <option value="Well used" {{ old('condition') == 'Well used' ? 'selected' : '' }}>Well used</option>
                        <option value="Heavily used" {{ old('condition') == 'Heavily used' ? 'selected' : '' }}>Heavily used</option>
                    </select>
                    @error('condition')
                        <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Price --}}
                <div>
                    <label for="price" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                        Price (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <span class="absolute left-3 sm:left-4 top-1/2 -translate-y-1/2 text-gray-500 text-xs sm:text-sm">Rp</span>
                        <input type="number" id="price" name="price" value="{{ old('price') }}" required min="0" max="99999999" step="1"
                               placeholder="0"
                               class="w-full pl-10 sm:pl-12 pr-3 sm:pr-4 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('price') border-red-500 @enderror">
                    </div>
                    @error('price')
                        <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Description --}}
                <div>
                    <label for="description" class="block text-xs sm:text-sm font-medium text-gray-700 mb-2">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="4 sm:rows-6" maxlength="2000"
                              placeholder="Describe your item in detail... (condition, features, reason for selling, etc.)"
                              class="w-full px-3 sm:px-4 py-2 text-xs sm:text-sm border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent @error('description') border-red-500 @enderror">{{ old('description') }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">
                        <span id="char-count">0</span> / 2000 characters
                    </p>
                    @error('description')
                        <p class="mt-1 text-xs sm:text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Submit Button --}}
        <div class="flex flex-row items-center justify-between gap-3 sm:gap-4">
            <a href="{{ route('home') }}" class="text-md max-md:text-sm text-gray-600 hover:text-gray-900 font-medium order-1">Cancel</a>
            <button type="submit"
                    class="w-auto inline-flex items-center justify-center px-6 sm:px-6 py-3 sm:py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs sm:text-sm rounded-lg shadow-md transition-colors focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 cursor-pointer order-1 sm:order-2">
                <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Create Listing
            </button>
        </div>
    </form>
</div>

{{-- Photo Guidelines Modal --}}
<div id="photoGuidelinesModal" class="hidden fixed inset-0 bg-gray-900/30 backdrop-blur-sm z-50 flex items-center justify-center p-3 sm:p-4">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto">
        {{-- Modal Header --}}
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-4 sm:px-6 py-3 sm:py-4 rounded-t-2xl sticky top-0">
            <div class="flex items-center justify-between gap-3">
                <h3 class="text-base sm:text-xl font-bold text-white flex items-center gap-2">
                    <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="hidden sm:inline">Photo Quality Guidelines</span>
                    <span class="inline sm:hidden">Photo Guidelines</span>
                </h3>
                <button type="button" onclick="closePhotoGuidelinesModal()" class="text-white hover:text-gray-200 transition-colors cursor-pointer flex-shrink-0">
                    <svg class="w-5 sm:w-6 h-5 sm:h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Modal Body --}}
        <div class="p-4 sm:p-6 space-y-4 sm:space-y-6">
            {{-- Introduction --}}
            <div class="bg-blue-50 border-l-4 border-blue-500 p-3 sm:p-4 rounded">
                <p class="text-xs sm:text-sm text-blue-800">
                    <strong>High-quality photos help sell faster!</strong> Follow these guidelines to make your listing stand out.
                </p>
            </div>

            {{-- Guidelines Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-3 sm:gap-4">
                {{-- DO's --}}
                <div class="space-y-2 sm:space-y-3">
                    <h4 class="font-bold text-gray-900 flex items-center text-xs sm:text-sm">
                        <svg class="w-4 sm:w-5 h-4 sm:h-5 text-green-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        DO's ✓
                    </h4>
                    <ul class="space-y-1 text-xs sm:text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 flex-shrink-0">•</span>
                            <span>Use <strong>good lighting</strong> (natural light is best)</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 flex-shrink-0">•</span>
                            <span>Take photos from <strong>multiple angles</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 flex-shrink-0">•</span>
                            <span>Show <strong>all important details</strong> and features</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 flex-shrink-0">•</span>
                            <span>Use a <strong>clean, uncluttered background</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 flex-shrink-0">•</span>
                            <span>Keep photos <strong>clear and in focus</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-green-500 flex-shrink-0">•</span>
                            <span>Show any <strong>defects or wear</strong> honestly</span>
                        </li>
                    </ul>
                </div>

                {{-- DON'Ts --}}
                <div class="space-y-2 sm:space-y-3">
                    <h4 class="font-bold text-gray-900 flex items-center text-xs sm:text-sm">
                        <svg class="w-4 sm:w-5 h-4 sm:h-5 text-red-500 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        DON'Ts ✗
                    </h4>
                    <ul class="space-y-1 text-xs sm:text-sm text-gray-700">
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 flex-shrink-0">•</span>
                            <span>Don't use <strong>blurry or dark photos</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 flex-shrink-0">•</span>
                            <span>Don't use <strong>stock photos</strong> from internet</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 flex-shrink-0">•</span>
                            <span>Avoid <strong>excessive filters</strong> or editing</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 flex-shrink-0">•</span>
                            <span>Don't include <strong>personal information</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 flex-shrink-0">•</span>
                            <span>Avoid <strong>messy backgrounds</strong></span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="text-red-500 flex-shrink-0">•</span>
                            <span>Don't hide <strong>defects or issues</strong></span>
                        </li>
                    </ul>
                </div>
            </div>

            {{-- Photo Tips --}}
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-3 sm:p-4">
                <h4 class="font-bold text-amber-900 mb-2 flex items-center text-xs sm:text-sm">
                    <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Pro Tips
                </h4>
                <ul class="space-y-1 text-xs sm:text-sm text-amber-800">
                    <li>• <strong>First photo matters most</strong> - Make it your best shot!</li>
                    <li>• Include <strong>serial numbers or tags</strong> for authenticity</li>
                </ul>
            </div>

            {{-- Technical Requirements --}}
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-3 sm:p-4">
                <h4 class="font-bold text-gray-900 mb-2 text-xs sm:text-sm">Technical Requirements</h4>
                <ul class="space-y-1 text-xs sm:text-sm text-gray-700">
                    <li>• <strong>Format:</strong> JPG, PNG, GIF, or WebP</li>
                    <li>• <strong>Size:</strong> Maximum 5MB per image</li>
                    <li>• <strong>Quantity:</strong> 1-5 images (first image is the cover)</li>
                    <li>• <strong>Resolution:</strong> At least 800x800 pixels recommended</li>
                </ul>
            </div>
        </div>

        {{-- Modal Footer --}}
        <div class="bg-gray-50 px-4 sm:px-6 py-3 sm:py-4 rounded-b-2xl flex flex-col sm:flex-row items-center justify-between gap-2 sm:gap-4 border-t border-gray-200 sticky bottom-0">
            <button type="button" onclick="closePhotoGuidelinesModal()" class="w-full sm:w-auto max-md:py-2 text-sm sm:text-sm text-gray-600 hover:text-gray-900 font-medium transition-colors cursor-pointer order-2 sm:order-1">
                Cancel
            </button>
            <button type="button" onclick="proceedToUpload()" class="w-full sm:w-auto inline-flex items-center justify-center px-4 sm:px-6 py-2 sm:py-2.5 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold text-sm sm:text-sm rounded-lg shadow-md transition-colors cursor-pointer focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 order-1 sm:order-2">
                <svg class="w-4 sm:w-5 h-6 sm:h-5 mr-1 sm:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Continue
            </button>
        </div>
    </div>
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

    // Modal functions
    function showPhotoGuidelinesModal() {
        const modal = document.getElementById('photoGuidelinesModal');
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden'; // Prevent background scrolling
    }

    function closePhotoGuidelinesModal() {
        const modal = document.getElementById('photoGuidelinesModal');
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto'; // Re-enable scrolling
    }

    function proceedToUpload() {
        closePhotoGuidelinesModal();
        const fileInput = document.getElementById('images');
        fileInput.click();
    }

    // Close modal when clicking outside
    document.getElementById('photoGuidelinesModal')?.addEventListener('click', function(e) {
        if (e.target === this) {
            closePhotoGuidelinesModal();
        }
    });

    // Close modal with Escape key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('photoGuidelinesModal');
            if (modal && !modal.classList.contains('hidden')) {
                closePhotoGuidelinesModal();
            }
        }
    });

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
                    <img src="${e.target.result}" class="w-full aspect-square object-cover rounded-lg border-2 border-gray-200">
                    <div class="absolute top-1 sm:top-2 left-1 sm:left-2 bg-emerald-600 text-white text-xs font-bold px-2 py-1 rounded">
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
