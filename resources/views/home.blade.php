@extends('layouts.app')

@section('title', 'Welcome')

@section('content')
<div class="py-10">
    {{-- Hero Banner Carousel (Ad Space) --}}
    <div class="relative mb-12" x-data="{ currentSlide: 0, totalSlides: 3 }">
        <div class="relative rounded-[48px] overflow-hidden shadow-xl h-[400px]">
            {{-- Slide 1: ThriftCorner Welcome --}}
            <div class="absolute inset-0 transition-opacity duration-750" 
                 :class="currentSlide === 0 ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <div class="bg-gray-900 relative h-[400px]">
                    <div class="text-white ml-24 pt-22 max-w-2xl">
                        <h1 class="text-[4rem] font-bold tracking-tight sm:text-[4rem]">
                            {{ config('app.name', 'ThriftCorner') }}
                        </h1>
                        <p class="mt-2 text-3xl font-bold text-gray-100">
                            Binusian favorite place for second-hand gems.
                        </p>
                        <p class="mt-2 text-gray-300">
                            A simple marketplace for Binus students to buy and sell textbooks, electronics, and dorm essentials.
                        </p>
                    </div>
                    <img src="{{ asset('storage/images/bags.png') }}" alt="" class="absolute bottom-0 right-0 w-full max-w-[450px]">
                </div>
            </div>

            {{-- Slide 2: Dummy Ad - Electronics Sale --}}
            <div class="absolute inset-0 transition-opacity duration-750" 
                 :class="currentSlide === 1 ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <div class="bg-gradient-to-r from-blue-600 to-blue-800 flex items-center justify-between h-[400px] px-24">
                    <div class="text-white max-w-2xl">
                        <div class="inline-block bg-yellow-400 text-blue-900 text-xs font-bold px-3 py-1 rounded-full mb-4">
                            SPONSORED AD
                        </div>
                        <h2 class="text-5xl font-bold mb-4">
                            📱 Electronics Clearance!
                        </h2>
                        <p class="text-2xl mb-4 ml-2">Up to <span class="text-yellow-400 font-bold">50% OFF</span></p>
                        <p class="text-lg text-blue-100 mb-6 ml-2">
                            Laptops, tablets, phones & accessories. Limited time offer!
                        </p>
                        <button class="bg-white text-blue-600 font-bold px-8 py-3 rounded-full hover:bg-blue-50 transition-colors shadow-lg">
                            Shop Now →
                        </button>
                    </div>
                </div>
            </div>

            {{-- Slide 3: Dummy Ad - Textbook Exchange --}}
            <div class="absolute inset-0 transition-opacity duration-750" 
                 :class="currentSlide === 2 ? 'opacity-100 z-10' : 'opacity-0 z-0'">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 flex items-center justify-between h-[400px] px-24">
                    <div class="text-white max-w-2xl">
                        <div class="inline-block bg-orange-400 text-emerald-900 text-xs font-bold px-3 py-1 rounded-full mb-4">
                            SPONSORED AD
                        </div>
                        <h2 class="text-5xl font-bold mb-4">
                            📚 Textbook Season!
                        </h2>
                        <p class="text-2xl mb-4 ml-2">Save on <span class="text-yellow-300 font-bold">Course Books</span></p>
                        <p class="text-lg text-emerald-100 mb-6 ml-2">
                            Find your semester books at student-friendly prices. Buy & sell with ease!
                        </p>
                        <button class="bg-white text-emerald-600 font-bold px-8 py-3 rounded-full hover:bg-emerald-50 transition-colors shadow-lg">
                            Browse Books →
                        </button>
                    </div>
                </div>
            </div>

            {{-- Navigation Arrows --}}
            <button @click="currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-3 transition-all z-20 shadow-lg cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </button>
            <button @click="currentSlide = currentSlide === totalSlides - 1 ? 0 : currentSlide + 1"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-white/80 hover:bg-white text-gray-800 rounded-full p-3 transition-all z-20 shadow-lg cursor-pointer">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </button>

            {{-- Slide Indicators --}}
            <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                <button @click="currentSlide = 0"
                        class="w-2 h-2 rounded-full transition-all"
                        :class="currentSlide === 0 ? 'bg-white w-8' : 'bg-white/50'">
                </button>
                <button @click="currentSlide = 1"
                        class="w-2 h-2 rounded-full transition-all"
                        :class="currentSlide === 1 ? 'bg-white w-8' : 'bg-white/50'">
                </button>
                <button @click="currentSlide = 2"
                        class="w-2 h-2 rounded-full transition-all"
                        :class="currentSlide === 2 ? 'bg-white w-8' : 'bg-white/50'">
                </button>
            </div>

            {{-- Auto-play functionality --}}
            <div x-init="
                setInterval(() => {
                    currentSlide = currentSlide === totalSlides - 1 ? 0 : currentSlide + 1;
                }, 5000);
            "></div>
        </div>

        {{-- Ad Space Info Badge --}}
        <div class="mt-4 flex items-center justify-center gap-2 text-sm text-gray-500">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span class="italic">Premium ad space available - Contact us to advertise here</span>
        </div>
    </div>

    {{-- <div class="mt-12 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-base font-semibold text-gray-900">Textbooks</h3>
            <p class="mt-1 text-sm text-gray-600">Buy and sell used textbooks for your courses.</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-base font-semibold text-gray-900">Electronics</h3>
            <p class="mt-1 text-sm text-gray-600">Laptops, phones, and accessories, secondhand and affordable.</p>
        </div>
        <div class="rounded-lg border border-gray-200 bg-white p-6">
            <h3 class="text-base font-semibold text-gray-900">Dorm Essentials</h3>
            <p class="mt-1 text-sm text-gray-600">Furniture and essentials for boarding life.</p>
        </div>
    </div> --}}

    <div>
        @if(count($items) > 0)
            <h2 class="mt-12 text-2xl font-bold text-gray-900">Explore ThriftCorner</h2>
            <div class="mt-6 grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($items as $item)
                    <x-listing-card :item="$item" />
                @endforeach
            </div>
        @else
            <p class="mt-12 text-center text-gray-600">No listings available at the moment. Please check back later.</p>
        @endif
    </div>
</div>
@endsection
