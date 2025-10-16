@extends('layouts.app')

@section('title', 'Transaction Report - ' . config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 overflow-hidden">
        {{-- Report Header --}}
        <div class="bg-gradient-to-r from-emerald-600 to-emerald-700 px-8 py-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Transaction Report</h1>
                    <p class="text-emerald-100">Transaction ID: #{{ $transaction->id }}</p>
                </div>
                <div class="text-right">
                    <div class="bg-white/20 rounded-lg px-4 py-2">
                        <p class="text-sm text-emerald-100">Completed</p>
                        <p class="text-lg font-bold">{{ $transaction->completed_at->format('M d, Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Report Content --}}
        <div class="p-8">
            {{-- Success Banner --}}
            <div class="bg-green-50 border-2 border-green-200 rounded-lg p-6 mb-8 text-center">
                <svg class="w-16 h-16 text-green-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <h2 class="text-2xl font-bold text-green-900 mb-2">Transaction Completed Successfully!</h2>
                <p class="text-green-700">Both parties have confirmed this transaction</p>
            </div>

            {{-- Item Details --}}
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                    </svg>
                    Item Details
                </h3>
                <div class="bg-gray-50 rounded-lg p-6">
                    <div class="flex gap-6">
                        @if($transaction->item->images->count() > 0)
                            <img src="{{ Storage::url($transaction->item->images->first()->image_path) }}" 
                                 alt="{{ $transaction->item->name }}" 
                                 class="w-32 h-32 object-cover rounded-lg">
                        @else
                            <div class="w-32 h-32 bg-gray-200 rounded-lg flex items-center justify-center">
                                <svg class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                            </div>
                        @endif
                        
                        <div class="flex-1">
                            <h4 class="text-2xl font-bold text-gray-900 mb-2">{{ $transaction->item->name }}</h4>
                            <div class="grid grid-cols-2 gap-4 text-sm">
                                <div>
                                    <p class="text-gray-500">Category</p>
                                    <p class="font-semibold text-gray-900">{{ $transaction->item->category->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Condition</p>
                                    <p class="font-semibold text-gray-900">{{ $transaction->item->condition }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500">Price</p>
                                    <p class="text-2xl font-bold text-emerald-600">{{ $transaction->item->price_rupiah }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Parties Involved --}}
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    Transaction Parties
                </h3>
                <div class="grid md:grid-cols-2 gap-4">
                    {{-- Seller --}}
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-6">
                        <div class="flex items-center gap-4 mb-4">
                            @if($transaction->seller->photo_url)
                                <img src="{{ $transaction->seller->photo_url }}" alt="{{ $transaction->seller->first_name }}" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-blue-200 flex items-center justify-center">
                                    <span class="text-blue-700 font-bold text-xl">{{ substr($transaction->seller->first_name, 0, 1) }}{{ substr($transaction->seller->last_name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm text-blue-600 font-semibold">SELLER</p>
                                <p class="font-bold text-gray-900">{{ $transaction->seller->first_name }} {{ $transaction->seller->last_name }}</p>
                                <p class="text-sm text-gray-600">{{ $transaction->seller->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Confirmed {{ $transaction->seller_confirmed_at->format('M d, Y H:i') }}
                        </div>
                    </div>

                    {{-- Buyer --}}
                    <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-6">
                        <div class="flex items-center gap-4 mb-4">
                            @if($transaction->buyer->photo_url)
                                <img src="{{ $transaction->buyer->photo_url }}" alt="{{ $transaction->buyer->first_name }}" class="w-16 h-16 rounded-full object-cover">
                            @else
                                <div class="w-16 h-16 rounded-full bg-emerald-200 flex items-center justify-center">
                                    <span class="text-emerald-700 font-bold text-xl">{{ substr($transaction->buyer->first_name, 0, 1) }}{{ substr($transaction->buyer->last_name, 0, 1) }}</span>
                                </div>
                            @endif
                            <div>
                                <p class="text-sm text-emerald-600 font-semibold">BUYER</p>
                                <p class="font-bold text-gray-900">{{ $transaction->buyer->first_name }} {{ $transaction->buyer->last_name }}</p>
                                <p class="text-sm text-gray-600">{{ $transaction->buyer->email }}</p>
                            </div>
                        </div>
                        <div class="flex items-center text-sm text-green-600">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Confirmed {{ $transaction->buyer_confirmed_at->format('M d, Y H:i') }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Timeline --}}
            <div class="mb-8">
                <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                    <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Transaction Timeline
                </h3>
                <div class="space-y-4">
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Transaction Initiated</p>
                            <p class="text-sm text-gray-600">{{ $transaction->created_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Seller Confirmed</p>
                            <p class="text-sm text-gray-600">{{ $transaction->seller_confirmed_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Buyer Confirmed</p>
                            <p class="text-sm text-gray-600">{{ $transaction->buyer_confirmed_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                    
                    <div class="flex gap-4">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="font-semibold text-gray-900">Transaction Completed</p>
                            <p class="text-sm text-gray-600">{{ $transaction->completed_at->format('M d, Y H:i') }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Rating Section --}}
            @if($isBuyer)
                <div class="mb-8">
                    <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                        <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                        Rate Your Experience
                    </h3>

                    @if($hasRated)
                        {{-- Show existing rating --}}
                        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-6">
                            <div class="flex items-start gap-4">
                                @if(auth()->user()->photo_url)
                                    <img src="{{ auth()->user()->photo_url }}" alt="{{ auth()->user()->first_name }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-yellow-200 flex items-center justify-center">
                                        <span class="text-yellow-700 font-bold">{{ substr(auth()->user()->first_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="font-bold text-gray-900">{{ auth()->user()->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $transaction->rating->created_at->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <div class="flex items-center mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $transaction->rating->rating)
                                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-sm font-semibold text-gray-700">{{ $transaction->rating->rating }} out of 5</span>
                                    </div>
                                    
                                    @if($transaction->rating->review)
                                        <p class="text-gray-700 mt-2">{{ $transaction->rating->review }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @else
                        {{-- Rating form --}}
                        <div class="bg-gradient-to-br from-yellow-50 to-amber-50 border-2 border-yellow-200 rounded-lg p-6">
                            <p class="text-gray-700 mb-4">Share your experience with this seller to help other buyers make informed decisions.</p>
                            
                            <form action="{{ route('rating.store', $transaction->id) }}" method="POST" x-data="{ selectedRating: 0, hoveredRating: 0 }">
                                @csrf
                                
                                {{-- Star Rating --}}
                                <div class="mb-6">
                                    <label class="block text-sm font-semibold text-gray-900 mb-3">Rating*</label>
                                    <div class="flex items-center gap-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            <button type="button"
                                                    @click="selectedRating = {{ $i }}"
                                                    @mouseenter="hoveredRating = {{ $i }}"
                                                    @mouseleave="hoveredRating = 0"
                                                    class="focus:outline-none transition-transform hover:scale-110">
                                                <svg class="w-10 h-10 transition-colors cursor-pointer"
                                                     :class="(hoveredRating >= {{ $i }} || (hoveredRating === 0 && selectedRating >= {{ $i }})) ? 'text-yellow-400 fill-current' : 'text-gray-300'"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="1">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                            </button>
                                        @endfor
                                        <span class="ml-3 text-lg font-semibold text-gray-700" x-show="selectedRating > 0" x-text="selectedRating + ' out of 5 stars'"></span>
                                    </div>
                                    <input type="hidden" name="rating" :value="selectedRating" required>
                                    @error('rating')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                {{-- Review Text --}}
                                <div class="mb-6">
                                    <label for="review" class="block text-sm font-semibold text-gray-900 mb-2">
                                        Review (Optional)
                                        <span class="text-gray-500 font-normal">- Share your detailed experience</span>
                                    </label>
                                    <textarea name="review" 
                                              id="review" 
                                              rows="4" 
                                              maxlength="1000"
                                              placeholder="How was your experience with this seller? Quality of the item, communication, meeting arrangement, etc."
                                              class="w-full rounded-lg border border-gray-300 px-4 py-3 text-sm focus:border-yellow-500 focus:outline-none focus:ring-2 focus:ring-yellow-500">{{ old('review') }}</textarea>
                                    <p class="mt-1 text-xs text-gray-500">Maximum 1000 characters</p>
                                    @error('review')
                                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <button type="submit" 
                                        class="w-full bg-gradient-to-r from-yellow-500 to-amber-500 hover:from-yellow-600 hover:to-amber-600 text-white font-bold py-3 rounded-lg transition-all shadow-md hover:shadow-lg flex items-center justify-center gap-2 cursor-pointer">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                    </svg>
                                    Submit Rating & Review
                                </button>
                            </form>
                        </div>
                    @endif
                </div>
            @else
                {{-- Show rating to seller if buyer has rated --}}
                @if($hasRated)
                    <div class="mb-8">
                        <h3 class="text-xl font-bold text-gray-900 mb-4 flex items-center">
                            <svg class="w-6 h-6 mr-2 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                            </svg>
                            Buyer's Rating
                        </h3>
                        
                        <div class="bg-yellow-50 border-2 border-yellow-200 rounded-lg p-6">
                            <div class="flex items-start gap-4">
                                @if($transaction->buyer->photo_url)
                                    <img src="{{ $transaction->buyer->photo_url }}" alt="{{ $transaction->buyer->first_name }}" class="w-12 h-12 rounded-full object-cover">
                                @else
                                    <div class="w-12 h-12 rounded-full bg-yellow-200 flex items-center justify-center">
                                        <span class="text-yellow-700 font-bold">{{ substr($transaction->buyer->first_name, 0, 1) }}</span>
                                    </div>
                                @endif
                                
                                <div class="flex-1">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="font-bold text-gray-900">{{ $transaction->buyer->full_name }}</p>
                                        <p class="text-sm text-gray-500">{{ $transaction->rating->created_at->format('M d, Y') }}</p>
                                    </div>
                                    
                                    <div class="flex items-center mb-2">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= $transaction->rating->rating)
                                                <svg class="w-5 h-5 text-yellow-400 fill-current" viewBox="0 0 24 24">
                                                    <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                                </svg>
                                            @else
                                                <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                                                </svg>
                                            @endif
                                        @endfor
                                        <span class="ml-2 text-sm font-semibold text-gray-700">{{ $transaction->rating->rating }} out of 5</span>
                                    </div>
                                    
                                    @if($transaction->rating->review)
                                        <p class="text-gray-700 mt-2">{{ $transaction->rating->review }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif

            {{-- Actions --}}
            <div class="border-t pt-6">
                <div class="flex gap-4">
                    <a href="{{ route('home') }}" 
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg text-center transition-colors">
                        Back to Home
                    </a>
                    {{-- <button onclick="window.print()" 
                            class="flex-1 px-6 py-3 bg-emerald-600 hover:bg-emerald-700 text-white font-semibold rounded-lg transition-colors flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Print Report
                    </button> --}}
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<style>
    @media print {
        body * {
            visibility: hidden;
        }
        .max-w-4xl, .max-w-4xl * {
            visibility: visible;
        }
        .max-w-4xl {
            position: absolute;
            left: 0;
            top: 0;
            width: 100%;
        }
        button, .hover\:bg-gray-200, .hover\:bg-emerald-700 {
            display: none !important;
        }
    }
</style>
@endpush
@endsection
