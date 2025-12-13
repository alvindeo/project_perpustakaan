<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Member extends Model
{
    protected $fillable = [
        'member_code', 'name', 'email', 'member_type', 'class', 
        'phone', 'address', 'status', 'qr_code', 'user_id'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function fines(): HasMany
    {
        return $this->hasMany(Fine::class);
    }

    public function activeBorrowings()
    {
        return $this->transactions()->where('status', 'borrowed');
    }

    public function hasActiveBooking(): bool
    {
        return $this->bookings()->where('status', 'pending')->exists();
    }

    public function totalUnpaidFines()
    {
        return $this->fines()->where('status', 'unpaid')->sum('amount');
    }
}
