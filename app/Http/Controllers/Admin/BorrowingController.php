<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index(Request $request)
    {
        $query = Transaction::with(['member', 'book'])
            ->where('status', 'borrowed');
        
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
        
        // Filter by status
        if ($request->status === 'overdue') {
            $query->where('due_date', '<', now());
        }
        
        $borrowings = $query->orderBy('id', 'asc')->paginate(15);
        
        return view('admin.borrowings.index', compact('borrowings'));
    }
    
    public function destroy(Transaction $transaction)
    {
        // Cancel borrowing - return the book
        $transaction->book->increment('available');
        $transaction->delete();
        
        return redirect()->route('admin.borrowings.index')
            ->with('success', 'Borrowing cancelled successfully.');
    }
}
