<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Booking extends Model
{
    protected $fillable = [
        'member_id', 'book_id', 'booking_date', 'expiry_date', 'status'
    ];

    protected $casts = [
        'booking_date' => 'date',
        'expiry_date' => 'date',
    ];

    public function member(): BelongsTo
    {
        return $this->belongsTo(Member::class);
    }

    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    public function isExpired(): bool
    {
        return now()->isAfter($this->expiry_date) && $this->status === 'pending';
    }
}
