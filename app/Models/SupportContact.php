<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupportContact extends Model
{
    protected $fillable = [
        'user_id',
        'item_id',
        'name',
        'email',
        'type',
        'subject',
        'message',
        'attachment_path',
        'status',
        'admin_notes',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the user who submitted this contact
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get formatted type label
     */
    public function getTypeLabelAttribute(): string
    {
        return match($this->type) {
            'report_suspicious' => 'Report Suspicious Activity',
            'feedback' => 'Feedback',
            'delete_listing' => 'Delete Listing Request',
            default => ucfirst($this->type),
        };
    }

    /**
     * Get formatted status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'pending' => 'Pending',
            'in_progress' => 'In Progress',
            'resolved' => 'Resolved',
            default => ucfirst($this->status),
        };
    }

    /**
     * Get status badge color
     */
    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'pending' => 'yellow',
            'in_progress' => 'blue',
            'resolved' => 'green',
            default => 'gray',
        };
    }
}
