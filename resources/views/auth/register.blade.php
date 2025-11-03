<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Register</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="flex items-center justify-center h-screen bg-gray-100">
    <form method="POST" action="{{ route('register') }}" class="bg-white p-6 rounded-lg shadow-md w-96">
        @csrf
        <h2 class="text-2xl font-bold mb-4 text-center">Register</h2>

        <div class="mb-4">
            <label>Nama</label>
            <input type="text" name="name" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label>Email</label>
            <input type="email" name="email" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label>Password</label>
            <input type="password" name="password" class="w-full border rounded p-2" required>
        </div>

        <div class="mb-4">
            <label>Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
        </div>

        <button type="submit" class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">
            Daftar
        </button>

        <p class="mt-4 text-center text-sm">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login</a>
        </p>
    </form>
</body>
</html>