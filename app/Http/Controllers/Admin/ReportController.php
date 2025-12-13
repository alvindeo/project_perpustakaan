<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Transaction;
use App\Models\Fine;
use App\Models\Member;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function index()
    {
        return view('admin.reports.index');
    }

    public function popularBooks()
    {
        $books = Book::withCount(['transactions' => function($query) {
            $query->where('created_at', '>=', now()->subDays(30));
        }])
        ->orderBy('transactions_count', 'desc')
        ->take(20)
        ->get();

        return view('admin.reports.popular-books', compact('books'));
    }

    public function overdue()
    {
        $overdueTransactions = Transaction::where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->with(['member', 'book'])
            ->orderBy('due_date')
            ->get();

        return view('admin.reports.overdue', compact('overdueTransactions'));
    }

    public function fines()
    {
        $fines = Fine::with(['member', 'transaction.book'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalUnpaid = Fine::where('status', 'unpaid')->sum('amount');
        $totalPaid = Fine::where('status', 'paid')->sum('amount');

        return view('admin.reports.fines', compact('fines', 'totalUnpaid', 'totalPaid'));
    }

    public function export($type)
    {
        switch ($type) {
            case 'popular-books':
                return $this->exportPopularBooks();
            case 'overdue':
                return $this->exportOverdue();
            case 'fines':
                return $this->exportFines();
            default:
                return back()->with('error', 'Invalid report type');
        }
    }

    private function exportPopularBooks()
    {
        $books = Book::withCount(['transactions' => function($query) {
            $query->where('created_at', '>=', now()->subDays(30));
        }])
        ->orderBy('transactions_count', 'desc')
        ->take(20)
        ->get();

        $pdf = Pdf::loadView('admin.reports.pdf.popular-books', compact('books'));
        return $pdf->download('laporan-buku-populer.pdf');
    }

    private function exportOverdue()
    {
        $overdueTransactions = Transaction::where('status', 'borrowed')
            ->where('due_date', '<', now())
            ->with(['member', 'book'])
            ->orderBy('due_date')
            ->get();

        $pdf = Pdf::loadView('admin.reports.pdf.overdue', compact('overdueTransactions'));
        return $pdf->download('laporan-keterlambatan.pdf');
    }

    private function exportFines()
    {
        $fines = Fine::with(['member', 'transaction.book'])->get();
        $totalUnpaid = Fine::where('status', 'unpaid')->sum('amount');
        $totalPaid = Fine::where('status', 'paid')->sum('amount');

        $pdf = Pdf::loadView('admin.reports.pdf.fines', compact('fines', 'totalUnpaid', 'totalPaid'));
        return $pdf->download('laporan-denda.pdf');
    }
}
