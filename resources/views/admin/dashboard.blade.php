@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('content')
<!-- Stats Grid -->
<div class="admin-stats-grid">
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div>
                <div class="admin-stat-value">{{ $stats['total_books'] }}</div>
                <div class="admin-stat-label">Total Books</div>
            </div>
            <div class="admin-stat-icon primary">
                📚
            </div>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div>
                <div class="admin-stat-value">{{ $stats['active_members'] }}</div>
                <div class="admin-stat-label">Active Members</div>
            </div>
            <div class="admin-stat-icon success">
                👥
            </div>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div>
                <div class="admin-stat-value">{{ $stats['active_borrowings'] }}</div>
                <div class="admin-stat-label">Active Borrowings</div>
            </div>
            <div class="admin-stat-icon warning">
                📖
            </div>
        </div>
    </div>
    
    <div class="admin-stat-card">
        <div class="admin-stat-header">
            <div>
                <div class="admin-stat-value">{{ $stats['overdue_books'] }}</div>
                <div class="admin-stat-label">Overdue Books</div>
            </div>
            <div class="admin-stat-icon danger">
                ⚠️
            </div>
        </div>
    </div>
</div>

<!-- Recent Transactions -->
<div class="admin-table-container">
    <div class="admin-table-header">
        <h3 class="admin-table-title">Recent Transactions</h3>
        <a href="{{ route('admin.transactions.history') }}" class="admin-btn admin-btn-secondary admin-btn-sm">
            View All
        </a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($recent_transactions as $transaction)
            <tr>
                <td>{{ $transaction->member->name }}</td>
                <td>{{ $transaction->book->title }}</td>
                <td>{{ $transaction->borrow_date->format('d M Y') }}</td>
                <td>{{ $transaction->due_date->format('d M Y') }}</td>
                <td>
                    @if($transaction->status === 'borrowed')
                        @if($transaction->isOverdue())
                            <span class="admin-badge admin-badge-danger">Overdue</span>
                        @else
                            <span class="admin-badge admin-badge-warning">Borrowed</span>
                        @endif
                    @else
                        <span class="admin-badge admin-badge-success">Returned</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--text-secondary);">No recent transactions</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Popular Books -->
<div class="admin-table-container" style="margin-top: 2rem;">
    <div class="admin-table-header">
        <h3 class="admin-table-title">Popular Books</h3>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Times Borrowed</th>
                <th>Available</th>
            </tr>
        </thead>
        <tbody>
            @forelse($popular_books as $book)
            <tr>
                <td><strong>{{ $book->title }}</strong></td>
                <td>{{ $book->author }}</td>
                <td>{{ $book->category->name }}</td>
                <td>{{ $book->transactions_count }}</td>
                <td>
                    @if($book->isAvailable())
                        <span class="admin-badge admin-badge-success">{{ $book->available }}/{{ $book->stock }}</span>
                    @else
                        <span class="admin-badge admin-badge-danger">Out of Stock</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center; color: var(--text-secondary);">No data available</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
