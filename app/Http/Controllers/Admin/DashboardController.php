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
            'total_members' => Member::where('status', 'active')->count(),
            'active_borrowings' => Transaction::where('status', 'borrowed')->count(),
            'overdue_books' => Transaction::where('status', 'overdue')->count(),
            'total_fines' => Fine::where('status', 'unpaid')->sum('amount'),
        ];

        $recentTransactions = Transaction::with(['member', 'book'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        $popularBooks = Book::withCount(['transactions' => function($query) {
            $query->where('created_at', '>=', now()->subDays(30));
        }])
        ->orderBy('transactions_count', 'desc')
        ->take(5)
        ->get();

        return view('admin.dashboard', compact('stats', 'recentTransactions', 'popularBooks'));
    }
}
