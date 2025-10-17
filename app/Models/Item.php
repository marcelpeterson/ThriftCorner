<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'slug',
        'description',
        'price',
        'photo_url',
        'condition',
        'is_sold',
        'transaction_id',
        'is_premium',
        'premium_until',
    ];

    protected $casts = [
        'is_sold' => 'boolean',
        'is_premium' => 'boolean',
        'premium_until' => 'datetime',
    ];

    protected static function booted()
    {
        static::creating(function ($item) {
            if (empty($item->slug)) {
                $base = Str::slug($item->name ?? 'item');
                if ($base === '') {
                    $base = 'item';
                }

                // Always append random suffix for uniqueness
                $suffix = '-' . Str::lower(Str::random(6));
                $slug = substr($base, 0, 255 - strlen($suffix)) . $suffix;

                $item->slug = $slug;
            }
        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function images()
    {
        return $this->hasMany(ItemImage::class)->orderBy('order');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function premiumListing()
    {
        return $this->hasMany(PremiumListing::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function isPremium()
    {
        return $this->is_premium && 
               $this->premium_until && 
               $this->premium_until->isFuture();
    }

    /**
     * Accessor: formatted Rupiah price (no decimals, thousand separators with dots)
     */
    public function getPriceRupiahAttribute(): string
    {
        return rupiah($this->price);
    }

    /**
     * Accessor: get the full URL for the photo
     */
    public function getPhotoAttribute(): ?string
    {
        if (!$this->photo_url) {
            return null;
        }

        if (filter_var($this->photo_url, FILTER_VALIDATE_URL)) {
            return $this->photo_url;
        }

        if (str_starts_with($this->photo_url, 'storage/')) {
            return asset($this->photo_url);
        }

        return asset('storage/' . $this->photo_url);
    }

    /**
     * Scope: search items by name and description
     */
    public function scopeSearch($query, $search)
    {
        return $query->when($search, function ($q) use ($search) {
            $q->where(function ($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhere('description', 'like', '%' . $search . '%');
            });
        });
    }

    /**
     * Scope: filter by category
     */
    public function scopeCategory($query, $categoryId)
    {
        return $query->when($categoryId, function ($q) use ($categoryId) {
            $q->where('category_id', $categoryId);
        });
    }

    /**
     * Scope: filter by condition
     */
    public function scopeCondition($query, $condition)
    {
        return $query->when($condition, function ($q) use ($condition) {
            $q->where('condition', $condition);
        });
    }

    /**
     * Scope: filter by price range
     */
    public function scopePriceRange($query, $minPrice, $maxPrice)
    {
        return $query->when($minPrice !== null && $minPrice !== '', function ($q) use ($minPrice) {
            $q->where('price', '>=', $minPrice);
        })->when($maxPrice !== null && $maxPrice !== '', function ($q) use ($maxPrice) {
            $q->where('price', '<=', $maxPrice);
        });
    }

    /**
     * Scope: filter available items (not sold)
     */
    public function scopeAvailable($query)
    {
        return $query->where('is_sold', false);
    }

    /**
     * Scope: premium items first
     */
    public function scopePremiumFirst($query)
    {
        return $query->orderByRaw('is_premium DESC, premium_until DESC');
    }
}
