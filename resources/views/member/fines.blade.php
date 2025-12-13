@extends('layouts.app')

@section('title', 'My Fines')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="max-width: 1200px; margin: 0 auto; background: white; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
        <h2 style="margin-bottom: 2rem;">Denda Saya</h2>
        
        @if($totalUnpaid > 0)
            <div style="background: #fee2e2; padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem; border-left: 4px solid var(--error);">
                <strong>Total Denda Belum Dibayar:</strong> Rp {{ number_format($totalUnpaid) }}
            </div>
        @else
            <div style="background: #d1fae5; padding: 1.5rem; border-radius: 0.75rem; margin-bottom: 2rem; border-left: 4px solid var(--success);">
                <strong>✓ Tidak ada denda yang belum dibayar</strong>
            </div>
        @endif
        
        @if($fines->count() > 0)
            <table class="table">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Tanggal Pinjam</th>
                        <th>Tanggal Kembali</th>
                        <th>Hari Terlambat</th>
                        <th>Jumlah Denda</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($fines as $fine)
                    <tr>
                        <td><strong>{{ $fine->transaction->book->title }}</strong></td>
                        <td>{{ $fine->transaction->borrow_date->format('d/m/Y') }}</td>
                        <td>{{ $fine->transaction->return_date->format('d/m/Y') }}</td>
                        <td>{{ $fine->days_overdue }} hari</td>
                        <td><strong>Rp {{ number_format($fine->amount) }}</strong></td>
                        <td>
                            @if($fine->status === 'paid')
                                <span class="badge-news">Lunas</span>
                            @else
                                <span class="badge badge-danger">Belum Dibayar</span>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <div style="margin-top: 2rem;">
                {{ $fines->links() }}
            </div>
        @else
            <p style="text-align: center; color: var(--gray); padding: 3rem;">Tidak ada denda</p>
        @endif
    </div>
</div>
@endsection
