@extends('layouts.admin')

@section('title', 'Bookings Management')
@section('page-title', 'Active Bookings')

@section('content')
<div class="admin-table-container">
    <div class="admin-table-header">
        <h3 class="admin-table-title">All Active Bookings</h3>
        <div class="admin-table-actions">
            <form action="{{ route('admin.bookings.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
                <input type="text" name="search" placeholder="Search member or book..." value="{{ request('search') }}" class="admin-form-input" style="min-width: 250px;">
                <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm">Search</button>
            </form>
        </div>
    </div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>Member</th>
                <th>Book</th>
                <th>Booking Date</th>
                <th>Expiry Date</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($bookings as $booking)
            <tr>
                <td>
                    <strong>{{ $booking->member->name }}</strong><br>
                    <small style="color: var(--text-secondary);">{{ $booking->member->member_code }}</small>
                </td>
                <td>
                    <strong>{{ $booking->book->title }}</strong><br>
                    <small style="color: var(--text-secondary);">{{ $booking->book->author }}</small>
                </td>
                <td>{{ $booking->booking_date->format('d M Y H:i') }}</td>
                <td>{{ $booking->expiry_date->format('d M Y H:i') }}</td>
                <td>
                    @if($booking->isExpired())
                        <span class="admin-badge admin-badge-danger">Expired</span>
                    @else
                        <span class="admin-badge admin-badge-success">Active</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <form action="{{ route('admin.circulation.borrow') }}" method="POST" style="display: inline;">
                            @csrf
                            <input type="hidden" name="member_id" value="{{ $booking->member_id }}">
                            <input type="hidden" name="book_id" value="{{ $booking->book_id }}">
                            <input type="hidden" name="booking_id" value="{{ $booking->id }}">
                            <button type="submit" class="admin-btn admin-btn-primary admin-btn-sm">Process Borrow</button>
                        </form>
                        <form action="{{ route('admin.bookings.destroy', $booking) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm" onclick="return confirm('Cancel this booking?');">Cancel</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                    No active bookings found.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($bookings->hasPages())
    <div class="admin-pagination">
        {{ $bookings->links() }}
    </div>
    @endif
</div>
@endsection
