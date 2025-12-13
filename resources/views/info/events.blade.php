@extends('layouts.app')

@section('title', 'Event & Berita Perpustakaan')

@section('content')
<div class="section" style="background: white; max-width: 1200px; margin: 2rem auto; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
    <div class="container">
        <h2 class="section-title">Event & Berita Perpustakaan</h2>
        
        <div class="card-grid">
            @forelse($events as $event)
                <div class="card">
                    <div class="card-header">
                        <span class="badge badge-{{ $event->type }}">{{ ucfirst($event->type) }}</span>
                        <span class="text-small" style="color: white; float: right;">{{ $event->event_date->format('d M Y') }}</span>
                    </div>
                    
                    @if($event->image)
                        <img src="{{ asset('storage/' . $event->image) }}" alt="{{ $event->title }}" style="width: 100%; height: 200px; object-fit: cover;">
                    @endif
                    
                    <div class="card-body">
                        <h3>{{ $event->title }}</h3>
                        <p>{{ $event->description }}</p>
                        
                        <div style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid var(--border);">
                            <p class="text-muted text-small">
                                <strong>Tanggal:</strong> {{ $event->event_date->format('d F Y') }}
                            </p>
                            <p class="text-muted text-small">
                                <strong>Dipublikasikan:</strong> {{ $event->created_at->diffForHumans() }}
                            </p>
                        </div>
                    </div>
                </div>
            @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 3rem;">
                    <p class="text-muted">Belum ada event atau berita</p>
                </div>
            @endforelse
        </div>

        <div class="mt-3">
            {{ $events->links() }}
        </div>
    </div>
</div>
@endsection
