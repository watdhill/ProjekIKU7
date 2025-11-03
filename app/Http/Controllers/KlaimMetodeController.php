<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KlaimMetode;

class KlaimMetodeController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->input('data');

        foreach ($data as $item) {
            KlaimMetode::updateOrCreate(
                ['mata_kuliah_id' => $item['mata_kuliah_id']],
                ['metode' => $item['metode']]
            );
        }

        return response()->json(['success' => true, 'message' => 'Data metode berhasil disimpan!']);
    }
}
