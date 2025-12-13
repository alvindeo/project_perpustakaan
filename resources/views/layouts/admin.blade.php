<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - Perpustakaan UDINUS</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.png') }}">
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @stack('styles')
</head>
<body>
    <div class="admin-wrapper">
        <!-- Sidebar -->
        <aside class="admin-sidebar" id="adminSidebar">
            <div class="admin-sidebar-header">
                <img src="{{ asset('images/udinus-logo-original.png') }}" alt="UDINUS" class="admin-sidebar-logo">
                <div class="admin-sidebar-title">
                    <h2>UDINUS</h2>
                    <p>Admin Panel</p>
                </div>
            </div>
            
            <nav class="admin-sidebar-nav">
                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Main</div>
                    <a href="{{ route('admin.dashboard') }}" class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <span class="admin-nav-icon">📊</span>
                        <span>Dashboard</span>
                    </a>
                </div>
                
                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Management</div>
                    <a href="{{ route('admin.books.index') }}" class="admin-nav-link {{ request()->routeIs('admin.books.*') ? 'active' : '' }}">
                        <span class="admin-nav-icon">📚</span>
                        <span>Books</span>
                    </a>
                    <a href="{{ route('admin.members.index') }}" class="admin-nav-link {{ request()->routeIs('admin.members.*') ? 'active' : '' }}">
                        <span class="admin-nav-icon">👥</span>
                        <span>Members</span>
                    </a>
                </div>
                
                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Circulation</div>
                    <a href="{{ route('admin.borrowings.index') }}" class="admin-nav-link {{ request()->routeIs('admin.borrowings.*') ? 'active' : '' }}">
                        <span class="admin-nav-icon">📖</span>
                        <span>Borrowings</span>
                    </a>
                    <a href="{{ route('admin.bookings.index') }}" class="admin-nav-link {{ request()->routeIs('admin.bookings.*') ? 'active' : '' }}">
                        <span class="admin-nav-icon">🔖</span>
                        <span>Bookings</span>
                    </a>
                    <a href="{{ route('admin.transactions.history') }}" class="admin-nav-link {{ request()->routeIs('admin.transactions.*') ? 'active' : '' }}">
                        <span class="admin-nav-icon">📋</span>
                        <span>Transaction History</span>
                    </a>
                </div>
                
                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">Reports</div>
                    <a href="{{ route('admin.reports.index') }}" class="admin-nav-link {{ request()->routeIs('admin.reports.*') ? 'active' : '' }}">
                        <span class="admin-nav-icon">📈</span>
                        <span>Reports</span>
                    </a>
                </div>
                
                <div class="admin-nav-section">
                    <div class="admin-nav-section-title">System</div>
                    <a href="{{ route('home') }}" class="admin-nav-link">
                        <span class="admin-nav-icon">🏠</span>
                        <span>Back to Website</span>
                    </a>
                    <form action="{{ route('logout') }}" method="POST" style="margin: 0;">
                        @csrf
                        <button type="submit" class="admin-nav-link" style="width: 100%; background: none; border: none; cursor: pointer; text-align: left;">
                            <span class="admin-nav-icon">🚪</span>
                            <span>Logout</span>
                        </button>
                    </form>
                </div>
            </nav>
        </aside>
        
        <!-- Main Content -->
        <main class="admin-main">
            <header class="admin-header">
                <div class="admin-header-title">
                    <h1>@yield('page-title', 'Dashboard')</h1>
                </div>
                <div class="admin-header-actions">
                    <span style="color: var(--text-secondary); font-size: 0.875rem;">
                        {{ auth()->user()->name }}
                    </span>
                </div>
            </header>
            
            <div class="admin-content">
                @if(session('success'))
                    <div class="alert alert-success" style="margin-bottom: 1.5rem;">{{ session('success') }}</div>
                @endif
                
                @if(session('error'))
                    <div class="alert alert-error" style="margin-bottom: 1.5rem;">{{ session('error') }}</div>
                @endif
                
                @if(session('warning'))
                    <div class="alert alert-warning" style="margin-bottom: 1.5rem;">{{ session('warning') }}</div>
                @endif

                @yield('content')
            </div>
        </main>
    </div>

    <script src="{{ asset('js/main.js') }}"></script>
    <script>
        // Mobile sidebar toggle
        document.addEventListener('DOMContentLoaded', function() {
            const sidebar = document.getElementById('adminSidebar');
            // Add mobile menu toggle button if needed
        });
    </script>
    @stack('scripts')
</body>
</html>
