@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
<div class="section" style="background: white; max-width: 1200px; margin: 2rem auto; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
    <div class="container">
        <h2 class="section-title">Dashboard Admin</h2>
        
        <div class="dashboard-grid">
            <div class="stat-card">
                <h3>{{ $stats['total_books'] }}</h3>
                <p>Total Buku</p>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #10b981, #059669);">
                <h3>{{ $stats['total_members'] }}</h3>
                <p>Anggota Aktif</p>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b, #ea580c);">
                <h3>{{ $stats['active_borrowings'] }}</h3>
                <p>Sedang Dipinjam</p>
            </div>
            
            <div class="stat-card" style="background: linear-gradient(135deg, #ef4444, #dc2626);">
                <h3>{{ $stats['overdue_books'] }}</h3>
                <p>Terlambat</p>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
            <div style="background: #f8fafc; padding: 2rem; border-radius: 1rem; border: 1px solid var(--border);">
                <h3>Transaksi Terbaru</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Anggota</th>
                            <th>Buku</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($recentTransactions as $transaction)
                            <tr>
                                <td>{{ $transaction->member->name }}</td>
                                <td>{{ $transaction->book->title }}</td>
                                <td><span class="badge badge-{{ $transaction->status == 'borrowed' ? 'event' : 'news' }}">{{ ucfirst($transaction->status) }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div style="background: #f8fafc; padding: 2rem; border-radius: 1rem; border: 1px solid var(--border);">
                <h3>Buku Populer</h3>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Judul</th>
                            <th>Peminjaman</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($popularBooks as $book)
                            <tr>
                                <td>{{ $book->title }}</td>
                                <td><strong>{{ $book->transactions_count }}</strong></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="mt-3" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1rem;">
            <a href="{{ route('admin.books.index') }}" class="btn btn-primary">Kelola Buku</a>
            <a href="{{ route('admin.members.index') }}" class="btn btn-primary">Kelola Anggota</a>
            <a href="{{ route('admin.circulation.borrow') }}" class="btn btn-success">Peminjaman</a>
            <a href="{{ route('admin.circulation.return') }}" class="btn btn-warning">Pengembalian</a>
            <a href="{{ route('admin.reports.index') }}" class="btn btn-outline">Laporan</a>
        </div>
    </div>
</div>
@endsection
