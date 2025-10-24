<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Auth\Passwords\CanResetPassword;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements MustVerifyEmail
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, CanResetPassword;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'photo_url',
        'role',
        'is_admin',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'is_admin' => 'boolean',
        ];
    }

    /**
     * Get the user's full name.
     */
    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }

    /**
     * Get the user's photo URL with proper handling for different storage scenarios.
     */
    public function getPhotoAttribute(): ?string
    {
        if (!$this->photo_url) {
            return null;
        }

        // If it's already a full URL, return as is
        if (filter_var($this->photo_url, FILTER_VALIDATE_URL)) {
            return $this->photo_url;
        }

        // If it's a base64 avatar (from Laravolt), return as is
        if (str_starts_with($this->photo_url, 'data:image/')) {
            return $this->photo_url;
        }

        // If it starts with 'storage/', use asset() helper
        if (str_starts_with($this->photo_url, 'storage/')) {
            return asset($this->photo_url);
        }

        // For R2 storage, use Storage::url()
        try {
            return \Storage::url($this->photo_url);
        } catch (\Exception $e) {
            // Fallback to asset with storage prefix
            return asset('storage/' . $this->photo_url);
        }
    }

    /**
     * Get items listed by this user.
     */
    public function items()
    {
        return $this->hasMany(Item::class);
    }

    /**
     * Get ratings given by this user.
     */
    public function ratingsGiven()
    {
        return $this->hasMany(Rating::class, 'rater_id');
    }

    /**
     * Get ratings received by this user.
     */
    public function ratingsReceived()
    {
        return $this->hasMany(Rating::class, 'rated_user_id');
    }

    /**
     * Get the user's average rating.
     */
    public function getAverageRatingAttribute(): float
    {
        return round($this->ratingsReceived()->avg('rating') ?? 0, 1);
    }

    /**
     * Get the total number of ratings received.
     */
    public function getTotalRatingsAttribute(): int
    {
        return $this->ratingsReceived()->count();
    }

    /**
     * Send the password reset notification.
     *
     * @param string $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
