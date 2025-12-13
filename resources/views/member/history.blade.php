@extends('layouts.app')

@section('title', 'Borrowing History')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="max-width: 1200px; margin: 0 auto; background: white; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
        <h2 style="margin-bottom: 2rem;">Riwayat Peminjaman</h2>
        
        @if($transactions->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Jatuh Tempo</th>
                        <th>Status</th>
                        <th>Denda</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($transactions as $transaction)
                    <tr>
                        <td><strong>{{ $transaction->book->title }}</strong></td>
                        <td>{{ $transaction->borrow_date->format('d/m/Y') }}</td>
                        <td>{{ $transaction->return_date ? $transaction->return_date->format('d/m/Y') : '-' }}</td>
                        <td>{{ $transaction->due_date->format('d/m/Y') }}</td>
                        <td>
                            @if($transaction->status === 'returned')
                                <span class="badge-news">Dikembalikan</span>
                            @else
                                @if($transaction->isOverdue())
                                    <span class="badge badge-danger">Terlambat</span>
                                @else
                                    <span class="badge-event">Dipinjam</span>
                                @endif
                            @endif
                        </td>
                        <td>
                            @if($transaction->fine)
                                <span class="badge badge-danger">Rp {{ number_format($transaction->fine->amount) }}</span>
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div style="margin-top: 2rem;">
                {{ $transactions->links() }}
            </div>
        @else
            <p style="text-align: center; color: var(--gray); padding: 3rem;">Belum ada riwayat peminjaman</p>
        @endif
    </div>
</div>
@endsection
