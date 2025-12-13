@extends('layouts.admin')

@section('title', 'Books Management')
@section('page-title', 'Books Management')

@section('content')
<div class="admin-table-container">
    <div class="admin-table-header">
        <h3 class="admin-table-title">All Books</h3>
        <div class="admin-table-actions">
            <form action="{{ route('admin.books.index') }}" method="GET" style="display: flex; gap: 0.5rem;">
                <input type="text" name="search" placeholder="Search books..." value="{{ request('search') }}" class="admin-form-input" style="min-width: 250px;">
                <select name="category" class="admin-form-input">
                    <option value="">All Categories</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="admin-btn admin-btn-secondary admin-btn-sm">Filter</button>
            </form>
            <a href="{{ route('admin.books.create') }}" class="admin-btn admin-btn-primary admin-btn-sm">
                + Add Book
            </a>
        </div>
    </div>
    
    <table class="admin-table">
        <thead>
            <tr>
                <th>Cover</th>
                <th>Title</th>
                <th>Author</th>
                <th>ISBN</th>
                <th>Category</th>
                <th>Stock</th>
                <th>Available</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($books as $book)
            <tr>
                <td>
                    @if($book->cover_image)
                        <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" style="width: 40px; height: 60px; object-fit: cover; border-radius: 0.25rem;">
                    @else
                        <div style="width: 40px; height: 60px; background: linear-gradient(135deg, #526D82, #27374D); border-radius: 0.25rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">📚</div>
                    @endif
                </td>
                <td><strong>{{ $book->title }}</strong></td>
                <td>{{ $book->author }}</td>
                <td><code>{{ $book->isbn }}</code></td>
                <td>{{ $book->category->name }}</td>
                <td>{{ $book->stock }}</td>
                <td>
                    @if($book->isAvailable())
                        <span class="admin-badge admin-badge-success">{{ $book->available }}</span>
                    @else
                        <span class="admin-badge admin-badge-danger">0</span>
                    @endif
                </td>
                <td>
                    <div style="display: flex; gap: 0.5rem;">
                        <a href="{{ route('admin.books.show', $book) }}" class="admin-btn admin-btn-secondary admin-btn-sm">View</a>
                        <a href="{{ route('admin.books.edit', $book) }}" class="admin-btn admin-btn-secondary admin-btn-sm">Edit</a>
                        <form action="{{ route('admin.books.destroy', $book) }}" method="POST" style="display: inline;" onsubmit="return confirm('Are you sure you want to delete this book?');">
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
                    No books found. <a href="{{ route('admin.books.create') }}">Add your first book</a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    
    @if($books->hasPages())
    <div class="admin-pagination">
        {{ $books->links() }}
    </div>
    @endif
</div>
@endsection
