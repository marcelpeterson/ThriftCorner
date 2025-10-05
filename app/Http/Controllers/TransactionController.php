<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Item;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a listing of the user's transactions
     */
    public function index()
    {
        $user = auth()->user();
        
        // Get transactions where user is seller or buyer
        $transactions = Transaction::with(['item.images', 'seller', 'buyer'])
            ->where(function ($query) use ($user) {
                $query->where('seller_id', $user->id)
                      ->orWhere('buyer_id', $user->id);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('transactions.index', compact('transactions'));
    }

    /**
     * Initiate a transaction (seller marks item as sold)
     */
    public function markAsSold(Request $request, $itemId)
    {
        $item = Item::findOrFail($itemId);

        // Check if user is the seller
        if ($item->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if item is already sold
        if ($item->is_sold) {
            return redirect()->back()->with('error', 'This item is already marked as sold.');
        }

        // Create transaction
        $transaction = Transaction::create([
            'item_id' => $item->id,
            'seller_id' => auth()->id(),
            'status' => 'pending',
        ]);

        // Update item
        $item->update(['transaction_id' => $transaction->id]);

        return redirect()->route('transaction.links', $transaction->id)
            ->with('success', 'Transaction initiated! Share the confirmation link with your buyer.');
    }

    /**
     * Show transaction confirmation links
     */
    public function showLinks($transactionId)
    {
        $transaction = Transaction::with(['item', 'seller'])->findOrFail($transactionId);

        // Check if user is the seller
        if ($transaction->seller_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        return view('transactions.links', compact('transaction'));
    }

    /**
     * Show confirmation page (accessed via unique token)
     */
    public function showConfirmation($token)
    {
        $transaction = Transaction::with(['item.images', 'seller', 'buyer'])
            ->where('seller_token', $token)
            ->orWhere('buyer_token', $token)
            ->firstOrFail();

        $isSeller = $transaction->seller_token === $token;
        $isBuyer = $transaction->buyer_token === $token;

        return view('transactions.confirm', compact('transaction', 'isSeller', 'isBuyer'));
    }

    /**
     * Confirm transaction
     */
    public function confirm(Request $request, $token)
    {
        $transaction = Transaction::where('seller_token', $token)
            ->orWhere('buyer_token', $token)
            ->firstOrFail();

        $isSeller = $transaction->seller_token === $token;

        if ($isSeller) {
            $transaction->update([
                'seller_confirmed' => true,
                'seller_confirmed_at' => now(),
            ]);
        } else {
            // First time buyer confirms, associate them with the transaction
            if (!$transaction->buyer_id) {
                $transaction->update([
                    'buyer_id' => auth()->id(),
                ]);
            }

            $transaction->update([
                'buyer_confirmed' => true,
                'buyer_confirmed_at' => now(),
            ]);
        }

        // Check if both confirmed
        if ($transaction->fresh()->isCompleted()) {
            $transaction->markAsCompleted();
            return redirect()->route('transaction.report', $transaction->id)
                ->with('success', 'Transaction completed successfully!');
        }

        return redirect()->route('transaction.confirm', $token)
            ->with('success', 'Your confirmation has been recorded. Waiting for the other party.');
    }

    /**
     * Show transaction report
     */
    public function report($transactionId)
    {
        $transaction = Transaction::with(['item.images', 'item.category', 'seller', 'buyer', 'rating.rater'])
            ->findOrFail($transactionId);

        // Check if user is involved in the transaction
        if ($transaction->seller_id !== auth()->id() && $transaction->buyer_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        // Check if transaction is completed
        if ($transaction->status !== 'completed') {
            abort(403, 'Transaction is not yet completed.');
        }

        $isBuyer = $transaction->buyer_id === auth()->id();
        $hasRated = $transaction->rating !== null;

        return view('transactions.report', compact('transaction', 'isBuyer', 'hasRated'));
    }

    /**
     * Cancel transaction
     */
    public function cancel($transactionId)
    {
        $transaction = Transaction::findOrFail($transactionId);

        // Only seller can cancel
        if ($transaction->seller_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $transaction->update(['status' => 'cancelled']);
        $transaction->item->update(['transaction_id' => null]);

        return redirect()->route('items.view', $transaction->item_id)
            ->with('success', 'Transaction cancelled.');
    }
}
