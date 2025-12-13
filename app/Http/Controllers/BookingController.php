<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Book;
use App\Models\LibraryInfo;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $member = auth('member')->user()->member;
        
        // Check if member already has an active booking
        if ($member->hasActiveBooking()) {
            return back()->with('error', 'Anda sudah memiliki booking aktif. Maksimal 1 booking per anggota.');
        }

        $book = Book::findOrFail($request->book_id);
        
        // Check if book is available
        if (!$book->isAvailable()) {
            return back()->with('error', 'Buku tidak tersedia untuk dibooking.');
        }

        $maxDays = (int) LibraryInfo::get('max_borrow_days', 7);
        
        Booking::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'booking_date' => now(),
            'expiry_date' => now()->addDays($maxDays),
            'status' => 'pending',
        ]);

        return back()->with('success', 'Booking berhasil dibuat. Silakan ambil buku dalam ' . $maxDays . ' hari.');
    }

    public function destroy(Booking $booking)
    {
        $member = auth('member')->user()->member;
        
        // Ensure the booking belongs to the member
        if ($booking->member_id !== $member->id) {
            abort(403);
        }

        $booking->update(['status' => 'cancelled']);

        return back()->with('success', 'Booking berhasil dibatalkan.');
    }
}
