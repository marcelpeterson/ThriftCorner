<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PremiumListing extends Model
{
    protected $fillable = [
        'item_id',
        'user_id',
        'package_type',
        'price',
        'duration_days',
        'starts_at',
        'expires_at',
        'is_active',
        'features',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
        'features' => 'array',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payment()
    {
        return $this->hasOne(Payment::class);
    }

    public function activate()
    {
        $this->starts_at = now();
        $this->expires_at = now()->addDays($this->duration_days);
        $this->is_active = true;
        $this->save();

        // Update item premium status
        $this->item->update([
            'is_premium' => true,
            'premium_until' => $this->expires_at,
        ]);
    }

    public function deactivate()
    {
        $this->is_active = false;
        $this->save();

        // Update item premium status
        $this->item->update([
            'is_premium' => false,
            'premium_until' => null,
        ]);
    }

    public function isActive()
    {
        return $this->is_active && 
               $this->expires_at && 
               $this->expires_at->isFuture();
    }

    public function isExpired()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public static function getPackages()
    {
        return [
            'featured' => [
                'name' => 'Featured Listing',
                'price' => 25000, // IDR 25,000
                'duration_days' => 14,
                'features' => [
                    // 'Premium badge on your listing',
                    'Highlighted in search results',
                    // 'Featured section on homepage',
                    'Priority in all listings',
                    '14 days of maximum visibility',
                ],
                'color' => 'purple',
                'description' => 'Get maximum visibility and sell faster with featured placement',
            ],
        ];
    }
}
