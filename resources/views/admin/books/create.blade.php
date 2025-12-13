@extends('layouts.admin')

@section('title', 'Add New Book')
@section('page-title', 'Add New Book')

@section('content')
<div class="admin-form-container">
    <form action="{{ route('admin.books.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label class="admin-form-label required">ISBN</label>
                <input type="text" name="isbn" class="admin-form-input @error('isbn') is-invalid @enderror" value="{{ old('isbn') }}" required>
                @error('isbn')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Title</label>
                <input type="text" name="title" class="admin-form-input @error('title') is-invalid @enderror" value="{{ old('title') }}" required>
                @error('title')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Author</label>
                <input type="text" name="author" class="admin-form-input @error('author') is-invalid @enderror" value="{{ old('author') }}" required>
                @error('author')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Category</label>
                <select name="category_id" class="admin-form-input @error('category_id') is-invalid @enderror" required>
                    <option value="">Select Category</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Publisher</label>
                <input type="text" name="publisher" class="admin-form-input @error('publisher') is-invalid @enderror" value="{{ old('publisher') }}" required>
                @error('publisher')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Publication Year</label>
                <input type="number" name="publication_year" class="admin-form-input @error('publication_year') is-invalid @enderror" value="{{ old('publication_year') }}" min="1900" max="{{ date('Y') }}" required>
                @error('publication_year')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Stock</label>
                <input type="number" name="stock" class="admin-form-input @error('stock') is-invalid @enderror" value="{{ old('stock', 1) }}" min="1" required>
                @error('stock')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
                <span class="admin-form-help">Number of copies available</span>
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">Cover Image</label>
                <input type="file" name="cover_image" class="admin-form-input @error('cover_image') is-invalid @enderror" accept="image/*">
                @error('cover_image')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
                <span class="admin-form-help">Max 2MB, JPG/PNG</span>
            </div>
        </div>
        
        <div class="admin-form-group" style="margin-top: 1.5rem;">
            <label class="admin-form-label">Synopsis</label>
            <textarea name="synopsis" class="admin-form-input @error('synopsis') is-invalid @enderror" rows="4">{{ old('synopsis') }}</textarea>
            @error('synopsis')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="admin-btn admin-btn-primary">Save Book</button>
            <a href="{{ route('admin.books.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
