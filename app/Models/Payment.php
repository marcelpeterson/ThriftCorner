<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'premium_listing_id',
        'order_id',
        'transaction_id',
        'payment_type',
        'amount',
        'status',
        'payment_method',
        'paid_at',
        'midtrans_response',
        'snap_token',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'midtrans_response' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function premiumListing()
    {
        return $this->belongsTo(PremiumListing::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isSuccess()
    {
        return $this->status === 'success';
    }

    public function isFailed()
    {
        return in_array($this->status, ['failed', 'expired', 'cancelled']);
    }
}
