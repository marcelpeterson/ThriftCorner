@extends('layouts.app')

@section('title', 'Premium Packages - ' . config('app.name'))

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 max-md:mt-4">
    {{-- Header --}}
    <div class="text-center mb-6">
        <h1 class="text-2xl sm:text-3xl md:text-4xl font-bold max-md:font-black text-gray-900 mb-3 sm:mb-4">Boost Your Listing with Premium Placement</h1>
        <p class="text-base sm:text-lg md:text-xl text-gray-600">Choose the package that fits your needs</p>
    </div>

    {{-- Item Preview --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4 max-md:pt-4 max-md:pb-2 sm:p-6 mb-8 sm:mb-12 max-md:flex max-md:flex-col max-md:items-center">
        <h3 class="text-base sm:text-lg font-bold text-gray-900 mb-4 max-md:hidden">Your Listing:</h3>
        <div class="flex flex-col sm:flex-row sm:items-center gap-4 max-md:gap-2 max-md:items-center">
            @if($item->images->count() > 0)
                <img src="{{ Storage::url($item->images->first()->image_path) }}" alt="{{ $item->name }}" class="w-20 sm:w-24 h-20 sm:h-24 object-cover rounded-lg flex-shrink-0">
            @else
                <div class="w-20 sm:w-24 h-20 sm:h-24 bg-gray-200 rounded-lg flex items-center justify-center flex-shrink-0">
                    <svg class="w-10 sm:w-12 h-10 sm:h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
            @endif
            <div class="flex-1">
                <h4 class="font-bold max-md:font-black max-md:text-center text-gray-900 text-base sm:text-lg">{{ $item->name }}</h4>
                <p class="text-xl sm:text-2xl font-semibold max-md:font-bold max-md:text-center text-emerald-600">{{ $item->price_rupiah }}</p>
            </div>
        </div>
    </div>

    {{-- Active Premium Packages Alert --}}
    @if($activePremiumPackages->count() > 0)
        <div class="bg-gradient-to-r from-purple-50 to-blue-50 border-2 border-purple-300 rounded-xl p-4 sm:p-6 mb-6 sm:mb-8">
            <div class="flex flex-col sm:flex-row sm:items-start gap-3 sm:gap-4">
                <svg class="w-6 h-6 text-purple-600 mr-0 sm:mr-3 flex-shrink-0 mt-0" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
                </svg>
                <div class="flex-1">
                    <h3 class="text-base sm:text-lg font-bold text-purple-900 mb-3">🎉 Your Listing Has Active Premium Packages!</h3>
                    <div class="space-y-2">
                        @foreach($activePremiumPackages as $package)
                            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between bg-white rounded-lg px-3 sm:px-4 py-2 border gap-2 {{ $package->package_type === 'hero' ? 'border-blue-200' : 'border-purple-200' }}">
                                <div class="flex items-center">
                                    @if($package->package_type === 'hero')
                                        <span class="text-blue-600 font-bold mr-2">🎯</span>
                                        <span class="font-semibold text-xs sm:text-sm text-blue-700">Hero Banner</span>
                                    @else
                                        <span class="text-purple-600 font-bold mr-2">⭐</span>
                                        <span class="font-semibold text-xs sm:text-sm text-purple-700">Featured Listing</span>
                                    @endif
                                </div>
                                <span class="text-xs sm:text-sm text-gray-600 font-medium">Until {{ $package->expires_at->format('M d, Y') }}</span>
                            </div>
                        @endforeach
                    </div>
                    <p class="text-xs sm:text-sm text-gray-600 mt-3">You can purchase additional packages or extend existing ones below.</p>
                </div>
            </div>
        </div>
    @endif

    {{-- Premium Packages Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 sm:gap-8 mb-8">
        @foreach($packages as $type => $package)
            <div class="bg-white rounded-2xl shadow-xl border-2 {{ $type === 'hero' ? 'border-blue-500' : 'border-purple-500' }} overflow-hidden">
                <div class="bg-gradient-to-r {{ $type === 'hero' ? 'from-blue-600 to-cyan-600' : 'from-purple-600 to-blue-600' }} text-white text-center py-2 sm:py-3 font-bold text-base sm:text-lg">
                    {{ $type === 'hero' ? '🎯 HERO BANNER' : '⭐ FEATURED LISTING' }}
                </div>

                <div class="p-4 sm:p-8">
                    {{-- Package Icon --}}
                    <div class="w-16 sm:w-20 h-16 sm:h-20 mx-auto mb-4 sm:mb-6 rounded-full bg-gradient-to-br {{ $type === 'hero' ? 'from-blue-100 to-cyan-100' : 'from-purple-100 to-blue-100' }} flex items-center justify-center">
                        @if($type === 'hero')
                            <svg class="w-8 sm:w-10 h-8 sm:h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 4v16M17 4v16M3 8h4m10 0h4M3 12h18M3 16h4m10 0h4M4 20h16a1 1 0 001-1V5a1 1 0 00-1-1H4a1 1 0 00-1 1v14a1 1 0 001 1z"/>
                            </svg>
                        @else
                            <svg class="w-8 sm:w-10 h-8 sm:h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>
                            </svg>
                        @endif
                    </div>

                    {{-- Package Name --}}
                    <h2 class="text-xl sm:text-2xl font-bold text-center {{ $type === 'hero' ? 'text-blue-900' : 'text-purple-900' }} mb-2">{{ $package['name'] }}</h2>

                    @if(isset($package['description']))
                        <p class="text-center text-gray-600 text-xs sm:text-sm mb-4">{{ $package['description'] }}</p>
                    @endif

                    {{-- Price --}}
                    <div class="text-center mb-4 sm:mb-6">
                        <span class="text-3xl sm:text-4xl font-bold max-md:font-black text-gray-900">{{ rupiah($package['price']) }}</span>
                        <p class="text-gray-600 text-xs sm:text-sm mt-2">{{ $package['duration_days'] }} days</p>
                    </div>

                    {{-- Features --}}
                    <div class="bg-gray-50 rounded-xl p-4 sm:p-6 mb-4 sm:mb-6">
                        <h3 class="font-bold text-gray-900 mb-3 text-xs sm:text-sm">What You'll Get:</h3>
                        <ul class="space-y-2">
                            @foreach($package['features'] as $feature)
                                <li class="flex items-start gap-2">
                                    <svg class="w-4 sm:w-5 h-4 sm:h-5 text-green-500 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    <span class="text-gray-700 text-xs sm:text-sm">{{ $feature }}</span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Purchase Button --}}
                    <form action="{{ route('premium.createPayment', $item->slug) }}" method="POST">
                        @csrf
                        <input type="hidden" name="package_type" value="{{ $type }}">
                        <button type="submit" class="w-full py-2 sm:py-3 px-4 sm:px-6 bg-gradient-to-r {{ $type === 'hero' ? 'from-blue-600 to-cyan-600 hover:from-blue-700 hover:to-cyan-700' : 'from-purple-600 to-blue-600 hover:from-purple-700 hover:to-blue-700' }} text-white font-bold rounded-xl transition-all shadow-lg hover:shadow-xl transform hover:scale-105 cursor-pointer text-sm sm:text-base">
                            {{ $type === 'hero' ? '🎯 Get Hero Banner' : '🚀 Get Featured' }}
                        </button>
                    </form>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Benefits Section --}}
    <div class="bg-gradient-to-r from-blue-50 to-purple-50 rounded-2xl p-4 sm:p-8 mb-8">
        <h3 class="text-xl sm:text-2xl font-bold text-gray-900 mb-6 text-center">Why Go Premium?</h3>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 sm:gap-6">
            <div class="text-center">
                <div class="w-14 sm:w-16 h-14 sm:h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 shadow-md">
                    <svg class="w-7 sm:w-8 h-7 sm:h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 mb-2 text-sm sm:text-base">More Visibility</h4>
                <p class="text-gray-600 text-xs sm:text-sm">Get up to 10x more views with premium placement</p>
            </div>
            <div class="text-center">
                <div class="w-14 sm:w-16 h-14 sm:h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 shadow-md">
                    <svg class="w-7 sm:w-8 h-7 sm:h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 mb-2 text-sm sm:text-base">Sell Faster</h4>
                <p class="text-gray-600 text-xs sm:text-sm">Premium listings sell 3x faster on average</p>
            </div>
            <div class="text-center">
                <div class="w-14 sm:w-16 h-14 sm:h-16 bg-white rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4 shadow-md">
                    <svg class="w-7 sm:w-8 h-7 sm:h-8 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                    </svg>
                </div>
                <h4 class="font-bold text-gray-900 mb-2 text-sm sm:text-base">Stand Out</h4>
                <p class="text-gray-600 text-xs sm:text-sm">Premium badge shows buyers you're serious</p>
            </div>
        </div>
    </div>

    {{-- Back Button --}}
    <div class="text-center">
        <a href="{{ route('items.view', $item->slug) }}" class="inline-flex items-center px-4 sm:px-6 py-2 sm:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg transition-colors text-sm sm:text-base">
            <svg class="w-4 sm:w-5 h-4 sm:h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back to Listing
        </a>
    </div>
</div>
@endsection
