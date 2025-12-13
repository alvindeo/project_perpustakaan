<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\Book;
use App\Models\Member;
use App\Models\Fine;
use App\Models\LibraryInfo;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CirculationController extends Controller
{
    public function borrowForm()
    {
        return view('admin.circulation.borrow');
    }

    public function borrow(Request $request)
    {
        $validated = $request->validate([
            'member_id' => 'required|exists:members,id',
            'book_id' => 'required|exists:books,id',
        ]);

        $member = Member::findOrFail($validated['member_id']);
        $book = Book::findOrFail($validated['book_id']);

        // Check member status
        if ($member->status !== 'active') {
            return back()->with('error', 'Member is not active');
        }

        // Check if book is available
        if ($book->available <= 0) {
            return back()->with('error', 'Book is not available');
        }

        $borrowDays = (int) LibraryInfo::get('max_borrow_days', 7);

        // Create transaction
        $transaction = Transaction::create([
            'member_id' => $member->id,
            'book_id' => $book->id,
            'borrow_date' => now(),
            'due_date' => now()->addDays($borrowDays),
            'status' => 'borrowed',
        ]);

        // Update book availability
        $book->decrement('available');

        // Cancel any pending booking
        if ($request->has('booking_id')) {
            $booking = \App\Models\Booking::find($request->booking_id);
            if ($booking) {
                $booking->update(['status' => 'fulfilled']);
            }
        }

        return back()->with('success', 'Book borrowed successfully. Due date: ' . $transaction->due_date->format('d M Y'));
    }

    public function return(Transaction $transaction)
    {
        if ($transaction->status !== 'borrowed') {
            return back()->with('error', 'This transaction is not active');
        }

        // Update transaction
        $transaction->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);

        // Update book availability
        $transaction->book->increment('available');

        // Check if overdue and create fine
        if ($transaction->isOverdue()) {
            $daysOverdue = $transaction->daysOverdue();
            $finePerDay = LibraryInfo::get('fine_per_day', 1000);
            $fineAmount = $daysOverdue * $finePerDay;

            Fine::create([
                'transaction_id' => $transaction->id,
                'member_id' => $transaction->member_id,
                'days_overdue' => $daysOverdue,
                'amount' => $fineAmount,
                'status' => 'unpaid',
            ]);

            return back()->with('warning', 'Book returned. Overdue ' . $daysOverdue . ' days. Fine: Rp ' . number_format($fineAmount));
        }

        return back()->with('success', 'Book returned successfully');
    }

    public function history()
    {
        $transactions = Transaction::with(['member', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.circulation.history', compact('transactions'));
    }
}
