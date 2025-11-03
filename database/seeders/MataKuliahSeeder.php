<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MataKuliah;

class MataKuliahSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'departemen_id' => 1,
                'semester' => 1,
                'kode_matkul' => 'IF101',
                'nama_matkul' => 'Pengantar Teknologi Informasi',
                'sks' => 2,
                'metode' => null, // belum diisi, nanti user pilih PjBL/CBM
            ],
            [
                'departemen_id' => 1,
                'semester' => 1,
                'kode_matkul' => 'IF102',
                'nama_matkul' => 'Dasar Pemrograman',
                'sks' => 3,
                'metode' => null,
            ],
            [
                'departemen_id' => 1,
                'semester' => 2,
                'kode_matkul' => 'IF201',
                'nama_matkul' => 'Struktur Data',
                'sks' => 3,
                'metode' => null,
            ],
            [
                'departemen_id' => 2,
                'semester' => 1,
                'kode_matkul' => 'SI101',
                'nama_matkul' => 'Sistem Informasi Dasar',
                'sks' => 3,
                'metode' => null,
            ],
            [
                'departemen_id' => 2,
                'semester' => 2,
                'kode_matkul' => 'SI202',
                'nama_matkul' => 'Analisis dan Perancangan Sistem',
                'sks' => 3,
                'metode' => null,
            ],
        ];

        MataKuliah::insert($data);
    }
}
