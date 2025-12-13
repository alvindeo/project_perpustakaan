@extends('layouts.admin')

@section('title', 'Transaction History')
@section('page-title', 'Transaction History')

@section('content')
<div class="admin-table-container">
    <div class="admin-table-header">
        <h3 class="admin-table-title">All Transactions</h3>
        <div class="admin-table-actions">
            <form action="{{ route('admin.transactions.history') }}" method="GET" style="display: flex; gap: 0.5rem; flex-wrap: wrap;">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="admin-form-input" placeholder="Start Date">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="admin-form-input" placeholder="End Date">
                <select name="status" class="admin-form-input">
                    <option value="">All Status</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                    <option value="returned" {{ request('status') == 'returned' ? 'selected' : '' }}>Returned</option>
                </select>
                <input type="text" name="search" placeholder="Search..." value="{{ request('search') }}" class="admin-form-input">
                <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm">Filter</button>
                <a href="{{ route('admin.transactions.history') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Reset</a>
            </form>
        </div>
    </div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Member</th>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Return Date</th>
                <th>Status</th>
                <th>Fine</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($transactions as $index => $transaction)
            <tr>
                <td><code>#{{ $transactions->firstItem() + $index }}</code></td>
                <td>
                    <strong>{{ $transaction->member->name }}</strong><br>
                    <small style="color: var(--text-secondary);">{{ $transaction->member->member_code }}</small>
                </td>
                <td>
                    <strong>{{ $transaction->book->title }}</strong><br>
                    <small style="color: var(--text-secondary);">{{ $transaction->book->author }}</small>
                </td>
                <td>{{ $transaction->borrow_date->format('d M Y') }}</td>
                <td>{{ $transaction->due_date->format('d M Y') }}</td>
                <td>
                    @if($transaction->return_date)
                        {{ $transaction->return_date->format('d M Y') }}
                    @else
                        <span style="color: var(--text-secondary);">-</span>
                    @endif
                </td>
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
                <td>
                    @if($transaction->fine)
                        <span class="admin-badge admin-badge-danger">Rp {{ number_format($transaction->fine->amount) }}</span>
                    @else
                        <span style="color: var(--text-secondary);">-</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.transactions.edit', $transaction) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                        <form action="{{ route('admin.transactions.destroy', $transaction) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this transaction?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="9" style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                    No transactions found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($transactions->hasPages())
    <div class="admin-pagination">
        {{ $transactions->appends(request()->query())->links() }}
    </div>
    @endif
</div>
@endsection
