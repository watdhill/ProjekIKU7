<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Departemen;
use App\Models\KomponenNilai;
use App\Models\Fakultas;

class RektoratController extends Controller
{
    public function dashboard()
    {
        return view('rektorat.dashboard');
    }

    public function rekapFakultas()
    {
        $fakultas = [
            ['nama' => 'Fakultas Teknologi Informasi', 'jumlah_mahasiswa' => 2500],
            ['nama' => 'Fakultas Ekonomi', 'jumlah_mahasiswa' => 1800],
        ];
        return view('rektorat.rekap_fakultas', compact('fakultas'));
    }

    public function rekapMataKuliah(Request $request)
    {
        $semester = $request->get('semester');
        $fakultasId = $request->get('fakultas');
        $departemenId = $request->get('departemen');

        // Get fakultas dan departemen untuk dropdown
        $fakultas = Fakultas::all();
        
        // Jika ada fakultas yang dipilih, ambil departemennya
        $departemen = $fakultasId ? Departemen::where('fakultas_id', $fakultasId)->get() : collect();

        // Inisialisasi matakuliah sebagai array kosong
        $matakuliah = [];

        // Cek apakah ada filter yang diisi
        $hasFilters = $semester || $fakultasId || $departemenId;

        \Log::info('Filter Parameters:', [
            'semester' => $semester,
            'fakultasId' => $fakultasId,
            'departemenId' => $departemenId,
            'hasFilters' => $hasFilters
        ]);

        if ($hasFilters) {
            // Mulai query dengan eager loading yang diperlukan
            $query = MataKuliah::with([
                'komponenNilai', 
                'departemen.fakultas', 
                'klaimMetode' => function($q) {
                    // Urutkan klaim berdasarkan validitas dan tanggal
                    $q->orderBy('valid', 'desc')
                      ->orderBy('created_at', 'desc');
                }
            ])->whereHas('klaimMetode'); // Hanya ambil mata kuliah yang memiliki klaim_metode

            // Tambahkan filter secara kondisional
            if ($semester !== null && trim($semester) !== '') {
                $query->where('semester', $semester);
            }

            if ($fakultasId) {
                $query->whereHas('departemen', function($q) use ($fakultasId) {
                    $q->where('fakultas_id', $fakultasId);
                });
            }

            if ($departemenId) {
                $query->where('departemen_id', $departemenId);
            }
            $mataKuliahList = $query->get();

            // Format data for view - tampilkan data sesuai filter
            $matakuliah = $mataKuliahList->map(function($mk) {
                // Klaim sudah diurutkan dari eager loading (valid dan terbaru dulu)
                $source = $mk->klaimMetode->first();
                
                // Default komponen nilai
                $components = [
                    'partisipasi' => 0,
                    'proyek' => 0,
                    'kuis' => 0,
                    'tugas' => 0,
                    'uts' => 0,
                    'uas' => 0,
                ];

                // Cek sumber data untuk komponen nilai
                if ($source) {
                    // Gunakan klaim metode jika ada
                    foreach ($components as $key => &$value) {
                        $value = (int) ($source->$key ?? 0);
                    }
                } elseif ($mk->komponenNilai->isNotEmpty()) {
                    // Gunakan komponen nilai dari database jika ada
                    foreach ($mk->komponenNilai as $komponen) {
                        $name = strtolower(trim($komponen->nama_komponen));
                        if (array_key_exists($name, $components)) {
                            $components[$name] = (int) $komponen->persentase;
                        }
                    }
                }

                // Tentukan status tampilan (Pending atau nilai aktual)
                $showPending = false;
                $hasNonZero = array_sum($components) > 0;

                // Atur logika Pending
                if (!$source && !$hasNonZero) {
                    // Tidak ada klaim dan semua nilai 0
                    $showPending = true;
                } elseif ($source && !$source->valid && !$hasNonZero) {
                    // Ada klaim tapi belum valid dan semua nilai 0
                    $showPending = true;
                }

                // Tentukan metode yang ditampilkan
                $metodeDisplay = $source && !empty($source->metode) 
                    ? $source->metode 
                    : ($mk->metode ?? '-');


                \Log::info('Processing mata kuliah (rekap):', [
                    'kode' => $mk->kode_matkul,
                    'nama' => $mk->nama_matkul,
                    'metode_display' => $metodeDisplay,
                    'components' => $components,
                    'klaim_source_id' => $source ? $source->id : null,
                    'klaim_source_valid' => $source ? (bool)$source->valid : null,
                ]);

                return [
                    'kode' => $mk->kode_matkul,
                    'nama' => $mk->nama_matkul,
                    'sks' => $mk->sks,
                    'metode' => $metodeDisplay,
                    'partisipasi' => $showPending ? 'Pending' : $components['partisipasi'],
                    'proyek' => $showPending ? 'Pending' : $components['proyek'],
                    'kuis' => $showPending ? 'Pending' : $components['kuis'],
                    'tugas' => $showPending ? 'Pending' : $components['tugas'],
                    'uts' => $showPending ? 'Pending' : $components['uts'],
                    'uas' => $showPending ? 'Pending' : $components['uas'],
                ];
            })->values()->toArray();
        }

        return view('rektorat.rekap_matakuliah', compact('matakuliah', 'fakultas', 'departemen'));
    }

    public function inputNilai()
    {
        return view('rektorat.input_nilai');
    }

    public function getDepartemen($fakultasId)
    {
        $departemen = Departemen::where('fakultas_id', $fakultasId)->get();
        return response()->json($departemen);
    }
}