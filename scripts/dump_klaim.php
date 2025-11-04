<?php

require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';

// Boot the kernel so Eloquent and config work
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\KlaimMetode;
use App\Models\MataKuliah;

// 30 klaim terbaru
$latest = KlaimMetode::orderBy('id', 'desc')->limit(30)->get()->toArray();

// Klaim untuk IF101 & IF102
$if = KlaimMetode::select('klaim_metode.*')
    ->join('mata_kuliah as mk', 'klaim_metode.mata_kuliah_id', '=', 'mk.id')
    ->whereIn('mk.kode_matkul', ['IF101','IF102'])
    ->orderBy('klaim_metode.id', 'desc')
    ->get()
    ->toArray();

echo "=== LATEST 30 KLAIM ===\n";
echo json_encode($latest, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n\n";

echo "=== KLAIM FOR IF101 / IF102 ===\n";
echo json_encode($if, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";

// Show MataKuliah komponen for IF101 / IF102
$mks = MataKuliah::whereIn('kode_matkul', ['IF101','IF102'])->get()->toArray();
echo "\n=== MATA KULIAH (IF101/IF102) ===\n";
echo json_encode($mks, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) . "\n";
