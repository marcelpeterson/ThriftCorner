@extends('layouts.app')

@section('title', 'Payment Status - ' . config('app.name'))

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-xl shadow-lg border border-gray-200 p-8">
        <div id="payment-status-container">
            {{-- Loading State --}}
            <div class="text-center" id="loading-state">
                <div class="w-16 h-16 border-4 border-blue-600 border-t-transparent rounded-full animate-spin mx-auto mb-4"></div>
                <h2 class="text-2xl font-bold text-gray-900 mb-2">Processing Payment...</h2>
                <p class="text-gray-600 mb-4">Please wait while we confirm your payment.</p>
                <div class="inline-flex items-center px-4 py-2 bg-blue-50 rounded-lg">
                    <svg class="w-4 h-4 mr-2 text-blue-600 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd"/>
                    </svg>
                    <span class="text-sm text-blue-700" id="status-message">Checking payment status...</span>
                </div>
            </div>

            {{-- Success State --}}
            <div class="hidden" id="success-state">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Payment Successful!</h2>
                    <p class="text-gray-600">Your listing is now premium and will get more visibility.</p>
                </div>

                {{-- Order Details --}}
                <div class="bg-gray-50 rounded-lg p-6 mb-6">
                    <h3 class="font-bold text-gray-900 mb-4">Order Details</h3>
                    <div class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <span class="text-gray-700">Order ID:</span>
                            <span class="font-semibold text-gray-900">{{ $payment->order_id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700">Package:</span>
                            <span class="font-semibold text-gray-900">{{ ucfirst($payment->premiumListing->package_type) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-gray-700">Duration:</span>
                            <span class="font-semibold text-gray-900">{{ $payment->premiumListing->duration_days }} days</span>
                        </div>
                        <div class="flex justify-between pt-3 border-t border-gray-200">
                            <span class="text-gray-700 font-bold">Amount Paid:</span>
                            <span class="font-bold text-emerald-600">{{ rupiah($payment->amount) }}</span>
                        </div>
                    </div>
                </div>

                {{-- Next Steps --}}
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                    <h4 class="font-bold text-blue-900 mb-2">What's Next?</h4>
                    <ul class="space-y-1 text-sm text-blue-800">
                        <li>✓ Your listing is now featured in premium placement</li>
                        <li>✓ Premium badge has been added to your listing</li>
                        <li>✓ You'll receive more views and inquiries</li>
                    </ul>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('items.view', $payment->item_id) }}" 
                       class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-center transition-colors">
                        View Your Listing
                    </a>
                    <a href="{{ route('home') }}" 
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg text-center transition-colors">
                        Back to Home
                    </a>
                </div>
            </div>

            {{-- Pending State --}}
            <div class="hidden" id="pending-state">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Payment Confirmation Pending</h2>
                    <p class="text-gray-600 mb-2">We're waiting for payment confirmation from the payment gateway.</p>
                    <p class="text-sm text-gray-500 mb-4">This usually takes a few seconds, but can take up to 5 minutes.</p>
                    <p class="text-sm text-gray-600">Order ID: <span class="font-mono font-semibold">{{ $payment->order_id }}</span></p>
                </div>

                <div class="bg-amber-50 border border-amber-200 rounded-lg p-6 mb-6">
                    <h4 class="font-bold text-amber-900 mb-2">Please Complete Your Payment</h4>
                    <p class="text-sm text-amber-800 mb-4">
                        If you haven't completed the payment, please finish it through the payment method you selected.
                        Your listing will be upgraded once we receive the payment confirmation.
                    </p>
                    <p class="text-sm text-amber-700 mb-3">
                        This page will automatically update when your payment is confirmed.
                    </p>
                    <div class="text-center">
                        <button onclick="manualRefresh()" 
                                class="inline-flex items-center px-4 py-2 bg-amber-600 hover:bg-amber-700 text-white font-semibold rounded-lg transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                            </svg>
                            Check Status Now
                        </button>
                    </div>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('items.view', $payment->item_id) }}" 
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg text-center transition-colors">
                        View Listing
                    </a>
                </div>
            </div>

            {{-- Failed State --}}
            <div class="hidden" id="failed-state">
                <div class="text-center mb-8">
                    <div class="w-20 h-20 bg-red-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-gray-900 mb-2">Payment Failed</h2>
                    <p class="text-gray-600">Unfortunately, your payment could not be processed.</p>
                </div>

                <div class="bg-red-50 border border-red-200 rounded-lg p-6 mb-6">
                    <h4 class="font-bold text-red-900 mb-2">What happened?</h4>
                    <p class="text-sm text-red-800 mb-4">
                        The payment was not successful. This could be due to insufficient funds, card declined, or transaction timeout.
                    </p>
                    <p class="text-sm text-red-700">
                        Please try again with a different payment method or contact us if the problem persists.
                    </p>
                </div>

                <div class="flex gap-4">
                    <a href="{{ route('premium.packages', $payment->item_id) }}" 
                       class="flex-1 px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg text-center transition-colors">
                        Try Again
                    </a>
                    <a href="{{ route('items.view', $payment->item_id) }}" 
                       class="flex-1 px-6 py-3 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold rounded-lg text-center transition-colors">
                        Back to Listing
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let checkAttempts = 0;
    const maxAttempts = 20; // Maximum 20 attempts (about 2 minutes total)
    
    // Update status message
    function updateStatusMessage(message) {
        const statusEl = document.getElementById('status-message');
        if (statusEl) {
            statusEl.textContent = message;
        }
    }
    
    // Check payment status with exponential backoff
    function checkPaymentStatus() {
        checkAttempts++;
        
        // Show appropriate message based on attempt number
        if (checkAttempts === 1) {
            updateStatusMessage('Verifying payment status...');
        } else {
            updateStatusMessage('Still checking... (Attempt ' + checkAttempts + ')');
        }
        
        fetch('{{ route('payment.status', $payment->id) }}')
            .then(response => response.json())
            .then(data => {
                console.log('Payment status (attempt ' + checkAttempts + '):', data);
                
                if (data.is_success) {
                    // Success - show success state
                    document.getElementById('loading-state').classList.add('hidden');
                    document.getElementById('pending-state').classList.add('hidden');
                    document.getElementById('success-state').classList.remove('hidden');
                } else if (data.status === 'pending') {
                    if (checkAttempts >= maxAttempts) {
                        // Max attempts reached - show pending state with manual refresh
                        document.getElementById('loading-state').classList.add('hidden');
                        document.getElementById('pending-state').classList.remove('hidden');
                    } else {
                        // Still pending - hide loading after first check
                        if (checkAttempts > 1) {
                            document.getElementById('loading-state').classList.add('hidden');
                            document.getElementById('pending-state').classList.remove('hidden');
                        }
                        
                        // Calculate delay with exponential backoff
                        // First few checks: 3s, then increase gradually
                        let delay = checkAttempts <= 3 ? 3000 : 
                                   checkAttempts <= 6 ? 5000 : 
                                   checkAttempts <= 10 ? 8000 : 10000;
                        
                        setTimeout(checkPaymentStatus, delay);
                    }
                } else {
                    // Failed or other status
                    document.getElementById('loading-state').classList.add('hidden');
                    document.getElementById('failed-state').classList.remove('hidden');
                }
            })
            .catch(error => {
                console.error('Error checking status:', error);
                
                if (checkAttempts >= maxAttempts) {
                    // Max attempts reached - show pending state
                    document.getElementById('loading-state').classList.add('hidden');
                    document.getElementById('pending-state').classList.remove('hidden');
                } else {
                    // Retry on error
                    setTimeout(checkPaymentStatus, 5000);
                }
            });
    }

    // Manual refresh button handler
    function manualRefresh() {
        document.getElementById('pending-state').classList.add('hidden');
        document.getElementById('loading-state').classList.remove('hidden');
        checkAttempts = 0;
        checkPaymentStatus();
    }

    // Start checking status when page loads
    document.addEventListener('DOMContentLoaded', function() {
        // Wait 3 seconds before first check (give time for webhook to process)
        setTimeout(checkPaymentStatus, 3000);
    });
</script>
@endpush
@endsection
