<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Member;
use App\Models\Transaction;
use App\Models\Fine;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_books' => Book::count(),
            'active_members' => Member::where('status', 'active')->count(),
            'active_borrowings' => Transaction::where('status', 'borrowed')->count(),
            'overdue_books' => Transaction::where('status', 'borrowed')
                ->where('due_date', '<', now())
                ->count(),
        ];

        $recent_transactions = Transaction::with(['member', 'book'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $popular_books = Book::withCount('transactions')
            ->with('category')
            ->orderBy('transactions_count', 'desc')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recent_transactions', 'popular_books'));
    }
}
