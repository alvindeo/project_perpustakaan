@extends('layouts.app')

@section('title', $book->title . ' - Detail Buku')

@section('content')
<div class="section" style="background: white; max-width: 1200px; margin: 2rem auto; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
    <div class="container">
        <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
            <div>
                @if($book->cover_image)
                    <img src="{{ asset('storage/' . $book->cover_image) }}" alt="{{ $book->title }}" style="width: 100%; border-radius: 1rem; box-shadow: var(--shadow-lg);">
                @else
                    <div style="width: 100%; aspect-ratio: 3/4; background: linear-gradient(135deg, #526D82, #27374D); border-radius: 1rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 5rem;">📚</div>
                @endif
            </div>
            
            <div>
                <h1>{{ $book->title }}</h1>
                <p class="text-muted" style="font-size: 1.25rem;">{{ $book->author }}</p>
                
                <div style="margin: 2rem 0;">
                    <span class="badge badge-event">{{ $book->category->name }}</span>
                    @if($isAvailable)
                        <span class="badge badge-news">Tersedia</span>
                    @else
                        <span class="badge badge-announcement">Tidak Tersedia</span>
                    @endif
                </div>
                
                <div style="background: #f8fafc; padding: 1.5rem; border-radius: 0.5rem; margin-bottom: 2rem;">
                    <p><strong>ISBN:</strong> {{ $book->isbn }}</p>
                    <p><strong>Penerbit:</strong> {{ $book->publisher ?? '-' }}</p>
                    <p><strong>Tahun Terbit:</strong> {{ $book->publication_year ?? '-' }}</p>
                    <p><strong>Stok:</strong> {{ $book->available }}/{{ $book->stock }}</p>
                </div>
                
                @if($book->synopsis)
                    <div>
                        <h3>Sinopsis</h3>
                        <p>{{ $book->synopsis }}</p>
                    </div>
                @endif
                
                @auth('member')
                    @if(auth('member')->user()->isMember())
                        <div class="mt-3">
                            @if($isAvailable)
                                <div style="display: flex; gap: 1rem;">
                                    <!-- Borrow Button -->
                                    <form action="{{ route('member.borrow') }}" method="POST" style="flex: 1;">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit" class="btn btn-primary" style="width: 100%;">📖 Borrow Now</button>
                                    </form>
                                    
                                    <!-- Booking Button -->
                                    @if(!$hasBooking)
                                        <form action="{{ route('member.bookings.store') }}" method="POST" style="flex: 1;">
                                            @csrf
                                            <input type="hidden" name="book_id" value="{{ $book->id }}">
                                            <button type="submit" class="btn btn-outline" style="width: 100%;">🔖 Book for Later</button>
                                        </form>
                                    @endif
                                </div>
                            @else
                                @if(!$hasBooking)
                                    <form action="{{ route('member.bookings.store') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="book_id" value="{{ $book->id }}">
                                        <button type="submit" class="btn btn-warning">📅 Booking Buku</button>
                                    </form>
                                @elseif($hasBooking)
                                    <p class="alert alert-success">Anda sudah membooking buku ini</p>
                                @endif
                            @endif
                        </div>
                    @endif
                @endauth
            </div>
        </div>
    </div>
</div>
@endsection
