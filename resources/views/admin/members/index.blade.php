@extends('layouts.admin')

@section('title', 'Members Management')
@section('page-title', 'Members Management')

@section('content')
<div class="admin-table-container">
    <div class="admin-table-header">
        <h3 class="admin-table-title">All Members</h3>
        <div class="admin-table-actions">
            <form action="{{ route('admin.members.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
                <input type="text" name="search" placeholder="Search members..." value="{{ request('search') }}" class="admin-form-input" style="min-width: 250px;">
                <select name="status" class="admin-form-input">
                    <option value="">All Status</option>
                    <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm">Filter</button>
            </form>
            <a href="{{ route('admin.members.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">
                + Add Member
            </a>
        </div>
    </div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>Member Code</th>
                <th>Name</th>
                <th>Email</th>
                <th>Type</th>
                <th>Class</th>
                <th>Status</th>
                <th>Active Borrowings</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($members as $member)
            <tr>
                <td><code>{{ $member->member_code }}</code></td>
                <td><strong>{{ $member->name }}</strong></td>
                <td>{{ $member->email }}</td>
                <td>{{ ucfirst($member->type) }}</td>
                <td>{{ $member->class ?? '-' }}</td>
                <td>
                    @if($member->status === 'active')
                        <span class="admin-badge admin-badge-success">Active</span>
                    @else
                        <span class="admin-badge admin-badge-danger">Inactive</span>
                    @endif
                </td>
                <td>
                    <span class="admin-badge admin-badge-info">{{ $member->activeBorrowings()->count() }}</span>
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.members.show', $member) }}" class="admin-btn admin-btn-secondary admin-btn-sm">View</a>
                        <a href="{{ route('admin.members.edit', $member) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                        <form action="{{ route('admin.members.destroy', $member) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this member?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="admin-btn admin-btn-danger admin-btn-sm">Delete</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="8" style="text-align: center; color: var(--text-secondary); padding: 2rem;">
                    No members found. <a href="{{ route('admin.members.create') }}">Add your first member</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($members->hasPages())
    <div class="admin-pagination">
        {{ $members->links() }}
    </div>
    @endif
</div>
@endsection
