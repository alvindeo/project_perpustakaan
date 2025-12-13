<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Fine;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function dashboard()
    {
        $member = auth('member')->user()->member;
        
        if (!$member) {
            return redirect()->route('home')->with('error', 'Member profile not found');
        }

        $activeBorrowings = $member->activeBorrowings()->with('book')->get();
        $overdueCount = $activeBorrowings->filter(function($transaction) {
            return $transaction->isOverdue();
        })->count();
        
        $totalFines = $member->totalUnpaidFines();
        $activeBooking = $member->bookings()->where('status', 'pending')->with('book')->first();

        return view('member.dashboard', compact('member', 'activeBorrowings', 'overdueCount', 'totalFines', 'activeBooking'));
    }

    public function profile()
    {
        $member = auth('member')->user()->member;
        
        return view('member.profile', compact('member'));
    }

    public function history()
    {
        $member = auth('member')->user()->member;
        $transactions = $member->transactions()->with('book')->orderBy('created_at', 'desc')->paginate(10);

        return view('member.history', compact('transactions'));
    }

    public function fines()
    {
        $member = auth('member')->user()->member;
        $fines = $member->fines()->with('transaction.book')->orderBy('created_at', 'desc')->paginate(10);
        $totalUnpaid = $member->totalUnpaidFines();

        return view('member.fines', compact('fines', 'totalUnpaid'));
    }
    
    public function borrowBook(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);
        
        $member = auth('member')->user()->member;
        $book = \App\Models\Book::findOrFail($validated['book_id']);
        
        // Check member status
        if ($member->status !== 'active') {
            return back()->with('error', 'Your account is not active. Please contact the librarian.');
        }
        
        // Check if book is available
        if ($book->available <= 0) {
            return back()->with('error', 'This book is currently not available.');
        }
        
        // Check max borrowing limit
        $maxBooks = \App\Models\LibraryInfo::get('max_books_per_member', 3);
        $currentBorrowings = $member->activeBorrowings()->count();
        
        if ($currentBorrowings >= $maxBooks) {
            return back()->with('error', 'You have reached the maximum borrowing limit (' . $maxBooks . ' books).');
        }
        
        // Check if member has unpaid fines
        if ($member->totalUnpaidFines() > 0) {
            return back()->with('error', 'You have unpaid fines. Please pay them before borrowing new books.');
        }
        
        $borrowDays = (int) \App\Models\LibraryInfo::get('max_borrow_days', 7);
        
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
        $member->bookings()
            ->where('book_id', $book->id)
            ->where('status', 'pending')
            ->update(['status' => 'fulfilled']);
        
        return back()->with('success', 'Book borrowed successfully! Please return by ' . $transaction->due_date->format('d M Y'));
    }
    
    public function returnBook(Transaction $transaction)
    {
        $member = auth('member')->user()->member;
        
        // Check if this transaction belongs to the member
        if ($transaction->member_id !== $member->id) {
            return back()->with('error', 'This transaction does not belong to you.');
        }
        
        if ($transaction->status !== 'borrowed') {
            return back()->with('error', 'This book has already been returned.');
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
            $finePerDay = \App\Models\LibraryInfo::get('fine_per_day', 1000);
            $fineAmount = $daysOverdue * $finePerDay;
            
            Fine::create([
                'transaction_id' => $transaction->id,
                'member_id' => $member->id,
                'days_overdue' => $daysOverdue,
                'amount' => $fineAmount,
                'status' => 'unpaid',
            ]);
            
            return redirect()->route('member.dashboard')
                ->with('warning', 'Book returned successfully. You have a fine of Rp ' . number_format($fineAmount) . ' for being ' . $daysOverdue . ' days late.');
        }
        
        return redirect()->route('member.dashboard')
            ->with('success', 'Book returned successfully!');
    }
}
