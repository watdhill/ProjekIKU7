<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MataKuliah;
use App\Models\Fakultas;
use App\Models\Departemen;

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
        $request->validate([
            'departemen_id' => 'required|exists:departemen,id',
            'semester'      => 'required|string|max:20',
            'kode_matkul'   => 'required|string|max:10|unique:mata_kuliah,kode_matkul',
            'nama_matkul'   => 'required|string|max:255',
            'metode'        => 'required|string|max:50',
            'sks'           => 'required|integer|min:1|max:10',
        ]);

        MataKuliah::create($request->all());

        return redirect()->route('matkul.index')->with('success', 'Mata kuliah berhasil ditambahkan.');
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
