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
        'proof_of_payment',
        'bank_name',
        'account_name',
        'account_number',
        'confirmed_at',
        'confirmed_by',
        'admin_notes',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'confirmed_at' => 'datetime',
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

    public function confirmedBy()
    {
        return $this->belongsTo(User::class, 'confirmed_by');
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
