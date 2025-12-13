<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Book extends Model
{
    protected $fillable = [
        'isbn', 'title', 'author', 'category_id', 'publisher', 
        'publication_year', 'synopsis', 'cover_image', 'stock', 
        'available', 'qr_code'
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function isAvailable(): bool
    {
        return $this->available > 0;
    }

    public function currentBorrowings()
    {
        return $this->transactions()->where('status', 'borrowed')->count();
    }
}
