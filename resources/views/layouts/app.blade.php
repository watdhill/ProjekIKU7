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
        background: #fff;
        border-right: 1px solid #e5e7eb;
        position: fixed;
        top: 0;
        left: 0;
        padding: 20px;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .sidebar h2 {
        font-size: 18px;
        font-weight: bold;
        margin-bottom: 30px;
        color: #1f2937;
    }
    .nav-links {
        flex-grow: 1;
    }
    .nav-item {
        display: block;
        padding: 10px 15px;
        margin-bottom: 10px;
        border-radius: 8px;
        color: #374151;
        text-decoration: none;
        transition: 0.2s;
    }
    .nav-item:hover {
        background: #f3f4f6;
    }
    .nav-item.active {
        background: #2563eb;
        color: #fff;
    }
    .logout-btn {
        display: block;
        text-align: center;
        background: #ef4444;
        color: #fff;
        padding: 10px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        transition: 0.2s;
    }
    .logout-btn:hover {
        background: #dc2626;
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

        {{-- Tombol Logout --}}
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="logout-btn">Logout</button>
        </form>
    </div>

    <div class="content">
        @yield('content')
    </div>

    @stack('scripts')
</body>
</html>
