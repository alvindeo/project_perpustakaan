@extends('layouts.app')

@section('title', 'My Dashboard')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="max-width: 1200px; margin: 0 auto; background: white; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
        <h2 style="margin-bottom: 2rem;">Dashboard Anggota</h2>
        
        <!-- Stats -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
            <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 1.5rem; border-radius: 0.75rem;">
                <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $activeBorrowings->count() }}</h3>
                <p style="opacity: 0.9;">Buku Dipinjam</p>
            </div>
            
            <div style="background: linear-gradient(135deg, var(--warning), #f59e0b); color: white; padding: 1.5rem; border-radius: 0.75rem;">
                <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">{{ $overdueCount }}</h3>
                <p style="opacity: 0.9;">Terlambat</p>
            </div>
            
            <div style="background: linear-gradient(135deg, var(--error), #dc2626); color: white; padding: 1.5rem; border-radius: 0.75rem;">
                <h3 style="font-size: 2rem; margin-bottom: 0.5rem;">Rp {{ number_format($totalFines) }}</h3>
                <p style="opacity: 0.9;">Total Denda</p>
            </div>
        </div>

        <!-- Member Info -->
        <div style="background: #f8fafc; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; border: 1px solid var(--border);">
            <h3>Informasi Anggota</h3>
            <p><strong>Nama:</strong> {{ $member->name }}</p>
            <p><strong>Kode Anggota:</strong> {{ $member->member_code }}</p>
            <p><strong>Email:</strong> {{ $member->email }}</p>
            <p><strong>Status:</strong> 
                @if($member->status === 'active')
                    <span class="badge-news">Aktif</span>
                @else
                    <span class="badge badge-danger">Tidak Aktif</span>
                @endif
            </p>
        </div>

        <!-- Active Booking -->
        @if($activeBooking)
            <div style="background: #fef3c7; padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem; border-left: 4px solid var(--warning);">
                <strong>Booking Aktif:</strong> {{ $activeBooking->book->title }}
                <br>Ambil sebelum: {{ $activeBooking->expiry_date->format('d/m/Y') }}
                <form action="{{ route('member.bookings.destroy', $activeBooking) }}" method="POST" style="display: inline; margin-left: 1rem;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-error">Batalkan</button>
                </form>
            </div>
        @endif

        <div style="background: #f8fafc; padding: 2rem; border-radius: 1rem; border: 1px solid var(--border);">
            <h3>Peminjaman Aktif</h3>
            
            @if($activeBorrowings->count() > 0)
                <table class="table">
                    <thead>
                        <tr>
                            <th>Buku</th>
                            <th>Tanggal Pinjam</th>
                            <th>Jatuh Tempo</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeBorrowings as $borrowing)
                        <tr>
                            <td><strong>{{ $borrowing->book->title }}</strong></td>
                            <td>
                                {{ $borrowing->borrow_date->format('d/m/Y') }}<br>
                                <small style="color: var(--text-secondary);">{{ $borrowing->borrow_date->format('H:i') }}</small>
                            </td>
                            <td>
                                {{ $borrowing->due_date->format('d/m/Y H:i') }}<br>
                                @if(!$borrowing->isOverdue())
                                    @php
                                        $diff = now()->diff($borrowing->due_date);
                                        $days = $diff->days;
                                        $hours = $diff->h;
                                        $minutes = $diff->i;
                                        $seconds = $diff->s;
                                    @endphp
                                    <small style="color: var(--primary); font-family: monospace;">
                                        {{ $days }}d {{ $hours }}h {{ $minutes }}m {{ $seconds }}s
                                    </small>
                                @endif
                            </td>
                            <td>
                                @if($borrowing->isOverdue())
                                    <span class="badge badge-danger">Terlambat</span>
                                @else
                                    <span class="badge-event">Dipinjam</span>
                                @endif
                            </td>
                            <td>
                                <form action="{{ route('member.return', $borrowing) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-sm btn-success" onclick="return confirm('Yakin ingin mengembalikan buku ini?');">
                                        Return
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p style="text-align: center; color: var(--gray); padding: 2rem;">Tidak ada peminjaman aktif</p>
            @endif
        </div>
    </div>
</div>
@endsection
