@extends('layouts.admin')

@section('title', 'Edit Member')
@section('page-title', 'Edit Member')

@section('content')
<div class="admin-form-container">
    <form action="{{ route('admin.members.update', $member) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label class="admin-form-label required">Member Code</label>
                <input type="text" name="member_code" class="admin-form-input @error('member_code') is-invalid @enderror" value="{{ old('member_code', $member->member_code) }}" required>
                @error('member_code')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Full Name</label>
                <input type="text" name="name" class="admin-form-input @error('name') is-invalid @enderror" value="{{ old('name', $member->name) }}" required>
                @error('name')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Email</label>
                <input type="email" name="email" class="admin-form-input @error('email') is-invalid @enderror" value="{{ old('email', $member->email) }}" required>
                @error('email')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">New Password</label>
                <input type="password" name="password" class="admin-form-input @error('password') is-invalid @enderror">
                @error('password')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
                <span class="admin-form-help">Leave blank to keep current password</span>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Member Type</label>
                <select name="type" class="admin-form-input @error('type') is-invalid @enderror" required>
                    <option value="student" {{ old('type', $member->type) == 'student' ? 'selected' : '' }}>Student</option>
                    <option value="teacher" {{ old('type', $member->type) == 'teacher' ? 'selected' : '' }}>Teacher</option>
                    <option value="staff" {{ old('type', $member->type) == 'staff' ? 'selected' : '' }}>Staff</option>
                </select>
                @error('type')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">Class</label>
                <input type="text" name="class" class="admin-form-input @error('class') is-invalid @enderror" value="{{ old('class', $member->class) }}">
                @error('class')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">Phone</label>
                <input type="text" name="phone" class="admin-form-input @error('phone') is-invalid @enderror" value="{{ old('phone', $member->phone) }}">
                @error('phone')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Status</label>
                <select name="status" class="admin-form-input @error('status') is-invalid @enderror" required>
                    <option value="active" {{ old('status', $member->status) == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="inactive" {{ old('status', $member->status) == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
                @error('status')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="admin-form-group" style="margin-top: 1.5rem;">
            <label class="admin-form-label">Address</label>
            <textarea name="address" class="admin-form-input @error('address') is-invalid @enderror" rows="3">{{ old('address', $member->address) }}</textarea>
            @error('address')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="admin-btn admin-btn-primary">Update Member</button>
            <a href="{{ route('admin.members.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
