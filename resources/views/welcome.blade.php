@extends('layouts.app')

@section('title', 'Perpustakaan SMA Dian Nuswantoro')

@section('content')
<div class="hero">
    <div class="container">
        <div class="hero-content">
            <h1 class="hero-title">Selamat Datang di<br>Perpustakaan SMA Dian Nuswantoro</h1>
            <p class="hero-subtitle">Pusat Literasi & Sumber Belajar Digital</p>
            <div class="hero-search">
                <form action="{{ route('opac.index') }}" method="GET">
                    <input type="text" name="search" placeholder="Cari buku berdasarkan judul, pengarang, atau ISBN..." class="search-input">
                    <button type="submit" class="btn btn-primary">Cari Buku</button>
                </form>
            </div>
        </div>
    </div>
</div>


<div class="section" style="background: white; max-width: 1200px; margin: 2rem auto; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
    <div class="container">
        <h2 class="section-title">Event & Berita Terbaru</h2>
        <div class="card-grid">
            @forelse($recentEvents as $event)
                <div class="card">
                    <div class="card-header">
                        <span class="badge badge-{{ $event->type }}">{{ ucfirst($event->type) }}</span>
                    </div>
                    <div class="card-body">
                        <h3>{{ $event->title }}</h3>
                        <p>{{ Str::limit($event->description, 100) }}</p>
                        <p class="text-muted">{{ $event->event_date->format('d M Y') }}</p>
                    </div>
                </div>
            @empty
                <p class="text-muted" style="text-align: center; grid-column: 1 / -1;">Tidak ada event terbaru</p>
            @endforelse
        </div>
    </div>
</div>


<div class="features-section">
    <div class="container">
        <h2 class="section-title">Fitur Perpustakaan</h2>
        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">🔍</div>
                <h3>OPAC</h3>
                <p>Cari dan telusuri koleksi buku secara online</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📱</div>
                <h3>Booking Buku</h3>
                <p>Pesan buku yang sedang dipinjam</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📊</div>
                <h3>Dashboard</h3>
                <p>Pantau status peminjaman Anda</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon">📚</div>
                <h3>Koleksi Lengkap</h3>
                <p>Ribuan buku dari berbagai kategori</p>
            </div>
        </div>
    </div>
</div>
@endsection
