@extends('layouts.app')

@section('title', 'Informasi Perpustakaan')

@section('content')
<div class="section" style="background: white; max-width: 1200px; margin: 2rem auto; padding: 3rem 2rem; border-radius: 1rem; box-shadow: var(--shadow-lg);">
    <div class="container">
        <h2 class="section-title">Informasi Perpustakaan</h2>
        
        <div style="background: #f8fafc; padding: 2rem; border-radius: 1rem; margin-bottom: 2rem; border: 1px solid var(--border);">
            <h3>{{ $infos['library_name'] }}</h3>
            
            <div style="margin-top: 2rem;">
                <h4>📍 Alamat</h4>
                <p>{{ $infos['address'] }}</p>
            </div>

            <div style="margin-top: 2rem;">
                <h4>🕐 Jam Buka</h4>
                <p style="white-space: pre-line;">{{ $infos['opening_hours'] }}</p>
            </div>

            <div style="margin-top: 2rem;">
                <h4>📞 Kontak</h4>
                <p><strong>Telepon:</strong> {{ $infos['phone'] }}</p>
                <p><strong>Email:</strong> {{ $infos['email'] }}</p>
            </div>

            <div style="margin-top: 2rem;">
                <h4>📋 Peraturan Perpustakaan</h4>
                <div style="background: white; padding: 1.5rem; border-radius: 0.5rem; border-left: 4px solid var(--primary);">
                    <p style="white-space: pre-line;">{{ $infos['rules'] }}</p>
                </div>
            </div>
        </div>

        <div style="background: linear-gradient(135deg, var(--primary), var(--secondary)); color: white; padding: 2rem; border-radius: 1rem; text-align: center;">
            <h3>Selamat Datang di Perpustakaan!</h3>
            <p>Mari tingkatkan literasi dan wawasan bersama</p>
            <a href="{{ route('opac.index') }}" class="btn btn-outline" style="margin-top: 1rem; background: white; color: var(--primary);">Jelajahi Katalog Buku</a>
        </div>
    </div>
</div>
@endsection
