@extends('layouts.admin')

@section('title', 'Edit Transaction')
@section('page-title', 'Edit Transaction')

@section('content')
<div class="admin-form-container">
    <form action="{{ route('admin.transactions.update', $transaction) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label class="admin-form-label">Transaction ID</label>
                <input type="text" value="#{{ $transaction->id }}" class="admin-form-input" disabled>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">Member</label>
                <input type="text" value="{{ $transaction->member->name }} ({{ $transaction->member->member_code }})" class="admin-form-input" disabled>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">Book</label>
                <input type="text" value="{{ $transaction->book->title }}" class="admin-form-input" disabled>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Borrow Date</label>
                <input type="date" name="borrow_date" class="admin-form-input @error('borrow_date') is-invalid @enderror" value="{{ old('borrow_date', $transaction->borrow_date->format('Y-m-d')) }}" required>
                @error('borrow_date')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Due Date</label>
                <input type="date" name="due_date" class="admin-form-input @error('due_date') is-invalid @enderror" value="{{ old('due_date', $transaction->due_date->format('Y-m-d')) }}" required>
                @error('due_date')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">Return Date</label>
                <input type="date" name="return_date" class="admin-form-input @error('return_date') is-invalid @enderror" value="{{ old('return_date', $transaction->return_date ? $transaction->return_date->format('Y-m-d') : '') }}">
                @error('return_date')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
                <span class="admin-form-help">Leave blank if not yet returned</span>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Status</label>
                <select name="status" class="admin-form-input @error('status') is-invalid @enderror" required>
                    <option value="borrowed" {{ old('status', $transaction->status) == 'borrowed' ? 'selected' : '' }}>Borrowed</option>
                    <option value="returned" {{ old('status', $transaction->status) == 'returned' ? 'selected' : '' }}>Returned</option>
                </select>
                @error('status')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        @if($transaction->fine)
        <div style="background: #fee2e2; padding: 1rem; border-radius: 0.5rem; margin-top: 1.5rem; border-left: 4px solid #dc2626;">
            <strong>Fine Information:</strong><br>
            Amount: Rp {{ number_format($transaction->fine->amount) }}<br>
            Days Overdue: {{ $transaction->fine->days_overdue }} days<br>
            Status: {{ ucfirst($transaction->fine->status) }}
        </div>
        @endif
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="admin-btn admin-btn-primary">Update Transaction</button>
            <a href="{{ route('admin.transactions.history') }}" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
