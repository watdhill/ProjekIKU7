<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Fakultas;
use App\Models\Departemen;
use App\Models\KomponenNilai;
use Illuminate\Support\Facades\Storage;
use App\Models\KlaimMetode;

class MataKuliahController extends Controller
{
    public function dashboard()
    {
        return view('mata_kuliah.dashboard');
    }

    public function index()
    {
        $mataKuliah = MataKuliah::all();
        return view('mata_kuliah.index', compact('mataKuliah'));
    }

    public function create()
    {
        $fakultasList = Fakultas::all();
        return view('mata_kuliah.create', compact('fakultasList'));
    }

    public function store(Request $request)
    {
            \Log::info('Request data masuk:', [
                'all' => $request->all(),
                'komponen_data' => $request->komponen_data,
                'mata_kuliah_id' => $request->mata_kuliah_id,
                'metode' => $request->input('metode')
            ]);
        
        try {
            $request->validate([
                'mata_kuliah_id' => 'required|exists:mata_kuliah,id',
                'komponen_data' => 'required|json',
                'dokumen' => 'required|file|mimes:pdf,doc,docx|max:5120', // 5MB
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed:', ['errors' => $e->errors()]);
            throw $e;
        }

        try {
            // Validasi total persentase komponen harus 100
            $komponenData = json_decode($request->komponen_data, true);
            $totalPersentase = 0;
            foreach ($komponenData as $komponen) {
                if (isset($komponen['presentase'])) {
                    $totalPersentase += (float) $komponen['presentase'];
                }
            }
            if ($totalPersentase !== 100.0) {
                return redirect()->back()->with('error', 'Total persentase komponen harus 100%. Saat ini: ' . $totalPersentase . '%')->withInput();
            }

            // Simpan dokumen
            $dokumenPath = null;
            if ($request->hasFile('dokumen')) {
                $dokumen = $request->file('dokumen');
                $dokumenPath = $dokumen->store('dokumen-mata-kuliah', 'public');
            }

            // Update mata kuliah dengan path dokumen dan simpan komponen JSON
            $mataKuliah = MataKuliah::findOrFail($request->mata_kuliah_id);
            $mataKuliah->update([
                'dokumen_path' => $dokumenPath,
                'komponen' => $komponenData,
            ]);

            // Hapus komponen nilai lama (jika ada) dan simpan yang baru
            KomponenNilai::where('mata_kuliah_id', $request->mata_kuliah_id)->delete();

                // Simpan komponen nilai baru
            foreach ($komponenData as $komponen) {
                // Pastikan nama tidak kosong dan persentase valid
                $nama = trim($komponen['nama'] ?? '');
                $persentase = intval($komponen['presentase'] ?? 0);

                if (!empty($nama)) {
                    try {
                        \Log::info('Creating komponen:', [
                            'nama' => $nama,
                            'persentase' => $persentase
                        ]);
                        
                        KomponenNilai::create([
                            'mata_kuliah_id' => $request->mata_kuliah_id,
                            'nama_komponen' => $nama,
                            'persentase' => $persentase // Simpan 0 jika tidak ada nilai
                        ]);
                    } catch (\Exception $e) {
                        \Log::error('Failed to save komponen:', [
                            'nama' => $nama,
                            'persentase' => $persentase,
                            'error' => $e->getMessage()
                        ]);
                        throw $e;
                    }
                }
            }            // Perbarui/buat entri klaim_metode agar menyimpan snapshot data yang ditampilkan di rekap
            try {
                $mk = $mataKuliah; // already fetched above
                // Mapping exact untuk komponen
                $componentMapping = [
                    'Partisipasi' => 'partisipasi',
                    'Proyek' => 'proyek',
                    'Kuis' => 'kuis',
                    'Tugas' => 'tugas',
                    'UTS' => 'uts',
                    'UAS' => 'uas'
                ];

                // Array untuk menyimpan nilai komponen dengan default 0
                $components = [
                    'partisipasi' => 0,
                    'proyek' => 0,
                    'kuis' => 0,
                    'tugas' => 0,
                    'uts' => 0,
                    'uas' => 0
                ];

                // Update nilai komponen berdasarkan input
                foreach ($komponenData as $c) {
                    $nama = strtolower(trim($c['nama'] ?? ''));
                    $presentase = intval($c['presentase'] ?? 0);
                    
                    \Log::info('Processing komponen input:', [
                        'nama' => $nama,
                        'presentase' => $presentase
                    ]);

                    // Map komponen dengan case-insensitive match
                    $nama_lower = strtolower($nama);
                    switch ($nama_lower) {
                        case 'partisipasi':
                        case 'partisipasi ':
                            $components['partisipasi'] = $presentase;
                            break;
                        case 'proyek':
                        case 'proyek ':
                            $components['proyek'] = $presentase;
                            break;
                        case 'kuis':
                        case 'kuis ':
                            $components['kuis'] = $presentase;
                            break;
                        case 'tugas':
                        case 'tugas ':
                            $components['tugas'] = $presentase;
                            break;
                        case 'uts':
                        case 'uts ':
                            $components['uts'] = $presentase;
                            break;
                        case 'uas':
                        case 'uas ':
                            $components['uas'] = $presentase;
                            break;
                    }
                    
                    if (!isset($components['partisipasi']) && stripos($nama, 'partisipasi') !== false) {
                        $components['partisipasi'] = $presentase;
                    } else if (!isset($components['proyek']) && stripos($nama, 'proyek') !== false) {
                        $components['proyek'] = $presentase;
                    } else if (!isset($components['kuis']) && stripos($nama, 'kuis') !== false) {
                        $components['kuis'] = $presentase;
                    } else if (!isset($components['tugas']) && stripos($nama, 'tugas') !== false) {
                        $components['tugas'] = $presentase;
                    } else if (!isset($components['uts']) && (stripos($nama, 'uts') !== false || stripos($nama, 'tengah semester') !== false)) {
                        $components['uts'] = $presentase;
                    } else if (!isset($components['uas']) && (stripos($nama, 'uas') !== false || stripos($nama, 'akhir semester') !== false)) {
                        $components['uas'] = $presentase;
                    }
                    
                    \Log::info('Processing komponen:', [
                        'nama_original' => $c['nama'] ?? '',
                        'nama_processed' => $nama,
                        'presentase' => $presentase,
                        'components' => $components
                    ]);
                }

                // Ambil klaim metode yang ada
                $existingKlaim = KlaimMetode::where('mata_kuliah_id', $request->mata_kuliah_id)
                                          ->orderBy('created_at', 'desc')
                                          ->first();
                                          
                // Prefer metode from the request if provided (client now sends it),
                // otherwise fall back to the saved value on MataKuliah.
                $metodeToSave = $request->input('metode') ?: ($mk->metode ?? null);

                // Pastikan kita punya data mata kuliah yang valid
                if (!$mk->kode_matkul || !$mk->nama_matkul) {
                    throw new \Exception('Data mata kuliah tidak lengkap');
                }

                // Buat record baru untuk setiap perubahan
                $klaimMetode = new KlaimMetode();
                $klaimMetode->mata_kuliah_id = $request->mata_kuliah_id;
                $klaimMetode->metode = $metodeToSave;
                $klaimMetode->kode_matkul = $mk->kode_matkul;
                $klaimMetode->nama_matkul = $mk->nama_matkul;
                
                // Pastikan nilai komponen diambil dengan benar dari array components
                $klaimMetode->partisipasi = array_key_exists('partisipasi', $components) ? (int)$components['partisipasi'] : 0;
                $klaimMetode->proyek = array_key_exists('proyek', $components) ? (int)$components['proyek'] : 0;
                $klaimMetode->kuis = array_key_exists('kuis', $components) ? (int)$components['kuis'] : 0;
                $klaimMetode->tugas = array_key_exists('tugas', $components) ? (int)$components['tugas'] : 0;
                $klaimMetode->uts = array_key_exists('uts', $components) ? (int)$components['uts'] : 0;
                $klaimMetode->uas = array_key_exists('uas', $components) ? (int)$components['uas'] : 0;
                $klaimMetode->valid = true; // tandai sebagai valid
                
                \Log::info('Saving klaim_metode with components:', [
                    'components' => $components,
                    'klaim_data' => $klaimMetode->toArray()
                ]);

                // Log data sebelum menyimpan
                \Log::info('Saving klaim_metode data:', $klaimMetode->toArray());

                // Simpan record baru
                $klaimMetode->save();
                    \Log::info('Klaim metode berhasil disimpan:', [
                        'id' => $klaimMetode->id,
                        'mata_kuliah_id' => $klaimMetode->mata_kuliah_id,
                        'komponen' => [
                            'partisipasi' => $klaimMetode->partisipasi,
                            'proyek' => $klaimMetode->proyek,
                            'kuis' => $klaimMetode->kuis,
                            'tugas' => $klaimMetode->tugas,
                            'uts' => $klaimMetode->uts,
                            'uas' => $klaimMetode->uas
                        ]
                    ]);
            } catch (\Exception $e) {
                    \Log::error('Gagal menyimpan klaim_metode:', [
                        'error' => $e->getMessage(),
                        'trace' => $e->getTraceAsString()
                    ]);
                    throw $e; // kita throw error untuk mengetahui masalahnya
            }

            // Jika permintaan AJAX (fetch) - kembalikan JSON dengan URL redirect ke rekap rektorat
            $fakultas = $request->input('fakultas');
            $departemen = $request->input('departemen');
            $semester = $request->input('semester');

            $redirectUrl = route('rektorat.rekap_matakuliah', array_filter([
                'fakultas' => $fakultas,
                'departemen' => $departemen,
                'semester' => $semester,
            ]));

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(["success" => true, "redirect" => $redirectUrl]);
            }

            return redirect()->route('matkul.index')->with('success', 'Data mata kuliah berhasil disimpan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    // Fungsi AJAX untuk ambil departemen berdasarkan fakultas
    public function getDepartemen($fakultas_id)
    {
        $departemen = Departemen::where('fakultas_id', $fakultas_id)->get();
        return response()->json($departemen);
    }

    // Fungsi AJAX untuk ambil mata kuliah berdasarkan departemen & semester
    public function getMatkul($departemen_id, $semester)
    {
        $matkul = MataKuliah::where('departemen_id', $departemen_id)
                            ->where('semester', $semester)
                            ->get();
        return response()->json($matkul);
    }

    public function getByFakultas($fakultas_id)
    {
        $departemen = \App\Models\Departemen::where('fakultas_id', $fakultas_id)->get();

        // pastikan JSON dikembalikan
        return response()->json($departemen);
    }

}
