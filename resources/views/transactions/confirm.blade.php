@extends('layouts.app')

@section('title', 'Confirm Transaction - ' . config('app.name'))

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        {{-- Header --}}
        <div class="text-center mb-8">
            @if($isSeller)
                <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Seller Confirmation</h1>
                <p class="text-gray-600">Confirm that you've handed over the item to the buyer</p>
            @else
                <div class="inline-flex items-center justify-center w-16 h-16 bg-emerald-100 rounded-full mb-4">
                    <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Buyer Confirmation</h1>
                <p class="text-gray-600">Confirm that you've received the item from the seller</p>
            @endif
        </div>

        {{-- Item Details --}}
        <div class="bg-gray-50 rounded-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4">Transaction Details</h3>
            
            <div class="flex gap-4 mb-6">
                @if($transaction->item->images->count() > 0)
                    <img src="{{ Storage::url($transaction->item->images->first()->image_path) }}" 
                         alt="{{ $transaction->item->name }}" 
                         class="w-24 h-24 object-cover rounded-lg">
                @else
                    <div class="w-24 h-24 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                
                <div class="flex-1">
                    <h4 class="font-bold text-lg text-gray-900">{{ $transaction->item->name }}</h4>
                    <p class="text-gray-600">{{ $transaction->item->category->name }}</p>
                    <p class="text-lg font-bold text-emerald-600 mt-2">{{ $transaction->item->price_rupiah }}</p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 text-sm">
                <div>
                    <p class="text-gray-500">Seller</p>
                    <p class="font-semibold text-gray-900">{{ $transaction->seller->first_name }} {{ $transaction->seller->last_name }}</p>
                </div>
                @if($transaction->buyer)
                    <div>
                        <p class="text-gray-500">Buyer</p>
                        <p class="font-semibold text-gray-900">{{ $transaction->buyer->first_name }} {{ $transaction->buyer->last_name }}</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Confirmation Status --}}
        <div class="space-y-3 mb-6">
            {{-- Seller Status --}}
            <div class="flex items-center gap-3 p-4 rounded-lg {{ $transaction->seller_confirmed ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-200' }}">
                <div class="flex-shrink-0">
                    @if($transaction->seller_confirmed)
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-semibold {{ $transaction->seller_confirmed ? 'text-green-900' : 'text-gray-700' }}">
                        Seller Confirmation
                    </p>
                    @if($transaction->seller_confirmed)
                        <p class="text-sm text-green-600">Confirmed at {{ $transaction->seller_confirmed_at->format('M d, Y H:i') }}</p>
                    @else
                        <p class="text-sm text-gray-500">Waiting for seller confirmation</p>
                    @endif
                </div>
            </div>

            {{-- Buyer Status --}}
            <div class="flex items-center gap-3 p-4 rounded-lg {{ $transaction->buyer_confirmed ? 'bg-green-50 border border-green-200' : 'bg-gray-50 border border-gray-200' }}">
                <div class="flex-shrink-0">
                    @if($transaction->buyer_confirmed)
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @else
                        <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    @endif
                </div>
                <div class="flex-1">
                    <p class="font-semibold {{ $transaction->buyer_confirmed ? 'text-green-900' : 'text-gray-700' }}">
                        Buyer Confirmation
                    </p>
                    @if($transaction->buyer_confirmed)
                        <p class="text-sm text-green-600">Confirmed at {{ $transaction->buyer_confirmed_at->format('M d, Y H:i') }}</p>
                    @else
                        <p class="text-sm text-gray-500">Waiting for buyer confirmation</p>
                    @endif
                </div>
            </div>
        </div>

        {{-- Confirmation Action --}}
        @auth
            @if(($isSeller && !$transaction->seller_confirmed) || ($isBuyer && !$transaction->buyer_confirmed))
                <form action="{{ route('transaction.confirm.submit', $isSeller ? $transaction->seller_token : $transaction->buyer_token) }}" method="POST">
                    @csrf
                    <button type="submit" 
                            class="w-full px-6 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition-colors shadow-md hover:shadow-lg cursor-pointer">
                        <div class="flex items-center justify-center">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            Confirm {{ $isSeller ? 'Handover' : 'Receipt' }}
                        </div>
                    </button>
                    <p class="text-xs text-gray-500 text-center mt-2">
                        By confirming, you acknowledge that the transaction has been completed as described
                    </p>
                </form>
            @elseif($transaction->isCompleted())
                <div class="bg-green-50 border-2 border-green-200 rounded-lg p-6 text-center">
                    <svg class="w-16 h-16 text-green-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="text-xl font-bold text-green-900 mb-2">Transaction Completed!</h3>
                    <p class="text-green-700 mb-4">Both parties have confirmed the transaction</p>
                    <a href="{{ route('transaction.report', $transaction->id) }}" 
                       class="inline-flex items-center px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-semibold rounded-lg transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        View Transaction Report
                    </a>
                </div>
            @else
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-6 text-center">
                    <svg class="w-12 h-12 text-blue-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h3 class="font-bold text-blue-900 mb-2">Waiting for the other party</h3>
                    <p class="text-blue-700 text-sm">Your confirmation has been recorded. The transaction will be completed once both parties confirm.</p>
                </div>
            @endif
        @else
            <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 text-center">
                <svg class="w-12 h-12 text-amber-600 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                <h3 class="font-bold text-amber-900 mb-2">Login Required</h3>
                <p class="text-amber-700 text-sm mb-4">Please log in to confirm this transaction</p>
                <a href="{{ route('login') }}" 
                   class="inline-flex items-center px-6 py-3 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg transition-colors">
                    Login to Continue
                </a>
            </div>
        @endauth
    </div>
</div>
@endsection
