<?php

namespace App\Http\Controllers;

use App\Models\Rating;
use App\Models\Transaction;
use App\Http\Requests\StoreRatingRequest;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class RatingController extends Controller
{
    use AuthorizesRequests;
    /**
     * Store a new rating for a completed transaction
     */
    public function store(StoreRatingRequest $request, $transactionId)
    {
        $transaction = Transaction::with(['seller', 'buyer', 'rating'])->findOrFail($transactionId);

        // Authorize using policy
        $this->authorize('create', [Rating::class, $transaction]);

        // Create rating
        Rating::create([
            'transaction_id' => $transactionId,
            'rater_id' => auth()->id(),
            'rated_user_id' => $transaction->seller_id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return redirect()->route('transaction.report', $transactionId)
            ->with('success', 'Thank you for your rating and review!');
    }
}
