@extends('layouts.app')

@section('title', 'Welcome')

@push('head')
<script>
document.addEventListener('alpine:init', () => {
    Alpine.data('carousel', (totalSlides) => ({
        currentSlide: 0,
        totalSlides: totalSlides,
        isPaused: false,
        timer: null,
        touchStartX: 0,
        touchEndX: 0,

        init() {
            // this.startAutoplay();
            this.setupTouchListeners();
        },

        setupTouchListeners() {
            const carousel = this.$el;
            carousel.addEventListener('touchstart', (e) => {
                this.handleTouchStart(e);
            }, false);
            carousel.addEventListener('touchend', (e) => {
                this.handleTouchEnd(e);
            }, false);
        },

        handleTouchStart(e) {
            this.touchStartX = e.changedTouches[0].screenX;
            this.isPaused = true;
        },

        handleTouchEnd(e) {
            this.touchEndX = e.changedTouches[0].screenX;
            this.handleSwipe();
            this.isPaused = false;
        },

        handleSwipe() {
            const swipeThreshold = 50; // Minimum distance to register a swipe
            const diff = this.touchStartX - this.touchEndX;

            if (Math.abs(diff) > swipeThreshold) {
                if (diff > 0) {
                    // Swiped left - go to next slide
                    this.currentSlide = (this.currentSlide + 1) % this.totalSlides;
                } else {
                    // Swiped right - go to previous slide
                    this.currentSlide = this.currentSlide === 0 ? this.totalSlides - 1 : this.currentSlide - 1;
                }
            }
        },

        startAutoplay() {
            const self = this;
            this.timer = setInterval(function() {
                if (!self.isPaused) {
                    self.currentSlide = (self.currentSlide + 1) % self.totalSlides;
                }
            }, 5000);
        }
    }));
});
</script>
@endpush

@section('content')
<div class="pb-10 pt-5">
    {{-- Hero Banner Carousel --}}
    <div class="relative mb-12" x-data="carousel({{ $heroItems->count() + 3 }})">
        <div class="relative rounded-2xl md:rounded-[48px] overflow-hidden shadow-xl h-[250px] sm:h-[300px] md:h-[400px]"
             @mouseenter="isPaused = true"
             @mouseleave="isPaused = false">
            @foreach($heroItems as $index => $heroItem)
                {{-- Slide {{ $index }}: Hero Banner from Premium Listing --}}
                <a href="{{ route('items.view', $heroItem->id) }}" class="absolute inset-0 transition-opacity duration-750 cursor-pointer group"
                   :class="currentSlide === {{ $index }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                    <div class="relative h-[250px] sm:h-[300px] md:h-[400px] transform transition-transform duration-300 group-hover:scale-[1.02]">
                        {{-- Background Image --}}
                        @if($heroItem->images->count() > 0)
                            <div class="absolute inset-0">
                                {{-- Blurred Background --}}
                                <div class="absolute inset-0">
                                    <img src="{{ Storage::url($heroItem->images->first()->image_path) }}" alt="" class="w-full h-full object-cover blur-2xl scale-110 opacity-60">
                                </div>
                                {{-- Actual Image --}}
                                <img src="{{ Storage::url($heroItem->images->first()->image_path) }}" alt="{{ $heroItem->name }}" class="relative w-full h-full object-contain z-10">
                                {{-- Overlay Gradient --}}
                                <div class="absolute inset-0 bg-gradient-to-r from-black/70 via-black/50 to-transparent"></div>
                            </div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-r from-gray-800 to-gray-600"></div>
                        @endif

                        {{-- Content --}}
                        <div class="relative h-full flex flex-col justify-center px-5 sm:px-8 md:px-24 z-10">
                            <div class="inline-block bg-gradient-to-r from-blue-500 to-cyan-500 text-white text-xs sm:text-sm font-bold px-3 sm:px-4 py-1 sm:py-2 rounded-full mb-2 sm:mb-4 w-fit shadow-lg">
                                🎯 HERO FEATURED
                            </div>
                            <h1 class="text-2xl sm:text-4xl md:text-5xl font-bold max-md:font-black text-white mb-0 sm:mb-4 drop-shadow-lg">
                                {{ $heroItem->name }}
                            </h1>
                            <p class="text-xl sm:text-3xl md:text-4xl font-bold max-md:font-black text-cyan-400 mb-4 sm:mb-6 drop-shadow-lg">
                                {{ $heroItem->price_rupiah }}
                            </p>
                            <div class="flex items-center gap-4">
                                <div class="bg-white/90 backdrop-blur-sm px-4 sm:px-6 py-2 sm:py-3 rounded-full font-bold text-xs sm:text-sm md:text-base text-gray-900 shadow-xl group-hover:bg-white transition-colors">
                                    View Listing →
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            @endforeach

            @php
                $heroCount = $heroItems->count();
            @endphp

            {{-- Slide {{ $heroCount }}: ThriftCorner Welcome --}}
            <div class="absolute inset-0 transition-opacity duration-750"
                 :class="currentSlide === {{ $heroCount }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <div class="bg-gray-900 relative h-[250px] sm:h-[300px] md:h-[400px]">
                    <div class="text-white sm:px-8 md:px-0 md:ml-24 md:pt-20 max-w-2xl pt-11 px-5">
                        <h1 class="text-2xl sm:text-4xl md:text-[4rem] md:font-bold font-extrabold tracking-tight">
                            {{ config('app.name', 'ThriftCorner') }}
                        </h1>
                        <p class="md:mt-4 mt-2 md:ml-2 sm:mt-2 text-md sm:text-2xl md:text-3xl md:font-bold font-semibold text-gray-100">
                            Binusian favorite place for second-hand gems.
                        </p>
                        <p class="md:mt-2 mt-1 md:ml-2 sm:mt-2 text-xs sm:text-sm md:text-base text-gray-300">
                            A simple marketplace for Binus students to buy and sell textbooks, electronics, and dorm essentials.
                        </p>
                        <button class="bg-white text-gray-900 font-bold mt-4 sm:mt-5 px-6 sm:px-8 py-2 sm:py-3 rounded-full hover:bg-blue-50 transition-colors shadow-lg cursor-pointer text-sm sm:text-base">
                            @if (Route::has('items.create'))
                                <a href="{{ auth()->check() ? route('items.create') : route('login') }}">Sell Now →</a>
                            @endif
                        </button>
                    </div>
                    <img src="https://storage.thriftcorner.store/assets/bags.png" alt="" class="absolute bottom-0 right-0 w-full max-w-[150px] hidden md:block md:max-w-[450px]">
                </div>
            </div>

            {{-- Slide {{ $heroCount + 1 }}: Dummy Ad - Electronics Sale --}}
            <div class="absolute inset-0 transition-opacity duration-750"
                 :class="currentSlide === {{ $heroCount + 1 }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 flex items-center justify-between h-[250px] sm:h-[300px] md:h-[400px] px-4 sm:px-8 md:px-24">
                    <div class="text-white max-w-2xl">
                        <div class="inline-block bg-yellow-400 text-blue-900 text-xs font-bold px-3 py-1 rounded-full mb-2 sm:mb-4">
                            SPONSORED AD
                        </div>
                        <h2 class="text-2xl sm:text-4xl md:text-5xl font-bold mb-2 sm:mb-4">
                            📱 Electronics Clearance!
                        </h2>
                        <p class="text-lg sm:text-2xl mb-2 sm:mb-4 ml-2">Up to <span class="text-yellow-400 font-bold">50% OFF</span></p>
                        <p class="text-sm sm:text-lg text-blue-100 mb-4 sm:mb-6 ml-2 hidden md:block">
                            Laptops, tablets, phones & accessories. Limited time offer!
                        </p>
                        <button class="bg-white text-blue-600 font-bold px-6 sm:px-8 py-2 sm:py-3 rounded-full hover:bg-blue-50 transition-colors shadow-lg text-sm sm:text-base">
                            Shop Now →
                        </button>
                    </div>
                </div>
            </div>

            {{-- Slide {{ $heroCount + 2 }}: Dummy Ad - Textbook Exchange --}}
            <div class="absolute inset-0 transition-opacity duration-750"
                 :class="currentSlide === {{ $heroCount + 2 }} ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 flex items-center justify-between h-[250px] sm:h-[300px] md:h-[400px] px-4 sm:px-8 md:px-24">
                    <div class="text-white max-w-2xl">
                        <div class="inline-block bg-orange-400 text-emerald-900 text-xs font-bold px-3 py-1 rounded-full mb-2 sm:mb-4">
                            SPONSORED AD
                        </div>
                        <h2 class="text-2xl sm:text-4xl md:text-5xl font-bold mb-2 sm:mb-4">
                            📚 Textbook Season!
                        </h2>
                        <p class="text-lg sm:text-2xl mb-2 sm:mb-4 ml-2">Save on <span class="text-yellow-300 font-bold">Course Books</span></p>
                        <p class="text-sm sm:text-lg text-emerald-100 mb-4 sm:mb-6 ml-2 hidden md:block">
                            Find your semester books at student-friendly prices. Buy & sell with ease!
                        </p>
                        <button class="bg-white text-emerald-600 font-bold px-6 sm:px-8 py-2 sm:py-3 rounded-full hover:bg-emerald-50 transition-colors shadow-lg text-sm sm:text-base">
                            Browse Books →
                        </button>
                    </div>
                </div>
            </div>

            {{-- Navigation Arrows --}}
            <button @click="currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1"
                    class="hidden sm:flex absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-3 transition-all z-20 shadow-lg cursor-pointer items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="currentSlide = currentSlide === totalSlides - 1 ? 0 : currentSlide + 1"
                    class="hidden sm:flex absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-3 transition-all z-20 shadow-lg cursor-pointer items-center justify-center">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Slide Indicators --}}
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                {{-- Hero item indicators --}}
                @foreach($heroItems as $index => $heroItem)
                    <button @click="currentSlide = {{ $index }}"
                            class="w-2 h-2 rounded-full transition-all"
                            :class="currentSlide === {{ $index }} ? 'bg-white w-8' : 'bg-white/50'">
                    </button>
                @endforeach
                
                {{-- Default slide indicators --}}
                <button @click="currentSlide = {{ $heroCount }}"
                        class="w-2 h-2 rounded-full transition-all"
                        :class="currentSlide === {{ $heroCount }} ? 'bg-white w-8' : 'bg-white/50'">
                </button>
                <button @click="currentSlide = {{ $heroCount + 1 }}"
                        class="w-2 h-2 rounded-full transition-all"
                        :class="currentSlide === {{ $heroCount + 1 }} ? 'bg-white w-8' : 'bg-white/50'">
                </button>
                <button @click="currentSlide = {{ $heroCount + 2 }}"
                        class="w-2 h-2 rounded-full transition-all"
                        :class="currentSlide === {{ $heroCount + 2 }} ? 'bg-white w-8' : 'bg-white/50'">
                </button>
            </div>

        </div>

        {{-- Ad Space Info Badge --}}
        <div class="mt-4 flex items-center justify-center gap-2 text-xs md:text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="italic">Premium ad space available - Contact us to advertise here</span>
        </div>
    </div>

    {{-- Featured Listings Section --}}
    {{-- @if($featuredItems->count() > 0)
        <div class="mt-12 bg-gradient-to-r from-purple-50 to-blue-50 rounded-2xl p-8 border-2 border-purple-200">
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-purple-600 to-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                        </svg>
                    </div>
                    <div>
                        <h2 class="text-2xl font-bold text-gray-900">Featured Listings</h2>
                        <p class="text-sm text-gray-600">Premium listings from verified sellers</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($featuredItems as $item)
                    <x-listing-card :item="$item" :featured="true" />
                @endforeach
            </div>
        </div>
    @endif --}}

    <div>
        {{-- Search and Filter Section --}}
        <div class="mt-12 bg-white rounded-lg shadow-sm border border-gray-200 p-6">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-2xl font-bold text-gray-900">
                    @if(request('q'))
                        Search Results for "{{ request('q') }}"
                    @else
                        Explore ThriftCorner
                    @endif
                </h2>
                <span class="text-sm text-gray-600">{{ $items->total() }} item(s) found</span>
            </div>

            {{-- Filters --}}
            <form method="GET" action="{{ route('home') }}" class="space-y-4">
                @if(request('q'))
                    <input type="hidden" name="q" value="{{ request('q') }}">
                @endif

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    {{-- Category Filter --}}
                    <div>
                        <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select name="category" id="category" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">All Categories</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Condition Filter --}}
                    <div>
                        <label for="condition" class="block text-sm font-medium text-gray-700 mb-1">Condition</label>
                        <select name="condition" id="condition" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="">All Conditions</option>
                            <option value="Brand new" {{ request('condition') == 'Brand new' ? 'selected' : '' }}>Brand new</option>
                            <option value="Like new" {{ request('condition') == 'Like new' ? 'selected' : '' }}>Like new</option>
                            <option value="Lightly used" {{ request('condition') == 'Lightly used' ? 'selected' : '' }}>Lightly used</option>
                            <option value="Well used" {{ request('condition') == 'Well used' ? 'selected' : '' }}>Well used</option>
                            <option value="Heavily used" {{ request('condition') == 'Heavily used' ? 'selected' : '' }}>Heavily used</option>
                        </select>
                    </div>

                    {{-- Price Range --}}
                    <div>
                        <label for="min_price" class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                        <input type="number" name="min_price" id="min_price" value="{{ request('min_price') }}" placeholder="Rp 0" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>

                    <div>
                        <label for="max_price" class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                        <input type="number" name="max_price" id="max_price" value="{{ request('max_price') }}" placeholder="Rp 999,999,999" class="w-full rounded-md border border-gray-300 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                    </div>
                </div>

                <div class="flex items-center justify-between">
                    {{-- Sort Options --}}
                    <div class="flex items-center gap-2">
                        <label for="sort" class="text-sm font-medium text-gray-700 max-md:text-right">Sort by:</label>
                        <select name="sort" id="sort" class="rounded-md border border-gray-300 px-3 py-2 max-md:px-2 max-md:ml-1 text-sm focus:border-blue-500 focus:outline-none focus:ring-1 focus:ring-blue-500">
                            <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Newest First</option>
                            <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Oldest First</option>
                            <option value="price_asc" {{ request('sort') == 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                            <option value="price_desc" {{ request('sort') == 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        </select>
                    </div>

                    {{-- Filter Actions --}}
                    <div class="flex items-center gap-2">
                        <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-gray-900 underline mr-2 max-md:text-center max-md:ml-2 max-md:mr-0">Clear Filters</a>
                        <button type="submit" class="bg-blue-700 text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-blue-800 transition-colors cursor-pointer max-md:px-4">
                            Apply Filters
                        </button>
                    </div>
                </div>
            </form>
        </div>

        {{-- Listings Grid --}}
        @if(count($items) > 0)
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    <x-listing-card :item="$item" />
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="mt-8">
                {{ $items->links() }}
            </div>
        @else
            <div class="mt-8 text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900">No listings found</h3>
                <p class="mt-2 text-sm text-gray-600">
                    @if(request('q') || request()->hasAny(['category', 'condition', 'min_price', 'max_price']))
                        Try adjusting your search or filters to find what you're looking for.
                    @else
                        No listings available at the moment. Please check back later.
                    @endif
                </p>
                @if(request('q') || request()->hasAny(['category', 'condition', 'min_price', 'max_price']))
                    <a href="{{ route('home') }}" class="mt-4 inline-block text-blue-700 hover:text-blue-800 font-medium">
                        Clear all filters
                    </a>
                @endif
            </div>
        @endif
    </div>
</div>
@endsection
