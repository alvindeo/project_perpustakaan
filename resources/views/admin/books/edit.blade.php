@extends('layouts.admin')

@section('title', 'Edit Book')
@section('page-title', 'Edit Book')

@section('content')
<div class="admin-form-container">
    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="admin-form-grid">
            <div class="admin-form-group">
                <label class="admin-form-label required">ISBN</label>
                <input type="text" name="isbn" class="admin-form-input @error('isbn') is-invalid @enderror" value="{{ old('isbn', $book->isbn) }}" required>
                @error('isbn')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Title</label>
                <input type="text" name="title" class="admin-form-input @error('title') is-invalid @enderror" value="{{ old('title', $book->title) }}" required>
                @error('title')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Author</label>
                <input type="text" name="author" class="admin-form-input @error('author') is-invalid @enderror" value="{{ old('author', $book->author) }}" required>
                @error('author')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Category</label>
                <select name="category_id" class="admin-form-input @error('category_id') is-invalid @enderror" required>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id', $book->category_id) == $category->id ? 'selected' : '' }}>
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
                <input type="text" name="publisher" class="admin-form-input @error('publisher') is-invalid @enderror" value="{{ old('publisher', $book->publisher) }}" required>
                @error('publisher')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Publication Year</label>
                <input type="number" name="publication_year" class="admin-form-input @error('publication_year') is-invalid @enderror" value="{{ old('publication_year', $book->publication_year) }}" min="1900" max="{{ date('Y') }}" required>
                @error('publication_year')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label required">Stock</label>
                <input type="number" name="stock" class="admin-form-input @error('stock') is-invalid @enderror" value="{{ old('stock', $book->stock) }}" min="1" required>
                @error('stock')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
            
            <div class="admin-form-group">
                <label class="admin-form-label">Cover Image</label>
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" style="width: 100px; margin-bottom: 0.5rem; border-radius: 0.5rem;">
                @endif
                <input type="file" name="cover_image" class="admin-form-input @error('cover_image') is-invalid @enderror" accept="image/*">
                @error('cover_image')
                    <span class="admin-form-error">{{ $message }}</span>
                @enderror
            </div>
        </div>
        
        <div class="admin-form-group" style="margin-top: 1.5rem;">
            <label class="admin-form-label">Synopsis</label>
            <textarea name="synopsis" class="admin-form-input @error('synopsis') is-invalid @enderror" rows="4">{{ old('synopsis', $book->synopsis) }}</textarea>
            @error('synopsis')
                <span class="admin-form-error">{{ $message }}</span>
            @enderror
        </div>
        
        <div style="display: flex; gap: 1rem; margin-top: 2rem;">
            <button type="submit" class="admin-btn admin-btn-primary">Update Book</button>
            <a href="{{ route('admin.books.index') }}" class="admin-btn admin-btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
