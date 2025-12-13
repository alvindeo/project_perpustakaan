@extends('layouts.admin')

@section('title', 'Reports')
@section('page-title', 'Reports & Analytics')

@section('content')
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div>
                <div class="admin-stat-value">{{ $stats['total_transactions'] }}</div>
                <div class="admin-stat-label">Total Transactions</div>
            </div>
            <div class="admin-stat-icon primary">📊</div>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div>
                <div class="admin-stat-value">{{ $stats['active_borrowings'] }}</div>
                <div class="admin-stat-label">Active Borrowings</div>
            </div>
            <div class="admin-stat-icon warning">📖</div>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div>
                <div class="admin-stat-value">{{ $stats['overdue_count'] }}</div>
                <div class="admin-stat-label">Overdue Books</div>
            </div>
            <div class="admin-stat-icon danger">⚠️</div>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div>
                <div class="admin-stat-value">Rp {{ number_format($stats['total_fines']) }}</div>
                <div class="admin-stat-label">Total Fines</div>
            </div>
            <div class="admin-stat-icon success">💰</div>
        </div>
    </div>
</div>

<!-- Export Options -->
<div class="admin-form-container" style="margin-top: 2rem;">
    <h3 style="margin-bottom: 1.5rem;">Export Reports</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <div style="border: 1px solid var(--border); padding: 1.5rem; border-radius: 0.5rem;">
            <h4 style="margin-bottom: 0.5rem;">Popular Books Report</h4>
            <p style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1rem;">Top 10 most borrowed books</p>
            <a href="{{ route('admin.reports.export', 'popular-books') }}" class="admin-btn admin-btn-primary admin-btn-sm">Download PDF</a>
        </div>
        
        <div style="border: 1px solid var(--border); padding: 1.5rem; border-radius: 0.5rem;">
            <h4 style="margin-bottom: 0.5rem;">Overdue Books Report</h4>
            <p style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1rem;">All overdue borrowings</p>
            <a href="{{ route('admin.reports.export', 'overdue') }}" class="admin-btn admin-btn-primary admin-btn-sm">Download PDF</a>
        </div>
        
        <div style="border: 1px solid var(--border); padding: 1.5rem; border-radius: 0.5rem;">
            <h4 style="margin-bottom: 0.5rem;">Fines Report</h4>
            <p style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1rem;">All fines (paid & unpaid)</p>
            <a href="{{ route('admin.reports.export', 'fines') }}" class="admin-btn admin-btn-primary admin-btn-sm">Download PDF</a>
        </div>
        
        <div style="border: 1px solid var(--border); padding: 1.5rem; border-radius: 0.5rem;">
            <h4 style="margin-bottom: 0.5rem;">Transaction History</h4>
            <p style="color: var(--text-secondary); font-size: 0.875rem; margin-bottom: 1rem;">Complete transaction log</p>
            <a href="{{ route('admin.reports.export', 'transactions') }}" class="admin-btn admin-btn-primary admin-btn-sm">Download PDF</a>
        </div>
    </div>
</div>

<!-- Popular Books Table -->
<div class="admin-table-container" style="margin-top: 2rem;">
    <div class="admin-table-header">
        <h3 class="admin-table-title">Top 10 Popular Books</h3>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Rank</th>
                <th>Book</th>
                <th>Author</th>
                <th>Category</th>
                <th>Times Borrowed</th>
            </tr>
        </thead>
        <tbody>
            @forelse($popular_books as $index => $book)
            <tr>
                <td><strong>#{{ $index + 1 }}</strong></td>
                <td>{{ $book->title }}</td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->category->name }}</td>
                <td><span class="admin-badge admin-badge-primary">{{ $book->transactions_count }}</span></td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--text-secondary); padding: 2rem;">No data available</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
