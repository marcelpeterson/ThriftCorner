@extends('layouts.app')

@section('title', 'Checkout - ' . config('app.name'))

@section('content')
<div class="max-w-3xl mx-auto max-md:mt-6">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        {{-- Header --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-900 mb-2 max-md:font-black">Complete Your Payment</h1>
            <p class="text-gray-600">Secure payment powered by Midtrans</p>
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

        {{-- Payment Button --}}
        <button id="pay-button" class="w-full py-4 px-6 bg-emerald-600 hover:bg-emerald-700 text-white font-bold rounded-lg transition-colors shadow-md hover:shadow-lg cursor-pointer">
            <div class="flex items-center justify-center">
                <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                </svg>
                Pay Now
            </div>
        </button>

        {{-- Security Notice --}}
        <div class="mt-6 text-center">
            <p class="text-sm text-gray-600">
                <svg class="w-4 h-4 inline mr-1 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                </svg>
                Secure payment. Your data is encrypted and protected.
            </p>
        </div>

        {{-- Cancel Link --}}
        <div class="mt-4 text-center">
            <a href="{{ route('items.view', $payment->item_id) }}" class="text-sm text-gray-600 hover:text-gray-900">
                Cancel and go back
            </a>
        </div>
    </div>
</div>

{{-- Midtrans Snap Script --}}
<script src="https://app.{{ config('midtrans.is_production') ? '' : 'sandbox.' }}midtrans.com/snap/snap.js" 
        data-client-key="{{ config('midtrans.client_key') }}"></script>

<script type="text/javascript">
    document.getElementById('pay-button').onclick = function(){
        snap.pay('{{ $payment->snap_token }}', {
            onSuccess: function(result){
                console.log('Payment success:', result);
                window.location.href = '{{ route('payment.finish', $payment->id) }}';
            },
            onPending: function(result){
                console.log('Payment pending:', result);
                // QRIS immediately calls onPending when QR is displayed (before user scans)
                // Other methods call onPending only after user submits payment details
                // Check payment type to handle QRIS differently
                const paymentType = result.payment_type || '';
                
                if (paymentType === 'qris') {
                    // For QRIS, don't auto-redirect on pending
                    // User needs to scan QR and complete payment first
                    console.log('QRIS payment initiated - waiting for user to scan QR code');
                } else {
                    // For other payment methods, redirect to finish page
                    window.location.href = '{{ route('payment.finish', $payment->id) }}';
                }
            },
            onError: function(result){
                console.log('Payment error:', result);
                alert('Payment failed. Please try again.');
            },
            onClose: function(){
                console.log('Customer closed the popup without finishing the payment');
                // Don't redirect on close - let user stay on checkout page to retry
            }
        });
    };
</script>
@endsection
