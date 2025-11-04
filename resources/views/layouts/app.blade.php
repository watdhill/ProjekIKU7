{{-- resources/views/layouts/rektorat.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title','Rektorat')</title>
    @vite('resources/css/app.css')
    <style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f9fafb;
    }
    .sidebar {
        width: 220px;
        min-height: 100vh;
        /* Blue gradient background */
        background: linear-gradient(180deg, #2563eb 0%, #1e40af 100%);
        border-right: 1px solid rgba(255,255,255,0.06);
        position: fixed;
        top: 0;
        left: 0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
        color: #ffffff;
    }
    .sidebar h2 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 30px;
        color: #ffffff;
    }
    /* override inline span color to match sidebar */
    .sidebar h2 span { color: rgba(255,255,255,0.9) !important; font-size:12px; }
    .nav-links {
        flex-grow: 1;
    }
    .nav-item {
        display: block;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        color: rgba(255,255,255,0.95);
        text-decoration: none;
        transition: background 0.18s ease, transform 0.12s ease;
    }
    .nav-item:hover {
        background: rgba(255,255,255,0.06);
        color: #ffffff;
        transform: translateY(-1px);
    }
    .nav-item.active {
        background: #ffff; /* darker blue for active */
        color: #1d4ed8;
        box-shadow: 0 6px 12px rgba(29,78,216,0.12);
    }
    .user-menu {
        position: relative;
    }
    .user-menu-btn {
        width: 100%;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: linear-gradient(135deg, #6b7280 0%, #4b5563 100%);
        color: #fff;
        padding: 12px 16px;
        border-radius: 8px;
        border: none;
        font-weight: 600;
        font-size: 14px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .user-menu-btn:hover {
        background: linear-gradient(135deg, #4b5563 0%, #374151 100%);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.15);
    }
    .user-menu-btn svg {
        transition: transform 0.2s ease;
    }
    .user-menu-btn.active svg {
        transform: rotate(180deg);
    }
    .user-menu-dropdown {
        position: absolute;
        bottom: 60px;
        left: 0;
        right: 0;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15), 0 4px 6px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        opacity: 0;
        visibility: hidden;
        transform: translateY(10px);
        transition: all 0.3s ease;
        z-index: 1000;
        border: 1px solid #e5e7eb;
    }
    .user-menu-dropdown.show {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }
    .user-menu-item {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 14px 16px;
        color: #374151;
        text-decoration: none;
        transition: all 0.2s ease;
        border-bottom: 1px solid #f3f4f6;
        font-size: 14px;
        font-weight: 500;
    }
    .user-menu-item:last-child {
        border-bottom: none;
    }
    .user-menu-item:hover {
        background: #f9fafb;
        color: #2563eb;
    }
    .user-menu-item.logout {
        color: #ef4444;
    }
    .user-menu-item.logout:hover {
        background: #fee2e2;
        color: #dc2626;
    }
    .user-menu-item svg {
        width: 18px;
        height: 18px;
    }
    .content {
        margin-left: 240px;
        padding: 30px;
    }
    .btn-blue {
        background:#2563eb;
        color:#fff;
        padding:8px 16px;
        border-radius:6px;
        display:inline-block;
        box-shadow:0 2px 4px rgba(0,0,0,.1);
        text-decoration:none;
    }
    .btn-blue:hover {
        background:#1d4ed8;
    }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div>
            <h2>
                MYUNAND<br>
                <span style="font-size:12px; color:#555;">Universitas Andalas</span>
            </h2>

            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">Dashboard</a>
                <a href="{{ route('matkul.index') }}" class="nav-item {{ request()->routeIs('matkul.index') ? 'active' : '' }}">Mata Kuliah Saya</a>
                <a href="{{ route('matkul.create') }}" class="nav-item {{ request()->routeIs('matkul.create') ? 'active' : '' }}">Input Mata Kuliah</a>
            </div>
        </div>

        {{-- User Menu Dropdown --}}
        <div class="user-menu">
            <button type="button" class="user-menu-btn" onclick="toggleUserMenu()">
                <span>{{ Auth::user()->name ?? 'User' }}</span>
                <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </button>
            
            <div class="user-menu-dropdown" id="userMenuDropdown">
                <a href="{{ route('profile.edit') }}" class="user-menu-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                    Profile
                </a>
                <a href="{{ route('profile.edit') }}" class="user-menu-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                    </svg>
                    Setting
                </a>
                <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
                    @csrf
                    <button type="submit" class="user-menu-item logout" style="width: 100%; text-align: left; border: none; background: none; cursor: pointer;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                        </svg>
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>

    <div class="content">
        @yield('content')
    </div>

    @stack('scripts')
    <script>
        function toggleUserMenu() {
            const dropdown = document.getElementById('userMenuDropdown');
            const button = document.querySelector('.user-menu-btn');
            dropdown.classList.toggle('show');
            button.classList.toggle('active');
        }

        // Tutup dropdown saat klik di luar
        document.addEventListener('click', function(event) {
            const menu = document.querySelector('.user-menu');
            const dropdown = document.getElementById('userMenuDropdown');
            if (!menu.contains(event.target) && dropdown.classList.contains('show')) {
                dropdown.classList.remove('show');
                document.querySelector('.user-menu-btn').classList.remove('active');
            }
        });
    </script>
</body>
</html>
