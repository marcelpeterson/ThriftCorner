<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\Payment;
use App\Models\PremiumListing;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function __construct()
    {
        // Configure Midtrans
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

    /**
     * Show premium packages selection page
     */
    public function showPackages(Item $item)
    {
        $item->load(['user', 'images']);

        // Check if user owns the item
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Get all active premium packages for this item
        $activePremiumPackages = PremiumListing::where('item_id', $item->id)
            ->where('is_active', true)
            ->where('expires_at', '>', now())
            ->get();

        $packages = PremiumListing::getPackages();

        return view('premium.packages', compact('item', 'packages', 'activePremiumPackages'));
    }

    /**
     * Create payment for premium listing
     */
    public function createPayment(Request $request, Item $item)
    {
        $request->validate([
            'package_type' => 'required|in:hero,featured',
        ]);

        // Check if user owns the item
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $packages = PremiumListing::getPackages();
        $selectedPackage = $packages[$request->package_type];

        // Create premium listing record
        $premiumListing = PremiumListing::create([
            'item_id' => $item->id,
            'user_id' => auth()->id(),
            'package_type' => $request->package_type,
            'price' => $selectedPackage['price'],
            'duration_days' => $selectedPackage['duration_days'],
            'features' => $selectedPackage['features'],
            'is_active' => false,
        ]);

        // Create payment record
        $orderId = 'PREMIUM-' . $item->id . '-' . time();
        
        $payment = Payment::create([
            'user_id' => auth()->id(),
            'item_id' => $item->id,
            'premium_listing_id' => $premiumListing->id,
            'order_id' => $orderId,
            'payment_type' => 'premium_listing',
            'amount' => $selectedPackage['price'],
            'status' => 'pending',
        ]);

        // Prepare Midtrans transaction parameters
        $params = [
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => (int) $selectedPackage['price'],
            ],
            'item_details' => [
                [
                    'id' => $request->package_type,
                    'price' => (int) $selectedPackage['price'],
                    'quantity' => 1,
                    'name' => $selectedPackage['name'] . ' - ' . $item->name,
                ]
            ],
            'customer_details' => [
                'first_name' => auth()->user()->first_name,
                'last_name' => auth()->user()->last_name,
                'email' => auth()->user()->email,
                'phone' => auth()->user()->phone,
            ],
            'callbacks' => [
                'finish' => route('payment.finish', $payment->id),
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            
            $payment->update(['snap_token' => $snapToken]);

            return redirect()->route('payment.checkout', $payment->id);
        } catch (\Exception $e) {
            $payment->update(['status' => 'failed']);
            return redirect()->back()->with('error', 'Failed to create payment: ' . $e->getMessage());
        }
    }

    /**
     * Show checkout page with Snap token
     */
    public function checkout($paymentId)
    {
        $payment = Payment::with(['item.images', 'premiumListing'])->findOrFail($paymentId);

        // Check if user owns the payment
        if ($payment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if payment is still pending
        if ($payment->status !== 'pending') {
            return redirect()->route('items.view', $payment->item->slug)
                ->with('info', 'This payment has already been processed.');
        }

        $packages = PremiumListing::getPackages();
        $package = $packages[$payment->premiumListing->package_type];

        return view('premium.checkout', compact('payment', 'package'));
    }

    /**
     * Handle Midtrans notification callback
     */
    public function notification(Request $request)
    {
        try {
            $notification = new \Midtrans\Notification();

            $orderId = $notification->order_id;
            $transactionStatus = $notification->transaction_status;
            $fraudStatus = $notification->fraud_status;

            $payment = Payment::where('order_id', $orderId)->firstOrFail();

            // Update payment with transaction details
            $payment->update([
                'transaction_id' => $notification->transaction_id,
                'payment_method' => $notification->payment_type ?? null,
                'midtrans_response' => $request->all(),
            ]);

            // Handle transaction status
            if ($transactionStatus == 'capture') {
                if ($fraudStatus == 'accept') {
                    $this->handleSuccessPayment($payment);
                }
            } elseif ($transactionStatus == 'settlement') {
                $this->handleSuccessPayment($payment);
            } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                $payment->update(['status' => 'failed']);
            } elseif ($transactionStatus == 'pending') {
                $payment->update(['status' => 'pending']);
            }

            return response()->json(['status' => 'success']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    /**
     * Handle successful payment
     */
    private function handleSuccessPayment(Payment $payment)
    {
        $payment->update([
            'status' => 'success',
            'paid_at' => now(),
        ]);

        // Activate premium listing
        $payment->premiumListing->activate();
    }

    /**
     * Payment finish page (after user completes payment on Midtrans)
     */
    public function finish($paymentId)
    {
        $payment = Payment::with(['item', 'premiumListing'])->findOrFail($paymentId);

        // Check if user owns the payment
        if ($payment->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('premium.finish', compact('payment'));
    }

    /**
     * Check payment status (AJAX)
     */
    public function checkStatus($paymentId)
    {
        $payment = Payment::findOrFail($paymentId);

        if ($payment->user_id !== auth()->id()) {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        // If payment is still pending, check with Midtrans directly
        if ($payment->status === 'pending') {
            try {
                $status = \Midtrans\Transaction::status($payment->order_id);
                
                // Update payment based on Midtrans response
                $transactionStatus = $status->transaction_status;
                $fraudStatus = $status->fraud_status ?? 'accept';

                // Update transaction details
                $payment->update([
                    'transaction_id' => $status->transaction_id ?? null,
                    'payment_method' => $status->payment_type ?? null,
                ]);

                // Handle status
                if ($transactionStatus == 'capture') {
                    if ($fraudStatus == 'accept') {
                        $this->handleSuccessPayment($payment);
                    }
                } elseif ($transactionStatus == 'settlement') {
                    $this->handleSuccessPayment($payment);
                } elseif (in_array($transactionStatus, ['cancel', 'deny', 'expire'])) {
                    $payment->update(['status' => 'failed']);
                } elseif ($transactionStatus == 'pending') {
                    // Still pending, no change needed
                }
            } catch (\Exception $e) {
                // If Midtrans check fails, return current database status
                \Log::warning('Failed to check Midtrans status: ' . $e->getMessage());
            }

            // Reload payment to get updated status
            $payment->refresh();
        }

        return response()->json([
            'status' => $payment->status,
            'is_success' => $payment->isSuccess(),
            'redirect_url' => route('items.view', $payment->item->slug),
        ]);
    }
}
