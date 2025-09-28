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

    /**
     * Accessor: formatted Rupiah price (no decimals, thousand separators with dots)
     */
    public function getPriceRupiahAttribute(): string
    {
        return rupiah($this->price);
    }
}
