@extends('layouts.app')

@section('title', 'Katalog Buku - OPAC')

@section('content')
<div class="section" style="background: white; max-width: 1200px; margin: 2rem auto; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
    <div class="container">
        <h2 class="section-title">Katalog Buku (OPAC)</h2>
        
        <div class="search-filters" style="background: #f8fafc; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; border: 1px solid var(--border);">
            <form action="{{ route('opac.index') }}" method="GET">
                <div style="display: grid; grid-template-columns: 2fr 1fr auto; gap: 1rem;">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, pengarang, atau ISBN..." class="form-control">
                    
                    <select name="category" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                    
                    <button type="submit" class="btn btn-primary">Cari</button>
                </div>
            </form>
        </div>

        <div class="card-grid">
            @forelse($books as $book)
                <div class="card">
                    <div class="card-header">
                        <span class="badge badge-event">{{ $book->category->name }}</span>
                    </div>
                    <div class="card-body">
                        @if($book->cover_image)
                            <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" style="width: 100%; height: 200px; object-fit: cover; border-radius: 0.5rem; margin-bottom: 1rem;">
                        @else
                            <div style="width: 100%; height: 200px; background: linear-gradient(135deg, #526D82, #27374D); border-radius: 0.5rem; margin-bottom: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 3rem;">📚</div>
                        @endif
                        
                        <h3>{{ $book->title }}</h3>
                        <p class="text-muted">{{ $book->author }}</p>
                        <p class="text-small">ISBN: {{ $book->isbn }}</p>
                        <p class="text-small">Tersedia: <strong>{{ $book->available }}/{{ $book->stock }}</strong></p>
                        
                        <a href="{{ route('opac.show', $book) }}" class="btn btn-primary btn-sm mt-2" style="width: 100%;">Lihat Detail</a>
                    </div>
                </div>
            @empty
                <p class="text-muted" style="text-align: center; grid-column: 1 / -1;">Tidak ada buku ditemukan</p>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $books->links() }}
        </div>
    </div>
</div>
@endsection
