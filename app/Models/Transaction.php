<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Transaction extends Model
{
    protected $fillable = [
        'item_id',
        'seller_id',
        'buyer_id',
        'seller_token',
        'buyer_token',
        'seller_confirmed',
        'buyer_confirmed',
        'seller_confirmed_at',
        'buyer_confirmed_at',
        'completed_at',
        'status',
    ];

    protected $casts = [
        'seller_confirmed' => 'boolean',
        'buyer_confirmed' => 'boolean',
        'seller_confirmed_at' => 'datetime',
        'buyer_confirmed_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (empty($transaction->seller_token)) {
                $transaction->seller_token = Str::random(64);
            }
            if (empty($transaction->buyer_token)) {
                $transaction->buyer_token = Str::random(64);
            }
        });
    }

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function getSellerConfirmationUrlAttribute(): string
    {
        return route('transaction.confirm', ['token' => $this->seller_token]);
    }

    public function getBuyerConfirmationUrlAttribute(): string
    {
        return route('transaction.confirm', ['token' => $this->buyer_token]);
    }

    public function isCompleted(): bool
    {
        return $this->seller_confirmed && $this->buyer_confirmed;
    }

    public function markAsCompleted(): void
    {
        if ($this->isCompleted() && $this->status !== 'completed') {
            $this->update([
                'status' => 'completed',
                'completed_at' => now(),
            ]);

            // Mark item as sold
            $this->item->update(['is_sold' => true]);
        }
    }
}
