<?php

namespace App\Policies;

use App\Models\Rating;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class RatingPolicy
{
    /**
     * Determine whether the user can view the rating.
     */
    public function view(User $user, Rating $rating): bool
    {
        // Users involved in the transaction can view the rating
        return $rating->transaction->buyer_id === $user->id 
            || $rating->transaction->seller_id === $user->id;
    }

    /**
     * Determine whether the user can create a rating for a transaction.
     */
    public function create(User $user, $transaction): bool
    {
        // Only buyer can rate, only after completion, and only once
        return $transaction->buyer_id === $user->id 
            && $transaction->status === 'completed'
            && !$transaction->rating;
    }

    /**
     * Ratings cannot be updated once submitted.
     */
    public function update(User $user, Rating $rating): bool
    {
        return false;
    }

    /**
     * Ratings cannot be deleted by users.
     */
    public function delete(User $user, Rating $rating): bool
    {
        return false;
    }
}
