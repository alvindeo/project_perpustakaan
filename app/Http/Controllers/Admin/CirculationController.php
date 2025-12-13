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

    public function processBorrow(Request $request)
    {
        $validated = $request->validate([
            'member_code' => 'required|exists:members,member_code',
            'isbn' => 'required|exists:books,isbn',
        ]);

        $member = Member::where('member_code', $validated['member_code'])->first();
        $book = Book::where('isbn', $validated['isbn'])->first();

        // Check member status
        if ($member->status !== 'active') {
            return back()->with('error', 'Anggota tidak aktif');
        }

        // Check if book is available
        if ($book->available <= 0) {
            return back()->with('error', 'Buku tidak tersedia');
        }

        // Check max borrowing limit
        $maxBooks = LibraryInfo::get('max_books_per_member', 3);
        $currentBorrowings = $member->activeBorrowings()->count();
        
        if ($currentBorrowings >= $maxBooks) {
            return back()->with('error', 'Anggota sudah mencapai batas maksimal peminjaman (' . $maxBooks . ' buku)');
        }

        // Check if member has unpaid fines
        if ($member->totalUnpaidFines() > 0) {
            return back()->with('error', 'Anggota memiliki denda yang belum dibayar');
        }

        $borrowDays = LibraryInfo::get('max_borrow_days', 7);

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

        // Cancel any pending booking for this book by this member
        $member->bookings()
            ->where('book_id', $book->id)
            ->where('status', 'pending')
            ->update(['status' => 'fulfilled']);

        return back()->with('success', 'Peminjaman berhasil. Batas pengembalian: ' . $transaction->due_date->format('d/m/Y'));
    }

    public function returnForm()
    {
        return view('admin.circulation.return');
    }

    public function processReturn(Request $request)
    {
        $validated = $request->validate([
            'member_code' => 'required|exists:members,member_code',
            'isbn' => 'required|exists:books,isbn',
        ]);

        $member = Member::where('member_code', $validated['member_code'])->first();
        $book = Book::where('isbn', $validated['isbn'])->first();

        // Find active transaction
        $transaction = Transaction::where('member_id', $member->id)
            ->where('book_id', $book->id)
            ->where('status', 'borrowed')
            ->first();

        if (!$transaction) {
            return back()->with('error', 'Tidak ada transaksi peminjaman aktif untuk buku ini');
        }

        // Update transaction
        $transaction->update([
            'return_date' => now(),
            'status' => 'returned',
        ]);

        // Update book availability
        $book->increment('available');

        // Check if overdue and create fine
        if ($transaction->isOverdue()) {
            $daysOverdue = $transaction->daysOverdue();
            $finePerDay = LibraryInfo::get('fine_per_day', 1000);
            $fineAmount = $daysOverdue * $finePerDay;

            Fine::create([
                'transaction_id' => $transaction->id,
                'member_id' => $member->id,
                'days_overdue' => $daysOverdue,
                'amount' => $fineAmount,
                'status' => 'unpaid',
            ]);

            return back()->with('warning', 'Pengembalian berhasil. Terlambat ' . $daysOverdue . ' hari. Denda: Rp ' . number_format($fineAmount, 0, ',', '.'));
        }

        return back()->with('success', 'Pengembalian berhasil');
    }

    public function history()
    {
        $transactions = Transaction::with(['member', 'book'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.circulation.history', compact('transactions'));
    }
}
