<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Illuminate\Http\Request;

class BookingManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Booking::with(['member', 'book'])
            ->where('status', 'pending');
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('member_code', 'like', "%{$search}%");
            })->orWhereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }
        
        $bookings = $query->orderBy('booking_date', 'desc')->paginate(15);
        
        return view('admin.bookings.index', compact('bookings'));
    }
    
    public function destroy(Booking $booking)
    {
        $booking->update(['status' => 'cancelled']);
        
        return redirect()->route('admin.bookings.index')
            ->with('success', 'Booking cancelled successfully.');
    }
}
