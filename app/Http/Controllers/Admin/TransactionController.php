<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function history(Request $request)
    {
        $query = Transaction::with(['member', 'book']);
        
        // Filter by date range
        if ($request->filled('start_date')) {
            $query->whereDate('borrow_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('borrow_date', '<=', $request->end_date);
        }
        
        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('member', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%");
            })->orWhereHas('book', function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }
        
        $transactions = $query->orderBy('id', 'asc')->paginate(20);
        
        return view('admin.transactions.history', compact('transactions'));
    }
    
    public function edit(Transaction $transaction)
    {
        $transaction->load(['member', 'book']);
        return view('admin.transactions.edit', compact('transaction'));
    }
    
    public function update(Request $request, Transaction $transaction)
    {
        $validated = $request->validate([
            'borrow_date' => 'required|date',
            'due_date' => 'required|date|after_or_equal:borrow_date',
            'return_date' => 'nullable|date',
            'status' => 'required|in:borrowed,returned',
        ]);
        
        // Check if status changed from borrowed to returned
        $oldStatus = $transaction->status;
        $newStatus = $validated['status'];
        
        // If status changed to returned and book was borrowed, return stock
        if ($oldStatus === 'borrowed' && $newStatus === 'returned') {
            $transaction->book->increment('available');
        }
        
        // If status changed from returned back to borrowed, reduce stock
        if ($oldStatus === 'returned' && $newStatus === 'borrowed') {
            $transaction->book->decrement('available');
        }
        
        $transaction->update($validated);
        
        return redirect()->route('admin.transactions.history')
            ->with('success', 'Transaction updated successfully.');
    }
    
    public function destroy(Transaction $transaction)
    {
        // If transaction is borrowed, return the book to stock
        if ($transaction->status === 'borrowed') {
            $transaction->book->increment('available');
        }
        
        // Delete associated fine if exists
        if ($transaction->fine) {
            $transaction->fine->delete();
        }
        
        $transaction->delete();
        
        return redirect()->route('admin.transactions.history')
            ->with('success', 'Transaction deleted successfully.');
    }
}
