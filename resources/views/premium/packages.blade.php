@extends('layouts.app')

@section('title', 'Featured Listing - ' . config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto">
    {{-- Header --}}
    <div class="text-center mb-12">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">Boost Your Listing with Featured Placement</h1>
        <p class="text-xl text-gray-600">Get maximum visibility and sell faster</p>
    </div>

    {{-- Item Preview --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-12">
        <h3 class="text-lg font-bold text-gray-900 mb-4">Your Listing:</h3>
        <div class="flex items-center gap-4">
            @if($item->images->count() > 0)
                <img src="{{ $item->images->first()->image_url }}" alt="{{ $item->name }}" class="w-24 h-24 object-cover rounded-lg">
            @else
                <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                    <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
            <div>
                <h4 class="font-bold text-gray-900 text-lg">{{ $item->name }}</h4>
                <p class="text-2xl font-bold text-emerald-600">{{ $item->price_rupiah }}</p>
            </div>
        </div>
    </div>

    {{-- Active Premium Alert --}}
    @if($activePremium)
        <div class="bg-purple-50 border-2 border-purple-300 rounded-xl p-6 mb-8">
            <div class="flex items-start">
                <svg class="w-6 h-6 text-purple-600 mr-3 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-lg font-bold text-purple-900 mb-2">Your Listing is Currently Featured!</h3>
                    <p class="text-purple-700">
                        Active until <span class="font-semibold">{{ $activePremium->expires_at->format('M d, Y \a\t H:i') }}</span>
                    </p>
                    <p class="text-sm text-purple-600 mt-2">Want to extend? Purchase another featured package below to add 14 more days.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Featured Package Card --}}
    @php
        $package = $packages['featured'];
    @endphp
    <div class="bg-white rounded-2xl shadow-xl border-2 border-purple-500 overflow-hidden mb-8 w-100 md:w-3/4 lg:w-1/2 mx-auto">
        <div class="bg-gradient-to-r from-purple-600 to-blue-600 text-white text-center py-3 font-bold text-lg">
            ⭐ FEATURED LISTING
        </div>

        <div class="p-10">
            {{-- Package Icon --}}
            <div class="w-20 h-20 mx-auto mb-6 rounded-full bg-gradient-to-br from-purple-100 to-blue-100 flex items-center justify-center">
                <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                </svg>
            </div>

            {{-- Package Name --}}
            <h2 class="text-3xl font-bold text-center text-purple-900 mb-3">{{ $package['name'] }}</h2>
            
            @if(isset($package['description']))
                <p class="text-center text-gray-600 mb-6">{{ $package['description'] }}</p>
            @endif

            {{-- Price --}}
            <div class="text-center mb-2">
                <span class="text-5xl font-bold text-gray-900">{{ rupiah($package['price']) }}</span>
                <p class="text-gray-600 mt-2">{{ $package['duration_days'] }} days of featured placement</p>
            </div>

            {{-- Features --}}
            <div class="bg-gray-50 rounded-xl p-6 mb-8">
                <h3 class="font-bold text-gray-900 mb-4 text-center">What You'll Get:</h3>
                <ul class="space-y-4">
                    @foreach($package['features'] as $feature)
                        <li class="flex items-start">
                            <svg class="w-6 h-6 text-green-500 mr-3 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            <span class="text-gray-700">{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Purchase Button --}}
            <form action="{{ route('premium.createPayment', $item->id) }}" method="POST">
                @csrf
                <input type="hidden" name="package_type" value="featured">
                <button type="submit" class="w-full py-4 px-6 bg-gradient-to-r from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700 text-white text-lg font-bold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105 cursor-pointer">
                    🚀 Make My Listing Featured
                </button>
            </form>
        </div>
    </div>

    {{-- Benefits Section --}}
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-8 mb-8">
        <h3 class="text-2xl font-bold text-gray-900 mb-6 text-center">Why Go Premium?</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="text-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">More Visibility</h4>
                <p class="text-gray-600 text-sm">Get up to 10x more views with premium placement</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Sell Faster</h4>
                <p class="text-gray-600 text-sm">Premium listings sell 3x faster on average</p>
            </div>
            <div class="text-center">
                <div class="w-16 h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-4 shadow-md">
                    <svg class="w-8 h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 mb-2">Stand Out</h4>
                <p class="text-gray-600 text-sm">Premium badge shows buyers you're serious</p>
            </div>
        </div>
    </div>

    {{-- Back Button --}}
    <div class="text-center">
        <a href="{{ route('items.view', $item->id) }}" class="inline-flex items-center px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Listing
        </a>
    </div>
</div>
@endsection
