@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
<div class="max-w-3xl mx-auto max-md:mt-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 max-md:font-black">Complete Your Payment</h1>
            <p class="text-gray-600">Bank Transfer Instructions</p>
        </div>

        {{-- Order Summary --}}
        <div class="bg-gray-50 rounded-lg p-6 mb-2">
            <h3 class="font-bold text-gray-900 mb-4">Order Summary</h3>
            
            {{-- Item --}}
            <div class="flex items-center gap-4 mb-6 pb-6 border-b border-gray-200">
                @if($payment->item->images->count() > 0)
                    <img src="{{ Storage::url($payment->item->images->first()->image_path) }}" alt="{{ $payment->item->name }}" class="w-20 h-20 object-cover rounded-lg">
                @else
                    <div class="w-20 h-20 bg-gray-200 rounded-lg flex items-center justify-center">
                        <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                        </svg>
                    </div>
                @endif
                <div class="flex-1">
                    <h4 class="font-bold text-gray-900">{{ $payment->item->name }}</h4>
                    <p class="text-sm text-gray-600">{{ $payment->item->price_rupiah }}</p>
                </div>
            </div>

            {{-- Package Details --}}
            <div class="space-y-3 mb-3">
                <div class="flex justify-between">
                    <span class="text-gray-700">Package:</span>
                    <span class="font-semibold text-gray-900">{{ $package['name'] }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-gray-700">Duration:</span>
                    <span class="font-semibold text-gray-900">{{ $package['duration_days'] }} days</span>
                </div>
                <div class="flex justify-between pt-3 border-t border-gray-200">
                    <span class="text-lg font-bold text-gray-900">Total:</span>
                    <span class="text-2xl font-bold text-emerald-600">{{ rupiah($payment->amount) }}</span>
                </div>
            </div>

            {{-- Features --}}
            <div class="bg-white rounded-lg p-4">
                <p class="text-sm font-semibold text-gray-700 mb-2">You'll get:</p>
                <ul class="space-y-2">
                    @foreach($package['features'] as $feature)
                        <li class="flex items-start text-sm">
                            <svg class="w-4 h-4 text-green-500 mr-2 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-700">{{ $feature }}</span>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        {{-- Bank Transfer Instructions --}}
        <div class="bg-blue-50 rounded-lg p-6 mb-6">
            <h3 class="font-bold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                Bank Transfer Details
            </h3>
            
            <div class="space-y-3 bg-white rounded-lg p-4">
                <div>
                    <span class="text-sm text-gray-600">Bank:</span>
                    <p class="text-lg font-bold text-gray-900">{{ $payment->bank_name }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Account Number:</span>
                    <p class="text-2xl font-bold text-gray-900 select-all">{{ $payment->account_number }}</p>
                </div>
                <div>
                    <span class="text-sm text-gray-600">Account Name:</span>
                    <p class="text-lg font-bold text-gray-900">{{ $payment->account_name }}</p>
                </div>
                <div class="pt-3 border-t">
                    <span class="text-sm text-gray-600">Transfer Amount:</span>
                    <p class="text-2xl font-bold text-emerald-600 select-all">{{ rupiah($payment->amount) }}</p>
                </div>
            </div>

            <div class="mt-4 p-4 bg-amber-50 border border-amber-200 rounded-lg">
                <p class="text-sm text-amber-800">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                    </svg>
                    Please transfer the exact amount to ensure quick processing
                </p>
            </div>
        </div>

        {{-- Payment Steps --}}
        <div class="mb-6">
            <h3 class="font-bold text-gray-900 mb-4">How to complete your payment:</h3>
            <ol class="space-y-3">
                <li class="flex">
                    <span class="flex-shrink-0 w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</span>
                    <span class="ml-3 text-gray-700">Transfer the exact amount to the BCA account above</span>
                </li>
                <li class="flex">
                    <span class="flex-shrink-0 w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</span>
                    <span class="ml-3 text-gray-700">Take a screenshot or photo of your payment receipt</span>
                </li>
                <li class="flex">
                    <span class="flex-shrink-0 w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</span>
                    <span class="ml-3 text-gray-700">Click "I've Made the Transfer" button below</span>
                </li>
                <li class="flex">
                    <span class="flex-shrink-0 w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold">4</span>
                    <span class="ml-3 text-gray-700">Upload your proof of payment</span>
                </li>
                <li class="flex">
                    <span class="flex-shrink-0 w-8 h-8 bg-emerald-600 text-white rounded-full flex items-center justify-center text-sm font-bold">5</span>
                    <span class="ml-3 text-gray-700">Wait for admin confirmation (usually within 24 hours)</span>
                </li>
            </ol>
        </div>

        {{-- Action Button --}}
        <a href="{{ route('payment.status', $payment->id) }}" class="block w-full py-4 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition-colors shadow-md hover:shadow-lg text-center">
            <div class="flex items-center justify-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                I've Made the Transfer
            </div>
        </a>

        {{-- Security Notice --}}
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                <svg class="w-4 h-4 inline mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Your payment will be verified by our admin team
            </p>
        </div>

        {{-- Cancel Link --}}
        <div class="mt-4 text-center">
            <a href="{{ route('items.view', $payment->item->slug) }}" class="text-sm text-gray-600 hover:text-gray-900">
                Cancel and go back
            </a>
        </div>
    </div>
</div>

{{-- MidTrans Script commented out - using manual bank transfer --}}
{{-- <script src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script> --}}

{{-- Removed MidTrans payment JavaScript --}}
@endsection
