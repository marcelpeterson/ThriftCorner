@extends('layouts.app')

@section('title', $item->name . ' - ' . config('app.name'))

@section('content')
<div class="max-w-6xl mx-auto">
    {{-- Back Button --}}
    <div class="mb-6">
        <a href="{{ route('home') }}" class="inline-flex items-center text-gray-600 hover:text-gray-700 font-medium">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Back to Listings
        </a>
    </div>

    {{-- Image Carousel --}}
    <div class="mb-8">
        @if($item->images->count() > 0)
            <div class="relative" x-data="{ currentSlide: 0, totalSlides: {{ $item->images->count() }} }">
                {{-- Main Image Display --}}
                <div class="relative w-full h-[400px] rounded-2xl shadow-lg overflow-hidden">
                    @foreach($item->images as $index => $image)
                        <div class="absolute inset-0 transition-opacity duration-300"
                             :class="currentSlide === {{ $index }} ? 'opacity-100' : 'opacity-0'">
                            {{-- Blurred Background --}}
                            <div class="absolute inset-0">
                                <img src="{{ $image->image_url }}" alt="" class="w-full h-full object-cover blur-2xl scale-110 opacity-60">
                            </div>
                            {{-- Actual Image --}}
                            <img src="{{ $image->image_url }}" 
                                 alt="{{ $item->name }} - Image {{ $index + 1 }}" 
                                 class="relative w-full h-full object-contain z-10">
                        </div>
                    @endforeach

                    {{-- Navigation Arrows (only show if more than 1 image) --}}
                    @if($item->images->count() > 1)
                        <button @click="currentSlide = currentSlide === 0 ? totalSlides - 1 : currentSlide - 1"
                                class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-colors z-20 cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                            </svg>
                        </button>
                        <button @click="currentSlide = currentSlide === totalSlides - 1 ? 0 : currentSlide + 1"
                                class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white rounded-full p-2 transition-colors z-20 cursor-pointer">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                            </svg>
                        </button>

                        {{-- Slide Indicators --}}
                        <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2 z-20">
                            @foreach($item->images as $index => $image)
                                <button @click="currentSlide = {{ $index }}"
                                        class="w-2 h-2 rounded-full transition-all"
                                        :class="currentSlide === {{ $index }} ? 'bg-white w-8' : 'bg-white/50'">
                                </button>
                            @endforeach
                        </div>

                        {{-- Image Counter --}}
                        <div class="absolute top-4 right-4 bg-black/50 text-white px-3 py-1 rounded-full text-sm font-medium z-20">
                            <span x-text="currentSlide + 1"></span> / {{ $item->images->count() }}
                        </div>
                    @endif
                </div>

                {{-- Thumbnail Strip (only show if more than 1 image) --}}
                @if($item->images->count() > 1)
                    <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
                        @foreach($item->images as $index => $image)
                            <button @click="currentSlide = {{ $index }}"
                                    class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 transition-all"
                                    :class="currentSlide === {{ $index }} ? 'border-emerald-600 ring-2 ring-emerald-200' : 'border-gray-200 hover:border-gray-300'">
                                <img src="{{ $image->image_url }}" alt="Thumbnail {{ $index + 1 }}" class="w-full h-full object-cover">
                            </button>
                        @endforeach
                    </div>
                @endif
            </div>
        @elseif($item->photo)
            {{-- Fallback to old single photo --}}
            <div class="relative w-full h-[400px] rounded-2xl shadow-lg overflow-hidden">
                <div class="absolute inset-0">
                    <img src="{{ $item->photo }}" alt="" class="w-full h-full object-cover blur-2xl scale-110 opacity-60">
                </div>
                <img src="{{ $item->photo }}" alt="{{ $item->name }}" class="relative w-full h-full object-contain z-10">
            </div>
        @else
            {{-- No images available --}}
            <div class="w-full h-[400px] bg-gray-200 flex items-center justify-center rounded-2xl shadow-lg">
                <div class="text-center">
                    <svg class="w-24 h-24 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <p class="mt-2 text-gray-500 font-medium">No Image Available</p>
                </div>
            </div>
        @endif
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        {{-- Left Column: Item Details --}}
        <div class="lg:col-span-2">
            {{-- Item Name --}}
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $item->name }}</h1>

            {{-- Price --}}
            <div class="mb-6">
                <p class="text-3xl font-bold text-blue-500">{{ $item->price_rupiah }}</p>
            </div>

            {{-- Condition --}}
            <div class="mb-8">
                <div class="inline-flex items-center px-4 py-2 bg-blue-50 rounded-full">
                    <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-blue-800 font-semibold">Condition: {{ $item->condition }}</span>
                </div>
            </div>

            {{-- Description --}}
            <div class="mb-8">
                <h2 class="text-2xl font-bold text-gray-900 mb-4">Description</h2>
                <div class="prose max-w-none">
                    @if($item->description)
                        <p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $item->description }}</p>
                    @else
                        <p class="text-gray-500 italic">No description provided.</p>
                    @endif
                </div>
            </div>

            {{-- Additional Details --}}
            <div class="bg-gray-50 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 mb-4">Item Details</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <p class="text-sm text-gray-500">Category</p>
                        <p class="font-semibold text-gray-900">{{ $item->category->name }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Listed</p>
                        <p class="font-semibold text-gray-900">{{ $item->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Last Updated</p>
                        <p class="font-semibold text-gray-900">{{ $item->updated_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Condition</p>
                        <p class="font-semibold text-gray-900">{{ $item->condition }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Column: Seller Info & Actions --}}
        <div class="lg:col-span-1">
            <div class="sticky top-8">
                {{-- Seller Card --}}
                <div class="bg-white border border-gray-200 rounded-xl p-6 shadow-sm mb-6">
                    <h3 class="text-lg font-bold text-gray-900 mb-4">Seller Information</h3>
                    
                    <div class="flex items-center mb-4">
                        @if($item->user->photo_url)
                            <img src="{{ $item->user->photo_url }}" alt="{{ $item->user->first_name }}" class="w-16 h-16 rounded-full object-cover">
                        @else
                            <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center">
                                <span class="text-emerald-600 font-bold text-xl">{{ substr($item->user->first_name, 0, 1) }}{{ substr($item->user->last_name, 0, 1) }}</span>
                            </div>
                        @endif
                        <div class="ml-4">
                            <p class="font-bold text-gray-900">{{ $item->user->first_name }} {{ $item->user->last_name }}</p>
                            <p class="text-sm text-gray-500">{{ $item->user->email }}</p>
                        </div>
                    </div>

                    {{-- Reviews Placeholder --}}
                    <div class="border-t border-gray-200 pt-4 mb-4">
                        <div class="flex items-center mb-2">
                            <div class="flex items-center">
                                @for($i = 0; $i < 5; $i++)
                                    <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 20 20">
                                        <path d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z"/>
                                    </svg>
                                @endfor
                            </div>
                            <span class="ml-2 text-sm font-semibold text-gray-700">5.0</span>
                        </div>
                        <p class="text-sm text-gray-500 italic">No reviews yet - be the first to review!</p>
                        <p class="text-xs text-gray-400 mt-1">Reviews will be available after completed deals</p>
                    </div>

                    {{-- WhatsApp Button --}}
                    <a href="{{ $whatsappLink }}" 
                       target="_blank"
                       rel="noopener noreferrer"
                       class="block w-full bg-emerald-600 hover:bg-emerald-700 text-white font-bold py-4 px-6 rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg text-center">
                        <div class="flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                            </svg>
                            Contact Seller via WhatsApp
                        </div>
                    </a>

                    <p class="text-xs text-gray-500 text-center mt-3">
                        Click to start a chat with pre-filled message
                    </p>

                    {{-- Mark as Sold Button (Only for seller) --}}
                    @auth
                        @if(auth()->id() === $item->user_id && !$item->is_sold)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <form action="{{ route('transaction.markSold', $item->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to mark this item as sold? This will generate confirmation links for you and the buyer.');">
                                    @csrf
                                    <button type="submit" class="block w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg transition duration-150 ease-in-out shadow-md hover:shadow-lg text-center">
                                        <div class="flex items-center justify-center cursor-pointer">
                                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            Mark as Sold
                                        </div>
                                    </button>
                                </form>
                                <p class="text-xs text-gray-500 text-center mt-2">Generate transaction confirmation links</p>
                            </div>
                        @endif

                        @if($item->is_sold)
                            <div class="mt-4 pt-4 border-t border-gray-200">
                                <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
                                    <svg class="w-8 h-8 text-green-600 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <p class="font-bold text-green-800">SOLD</p>
                                    <p class="text-xs text-green-600 mt-1">This item has been sold</p>
                                </div>
                            </div>
                        @endif
                    @endauth
                </div>

                {{-- Safety Tips --}}
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-amber-600 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                        </svg>
                        <div>
                            <h4 class="font-bold text-amber-900 mb-2">Safety Tips</h4>
                            <ul class="text-sm text-amber-800 space-y-1">
                                <li>• Meet in public places</li>
                                <li>• Inspect items before buying</li>
                                <li>• Never share sensitive info</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection