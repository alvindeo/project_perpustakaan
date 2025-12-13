@extends('layouts.admin')

@section('title', 'Borrowings Management')
@section('page-title', 'Active Borrowings')

@section('content')
<div class="admin-table-container">
    <div class="admin-table-header">
        <h3 class="admin-table-title">All Active Borrowings</h3>
        <div class="admin-table-actions">
            <form action="{{ route('admin.borrowings.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
                <input type="text" name="search" placeholder="Search member or book..." value="{{ request('search') }}" class="admin-form-input" style="min-width: 250px;">
                <select name="status" class="admin-form-input">
                    <option value="">All Status</option>
                    <option value="borrowed" {{ request('status') == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                    <option value="overdue" {{ request('status') == 'overdue' ? 'selected' : '' }}>Overdue</option>
                </select>
                <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm">Filter</button>
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
                <th>Days</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($borrowings as $index => $borrowing)
            <tr>
                <td><code>#{{ $borrowings->firstItem() + $index }}</code></td>
                <td>
                    <strong>{{ $borrowing->member->name }}</strong><br>
                    <small style="color: var(--text-secondary);">{{ $borrowing->member->member_code }}</small>
                </td>
                <td>
                    <strong>{{ $borrowing->book->title }}</strong><br>
                    <small style="color: var(--text-secondary);">{{ $borrowing->book->author }}</small>
                </td>
                <td>{{ $borrowing->borrow_date->format('d M Y') }}</td>
                <td>{{ $borrowing->due_date->format('d M Y') }}</td>
                <td>
                    @if($borrowing->isOverdue())
                        <span class="admin-badge admin-badge-danger">{{ $borrowing->daysOverdue() }} days late</span>
                    @else
                        @php
                            $diff = now()->diff($borrowing->due_date);
                            $days = $diff->days;
                            $hours = $diff->h;
                            $minutes = $diff->i;
                            $seconds = $diff->s;
                        @endphp
                        <span style="font-family: monospace;">{{ $days }}d {{ $hours }}h {{ $minutes }}m {{ $seconds }}s</span>
                    @endif
                </td>
                <td>
                    @if($borrowing->isOverdue())
                        <span class="admin-badge admin-badge-danger">Overdue</span>
                    @else
                        <span class="admin-badge admin-badge-warning">Borrowed</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <form action="{{ route('admin.circulation.return', $borrowing) }}" method="POST" style="display: inline;">
                            @csrf
                            <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm" onclick="return confirm('Mark this book as returned?');">Return</button>
                        </form>
                        <form action="{{ route('admin.borrowings.destroy', $borrowing) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Cancel this borrowing?');">Cancel</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                    No active borrowings found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($borrowings->hasPages())
    <div class="admin-pagination">
        {{ $borrowings->links() }}
    </div>
    @endif
</div>
@endsection
