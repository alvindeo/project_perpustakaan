@extends('layouts.admin')

@section('title', 'Member Details')
@section('page-title', 'Member Details')

@section('content')
<div class="admin-form-container">
    <div style="display: flex; justify-content: space-between; align-items: start; margin-bottom: 2rem;">
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 700; margin-bottom: 0.5rem;">{{ $member->name }}</h2>
            <p style="color: var(--text-secondary);">Member Code: <code>{{ $member->member_code }}</code></p>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <a href="{{ route('admin.members.edit', $member) }}" class="admin-btn admin-btn-primary admin-btn-sm">Edit</a>
            <a href="{{ route('admin.members.index') }}" class="admin-btn admin-btn-secondary admin-btn-sm">Back to List</a>
        </div>
    </div>
    
    <div class="admin-form-grid">
        <div class="admin-form-group">
            <label class="admin-form-label">Email</label>
            <p>{{ $member->email }}</p>
        </div>
        
        <div class="admin-form-group">
            <label class="admin-form-label">Type</label>
            <p>{{ ucfirst($member->type) }}</p>
        </div>
        
        <div class="admin-form-group">
            <label class="admin-form-label">Class</label>
            <p>{{ $member->class ?? '-' }}</p>
        </div>
        
        <div class="admin-form-group">
            <label class="admin-form-label">Phone</label>
            <p>{{ $member->phone ?? '-' }}</p>
        </div>
        
        <div class="admin-form-group">
            <label class="admin-form-label">Status</label>
            <p>
                @if($member->status === 'active')
                    <span class="admin-badge admin-badge-success">Active</span>
                @else
                    <span class="admin-badge admin-badge-danger">Inactive</span>
                @endif
            </p>
        </div>
        
        <div class="admin-form-group">
            <label class="admin-form-label">Member Since</label>
            <p>{{ $member->created_at->format('d M Y') }}</p>
        </div>
    </div>
    
    @if($member->address)
    <div class="admin-form-group" style="margin-top: 1.5rem;">
        <label class="admin-form-label">Address</label>
        <p>{{ $member->address }}</p>
    </div>
    @endif
</div>

<!-- Active Borrowings -->
<div class="admin-table-container" style="margin-top: 2rem;">
    <div class="admin-table-header">
        <h3 class="admin-table-title">Active Borrowings</h3>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Due Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($member->activeBorrowings as $transaction)
            <tr>
                <td><strong>{{ $transaction->book->title }}</strong></td>
                <td>{{ $transaction->borrow_date->format('d M Y') }}</td>
                <td>{{ $transaction->due_date->format('d M Y') }}</td>
                <td>
                    @if($transaction->isOverdue())
                        <span class="admin-badge admin-badge-danger">Overdue</span>
                    @else
                        <span class="admin-badge admin-badge-warning">Borrowed</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 2rem;">No active borrowings</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<!-- Borrowing History -->
<div class="admin-table-container" style="margin-top: 2rem;">
    <div class="admin-table-header">
        <h3 class="admin-table-title">Borrowing History</h3>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Book</th>
                <th>Borrow Date</th>
                <th>Return Date</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($member->transactions()->orderBy('borrow_date', 'desc')->limit(10)->get() as $transaction)
            <tr>
                <td><strong>{{ $transaction->book->title }}</strong></td>
                <td>{{ $transaction->borrow_date->format('d M Y') }}</td>
                <td>{{ $transaction->return_date ? $transaction->return_date->format('d M Y') : '-' }}</td>
                <td>
                    @if($transaction->status === 'returned')
                        <span class="admin-badge admin-badge-success">Returned</span>
                    @else
                        <span class="admin-badge admin-badge-warning">Borrowed</span>
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="4" style="text-align: center; color: var(--text-secondary); padding: 2rem;">No history</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
