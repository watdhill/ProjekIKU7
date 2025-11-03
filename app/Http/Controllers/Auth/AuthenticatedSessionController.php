<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AuthenticatedSessionController extends Controller
{
    /**
     * Tampilkan halaman login.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Proses login user.
     */
    public function store(Request $request): RedirectResponse
{
    // Validasi input login
    $credentials = $request->validate([
        'email' => ['required', 'string', 'email'],
        'password' => ['required', 'string'],
    ]);

    // Coba autentikasi
    if (Auth::attempt($credentials, $request->boolean('remember'))) {
        // Regenerasi session agar aman
        $request->session()->regenerate();

        // Ambil user yang sedang login
        $user = Auth::user();

        // Arahkan sesuai role
        if ($user->role === 'admin') {
            return redirect()->intended(route('rektorat.dashboard'));
        } else {
            return redirect()->intended(route('dashboard'));
        }
    }

    // Jika gagal login, kirim pesan error
    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}

    /**
     * Logout user.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        // Setelah logout, arahkan ke halaman login
        return redirect('/login');
    }
}