<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Perpustakaan SMA Dian Nuswantoro')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    @stack('styles')
</head>
<body>
    <nav class="navbar">
        <div class="container">
            <div class="nav-brand" style="display: flex; align-items: center; gap: 0.75rem;">
                <img src="{{ asset('images/udinus-logo-original.png') }}" alt="UDINUS Logo" style="height: 40px; width: auto;">
                <div>
                    <h1 style="font-weight: 800; letter-spacing: 1.5px; margin: 0; font-size: 1.25rem;">UDINUS</h1>
                    <p style="font-size: 0.65rem; margin: 0; color: var(--secondary); font-weight: 500;">Perpustakaan Digital</p>
                </div>
            </div>
            <div class="nav-menu">
                <a href="{{ route('home') }}" class="nav-link">Beranda</a>
                <a href="{{ route('opac.index') }}" class="nav-link">Katalog</a>
                <a href="{{ route('info') }}" class="nav-link">Informasi</a>
                <a href="{{ route('events') }}" class="nav-link">Event</a>
                
                @auth
                    @if(auth()->user()->isAdmin())
                        <a href="{{ route('admin.dashboard') }}" class="nav-link">Dashboard Admin</a>
                    @else
                        <a href="{{ route('member.dashboard') }}" class="nav-link">Dashboard Saya</a>
                    @endif
                    <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                        @csrf
                        <button type="submit" class="btn btn-outline">Logout</button>
                    </form>
                @else
                    <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
                @endauth
            </div>
        </div>
    </nav>

    <main class="main-content">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        
        @if(session('error'))
            <div class="alert alert-error">{{ session('error') }}</div>
        @endif
        
        @if(session('warning'))
            <div class="alert alert-warning">{{ session('warning') }}</div>
        @endif

        @yield('content')
    </main>

    <footer class="footer">
        <div class="container">
            <p>&copy; 2024 Perpustakaan SMA Dian Nuswantoro. All rights reserved.</p>
        </div>
    </footer>

    <script src="{{ asset('js/main.js') }}"></script>
    @stack('scripts')
</body>
</html>
