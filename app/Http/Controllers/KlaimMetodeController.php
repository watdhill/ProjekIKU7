<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KlaimMetode;
use App\Models\MataKuliah;

class KlaimMetodeController extends Controller
{
    public function store(Request $request)
    {
        try {
            if (!$request->has('data')) {
                return response()->json(['success' => false, 'message' => 'Data tidak valid'], 400);
            }

            $data = $request->input('data');
            
            foreach ($data as $item) {
                if (!isset($item['mata_kuliah_id']) || !isset($item['metode'])) {
                    return response()->json(['success' => false, 'message' => 'Format data tidak valid'], 400);
                }

                // Cari mata kuliah terkait
                $mataKuliah = MataKuliah::find($item['mata_kuliah_id']);
                if (!$mataKuliah) {
                    \Log::warning('Mata kuliah not found:', ['id' => $item['mata_kuliah_id']]);
                    continue;
                }

                try {
                    // Update metode pada MataKuliah
                    $mataKuliah->metode = $item['metode'];
                    $mataKuliah->save();
                    
                    \Log::info('Updated MataKuliah.metode:', [
                        'mata_kuliah_id' => $item['mata_kuliah_id'],
                        'kode_matkul' => $mataKuliah->kode_matkul,
                        'metode' => $item['metode']
                    ]);
                } catch (\Exception $e) {
                    \Log::error('Failed to update MataKuliah.metode:', [
                        'error' => $e->getMessage(),
                        'mata_kuliah_id' => $item['mata_kuliah_id']
                    ]);
                    throw $e;
                }
            }

            return response()->json([
                'success' => true,
                'message' => 'Metode pembelajaran berhasil disimpan'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan metode pembelajaran: ' . $e->getMessage()
            ], 500);
        }
    }
}
