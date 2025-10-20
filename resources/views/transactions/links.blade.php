@extends('layouts.app')

@section('title', 'Transaction Links - ' . config('app.name'))

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 max-md:mt-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-4 sm:p-6 md:p-8">
        {{-- Success Header --}}
        <div class="text-center mb-6 sm:mb-8">
            <div class="inline-flex items-center justify-center w-12 h-12 sm:w-16 sm:h-16 bg-green-100 rounded-full mb-3 sm:mb-4">
                <svg class="w-8 h-8 sm:w-10 sm:h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-900 mb-2">Transaction Initiated!</h1>
            <p class="text-sm sm:text-base text-gray-600">Share these confirmation links to complete the transaction</p>
        </div>

        {{-- Item Info --}}
        <div class="bg-gray-50 rounded-lg p-4 mb-6">
            <div class="flex items-center gap-4">
                @if($transaction->item->images->count() > 0)
                    <img src="{{ Storage::url($transaction->item->images->first()->image_path) }}" alt="{{ $transaction->item->name }}" class="w-20 h-20 object-cover rounded-lg">
                @else
                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1">
                    <h3 class="font-bold max-md:font-black text-gray-900">{{ $transaction->item->name }}</h3>
                    <p class="text-sm max-md:font-semibold text-gray-600">{{ $transaction->item->price_rupiah }}</p>
                </div>
            </div>
        </div>

        {{-- Confirmation Links --}}
        <div class="space-y-4 sm:space-y-6 mb-6 sm:mb-8">
            {{-- Seller Link --}}
            <div class="border border-blue-200 rounded-lg p-4 sm:p-6 bg-blue-50">
                <div class="flex flex-col sm:flex-row sm:items-start gap-3 sm:gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-blue-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">S</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-900 mb-1 sm:mb-2 text-sm sm:text-base">Your Confirmation Link (Seller)</h3>
                        <p class="text-xs sm:text-sm text-gray-600 mb-3">Use this link to confirm you've handed over the item</p>
                        <div class="flex flex-row gap-2">
                            <input type="text" value="{{ $transaction->seller_confirmation_url }}" readonly
                                   id="seller-link"
                                   class="flex-1 min-w-0 px-3 sm:px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs sm:text-sm font-mono overflow-x-auto">
                            <button onclick="copyToClipboard('seller-link', this)" 
                                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm">Copy</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Buyer Link --}}
            <div class="border border-emerald-200 rounded-lg p-4 sm:p-6 bg-emerald-50">
                <div class="flex flex-col sm:flex-row sm:items-start gap-3 sm:gap-4">
                    <div class="flex-shrink-0">
                        <div class="w-10 h-10 bg-emerald-600 rounded-full flex items-center justify-center">
                            <span class="text-white font-bold">B</span>
                        </div>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-900 mb-1 sm:mb-2 text-sm sm:text-base">Buyer Confirmation Link</h3>
                        <p class="text-xs sm:text-sm text-gray-600 mb-3">Share this link with the buyer to confirm they've received the item</p>
                        <div class="flex flex-row gap-2">
                            <input type="text" value="{{ $transaction->buyer_confirmation_url }}" readonly
                                   id="buyer-link"
                                   class="flex-1 min-w-0 px-3 sm:px-4 py-2 bg-white border border-gray-300 rounded-lg text-xs sm:text-sm font-mono overflow-x-auto">
                            <button onclick="copyToClipboard('buyer-link', this)" 
                                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg transition-colors flex items-center justify-center gap-2 whitespace-nowrap">
                                <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                                </svg>
                                <span class="text-sm">Copy</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Instructions --}}
        <div class="bg-amber-50 border border-amber-200 rounded-lg p-4 sm:p-6 mb-6">
            <h4 class="font-bold text-amber-900 mb-3 flex items-center text-sm sm:text-base">
                <svg class="w-4 h-4 sm:w-5 sm:h-5 mr-2 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                How it works
            </h4>
            <ol class="space-y-2 text-xs sm:text-sm text-amber-800">
                <li class="flex items-start">
                    <span class="font-bold mr-2 flex-shrink-0">1.</span>
                    <span>Share the <strong>Buyer Confirmation Link</strong> with your buyer (via WhatsApp, email, etc.)</span>
                </li>
                <li class="flex items-start">
                    <span class="font-bold mr-2 flex-shrink-0">2.</span>
                    <span>When you meet and hand over the item, click your <strong>Seller Confirmation Link</strong></span>
                </li>
                <li class="flex items-start">
                    <span class="font-bold mr-2 flex-shrink-0">3.</span>
                    <span>The buyer should click their link to confirm they received the item</span>
                </li>
                <li class="flex items-start">
                    <span class="font-bold mr-2 flex-shrink-0">4.</span>
                    <span>Once <strong>both parties</strong> confirm, a transaction report will be generated automatically</span>
                </li>
            </ol>
        </div>

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row gap-3 sm:gap-4">
            <a href="{{ route('items.view', $transaction->item->slug) }}" 
               class="flex-1 px-4 sm:px-6 py-2.5 sm:py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg text-center transition-colors text-sm sm:text-base">
                Back to Listing
            </a>
            <form action="{{ route('transaction.cancel', $transaction->id) }}" method="POST" class="flex-1"
                  onsubmit="return confirm('Are you sure you want to cancel this transaction?');">
                @csrf
                <button type="submit" 
                        class="w-full px-4 sm:px-6 py-2.5 sm:py-3 bg-red-100 hover:bg-red-200 text-red-700 font-semibold rounded-lg transition-colors cursor-pointer text-sm sm:text-base">
                    Cancel Transaction
                </button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function copyToClipboard(inputId, button) {
        const input = document.getElementById(inputId);
        input.select();
        input.setSelectionRange(0, 99999); // For mobile devices
        
        navigator.clipboard.writeText(input.value).then(() => {
            // Change button text temporarily
            const originalHTML = button.innerHTML;
            button.innerHTML = '<span class="text-sm">Copied!</span>';
            button.classList.add('bg-green-600');
            
            setTimeout(() => {
                button.innerHTML = originalHTML;
                button.classList.remove('bg-green-600');
            }, 2000);
        });
    }
</script>
@endpush
@endsection
