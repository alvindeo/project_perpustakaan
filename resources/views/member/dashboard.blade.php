@extends('layouts.app')

@section('title', 'Dashboard Anggota')

@section('content')
<div class="section" style="background: white; max-width: 1200px; margin: 2rem auto; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
    <div class="container">
        <h2 class="section-title">Dashboard Anggota</h2>
        
        <div class="dashboard-grid">
            <div class="stat-card">
                <h3>{{ $activeBorrowings->count() }}</h3>
                <p>Buku Dipinjam</p>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #ea580c);">
                <h3>{{ $overdueCount }}</h3>
                <p>Terlambat</p>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <h3>Rp {{ number_format($totalFines, 0, ',', '.') }}</h3>
                <p>Total Denda</p>
            </div>
        </div>

        <div style="background: #f8fafc; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; border: 1px solid var(--border);">
            <h3>Informasi Anggota</h3>
            <p><strong>Nama:</strong> {{ $member->name }}</p>
            <p><strong>Kode Anggota:</strong> {{ $member->member_code }}</p>
            <p><strong>Tipe:</strong> {{ ucfirst($member->member_type) }}</p>
            @if($member->class)
                <p><strong>Kelas:</strong> {{ $member->class }}</p>
            @endif
            <p><strong>Status:</strong> <span class="badge badge-{{ $member->status == 'active' ? 'news' : 'announcement' }}">{{ ucfirst($member->status) }}</span></p>
        </div>

        @if($activeBooking)
            <div class="alert alert-warning">
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
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($activeBorrowings as $transaction)
                            <tr>
                                <td>{{ $transaction->book->title }}</td>
                                <td>{{ $transaction->borrow_date->format('d/m/Y') }}</td>
                                <td>{{ $transaction->due_date->format('d/m/Y') }}</td>
                                <td>
                                    @if($transaction->isOverdue())
                                        <span class="badge badge-announcement">Terlambat {{ $transaction->daysOverdue() }} hari</span>
                                    @else
                                        <span class="badge badge-news">Aktif</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-muted">Tidak ada peminjaman aktif</p>
            @endif
        </div>
    </div>
</div>
@endsection
