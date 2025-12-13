@extends('layouts.app')

@section('title', 'My Profile')

@section('content')
<div class="container" style="padding: 2rem 0;">
    <div style="max-width: 800px; margin: 0 auto; background: white; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
        <h2 style="margin-bottom: 2rem;">Profil Saya</h2>
        
        <div style="display: grid; gap: 1.5rem;">
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <label style="font-weight: 600; color: var(--text-secondary); font-size: 0.875rem;">Kode Anggota</label>
                <p style="font-size: 1.125rem; margin-top: 0.5rem;">{{ $member->member_code }}</p>
            </div>
            
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <label style="font-weight: 600; color: var(--text-secondary); font-size: 0.875rem;">Nama Lengkap</label>
                <p style="font-size: 1.125rem; margin-top: 0.5rem;">{{ $member->name }}</p>
            </div>
            
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <label style="font-weight: 600; color: var(--text-secondary); font-size: 0.875rem;">Email</label>
                <p style="font-size: 1.125rem; margin-top: 0.5rem;">{{ $member->email }}</p>
            </div>
            
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <label style="font-weight: 600; color: var(--text-secondary); font-size: 0.875rem;">Tipe Anggota</label>
                <p style="font-size: 1.125rem; margin-top: 0.5rem;">{{ ucfirst($member->type) }}</p>
            </div>
            
            @if($member->class)
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <label style="font-weight: 600; color: var(--text-secondary); font-size: 0.875rem;">Kelas</label>
                <p style="font-size: 1.125rem; margin-top: 0.5rem;">{{ $member->class }}</p>
            </div>
            @endif
            
            @if($member->phone)
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <label style="font-weight: 600; color: var(--text-secondary); font-size: 0.875rem;">Telepon</label>
                <p style="font-size: 1.125rem; margin-top: 0.5rem;">{{ $member->phone }}</p>
            </div>
            @endif
            
            @if($member->address)
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <label style="font-weight: 600; color: var(--text-secondary); font-size: 0.875rem;">Alamat</label>
                <p style="font-size: 1.125rem; margin-top: 0.5rem;">{{ $member->address }}</p>
            </div>
            @endif
            
            <div style="border-bottom: 1px solid var(--border); padding-bottom: 1rem;">
                <label style="font-weight: 600; color: var(--text-secondary); font-size: 0.875rem;">Status</label>
                <p style="margin-top: 0.5rem;">
                    @if($member->status === 'active')
                        <span class="badge-news">Aktif</span>
                    @else
                        <span class="badge badge-danger">Tidak Aktif</span>
                    @endif
                </p>
            </div>
            
            <div>
                <label style="font-weight: 600; color: var(--text-secondary); font-size: 0.875rem;">Anggota Sejak</label>
                <p style="font-size: 1.125rem; margin-top: 0.5rem;">{{ $member->created_at->format('d F Y') }}</p>
            </div>
        </div>
        
        <div style="margin-top: 2rem;">
            <a href="{{ route('member.dashboard') }}" class="btn btn-outline">Kembali ke Dashboard</a>
        </div>
    </div>
</div>
@endsection
