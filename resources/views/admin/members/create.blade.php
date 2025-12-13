@extends('layouts.admin')

@section('title', 'Add New Member')
@section('page-title', 'Add New Member')

@section('content')
<div class="admin-form-container">
    <form action="{{ route('admin.members.store') }}" method="POST">
        @csrf
        
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label class="admin-form-label required">Member Code</label>
                <input type="text" name="member_code" class="admin-form-input @error('member_code') is-invalid @enderror" value="{{ old('member_code') }}" required>
                @error('member_code')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
                <span class="admin-form-help">Unique identifier for the member</span>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Full Name</label>
                <input type="text" name="name" class="admin-form-input @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                @error('name')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Email</label>
                <input type="email" name="email" class="admin-form-input @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                @error('email')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
                <span class="admin-form-help">Will be used for login</span>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Password</label>
                <input type="password" name="password" class="admin-form-input @error('password') is-invalid @enderror" required>
                @error('password')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
                <span class="admin-form-help">Minimum 8 characters</span>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Member Type</label>
                <select name="type" class="admin-form-input @error('type') is-invalid @enderror" required>
                    <option value="">Select Type</option>
                    <option value="student" {{ old('type') == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('type') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="staff" {{ old('type') == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                @error('type')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">Class</label>
                <input type="text" name="class" class="admin-form-input @error('class') is-invalid @enderror" value="{{ old('class') }}">
                @error('class')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
                <span class="admin-form-help">For students only</span>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">Phone</label>
                <input type="text" name="phone" class="admin-form-input @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                @error('phone')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Status</label>
                <select name="status" class="admin-form-input @error('status') is-invalid @enderror" required>
                    <option value="active" {{ old('status', 'active') == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="admin-form-group" style="margin-top: 1.5rem;">
            <label class="admin-form-label">Address</label>
            <textarea name="address" class="admin-form-input @error('address') is-invalid @enderror" rows="3">{{ old('address') }}</textarea>
            @error('address')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="admin-btn admin-btn-primary">Save Member</button>
            <a href="{{ route('admin.members.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
