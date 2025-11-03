<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

    public function rekapMataKuliah()
    {
        $matakuliah = [
            [
                'kode' => 'IF101', 
                'nama' => 'Algoritma', 
                'sks' => 3, 
                'metode' => 'PJBL', 
                'partisipasi' => 10,
                'proyek' => 30,
                'kuis' => 10,
                'tugas' => 10,
                'uts' => 20,
                'uas' => 20
            ],
            [
                'kode' => 'IF102', 
                'nama' => 'Basis Data', 
                'sks' => 3,
                'metode' => 'CBL', 
                'partisipasi' => 15,
                'proyek' => 25,
                'kuis' => 10,
                'tugas' => 15,
                'uts' => 15,
                'uas' => 20
            ],
        ];
        return view('rektorat.rekap_matakuliah', compact('matakuliah'));
    }

    public function inputNilai()
    {
        return view('rektorat.input_nilai');
    }
}
