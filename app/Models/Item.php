<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $fillable = [
        'category_id',
        'user_id',
        'name',
        'description',
        'price',
        'photo_url',
        'condition',
    ];

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
}
