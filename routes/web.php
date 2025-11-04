<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MataKuliahController;
use App\Http\Controllers\DosenController;
use App\Http\Controllers\KlaimMetodeController;
use App\Http\Controllers\NilaiController;
use App\Http\Controllers\RektoratController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan semua route web aplikasi.
| Route ini dimuat oleh RouteServiceProvider dan berada di dalam grup "web".
|
*/

// Halaman utama
Route::get('/', function () {
    return view('welcome');
});

// Login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route untuk dashboard dosen (default)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [MataKuliahController::class, 'dashboard'])
        ->name('dashboard');

    // CRUD Mata Kuliah
    Route::resource('matkul', MataKuliahController::class);
    Route::get('/matkul', [MataKuliahController::class, 'index'])->name('matkul.index');
    Route::get('matkul/create', [MataKuliahController::class, 'create'])->name('matkul.create');


    // CRUD Dosen
    Route::resource('dosen', DosenController::class);

    // Klaim Metode Pembelajaran
    Route::get('klaim', [KlaimMetodeController::class, 'index'])->name('klaim.index');
    Route::get('/klaim-metode/create', [KlaimMetodeController::class, 'create'])->name('klaim.create');
    Route::post('/klaim-metode/store', [KlaimMetodeController::class, 'store'])->name('klaim.store');
    Route::get('klaim/{klaim}/edit', [KlaimMetodeController::class, 'edit'])->name('klaim.edit');
    Route::put('klaim/{klaim}', [KlaimMetodeController::class, 'update'])->name('klaim.update');
    Route::delete('klaim/{klaim}', [KlaimMetodeController::class, 'destroy'])->name('klaim.destroy');

    // Input & Monitoring Nilai
    Route::resource('nilai', NilaiController::class);

    // Profile User
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Dropdown dinamis
    Route::get('/departemen/{fakultas_id}', [MataKuliahController::class, 'getDepartemen']);
    Route::get('/matkul/{departemen_id}/{semester}', [MataKuliahController::class, 'getMatkul']);
    Route::get('/departemen/{fakultas_id}', [App\Http\Controllers\DepartemenController::class, 'getByFakultas']);
    Route::post('/klaim-metode/simpan', [KlaimMetodeController::class, 'store']);

});

// Route khusus Rektorat / Admin
Route::prefix('rektorat')->middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [RektoratController::class, 'dashboard'])->name('rektorat.dashboard');
    Route::get('/rekap_fakultas', [RektoratController::class, 'rekapFakultas'])->name('rektorat.rekap_fakultas');
    Route::get('/rekap_matakuliah', [RektoratController::class, 'rekapMataKuliah'])->name('rektorat.rekap_matakuliah');
    Route::get('/input_nilai', [RektoratController::class, 'inputNilai'])->name('rektorat.input_nilai');
    Route::get('/get-departemen/{fakultasId}', [RektoratController::class, 'getDepartemen'])->name('rektorat.getDepartemen');
});

// Auth routes default Laravel (register, login, password reset)
require __DIR__.'/auth.php';