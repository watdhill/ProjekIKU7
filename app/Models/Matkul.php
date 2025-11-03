<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Matkul extends Model
{
    use HasFactory;

    // Tentukan nama tabel manual, karena bukan plural bawaan (mata_kuliah)
    protected $table = 'mata_kuliah';

    // Kolom yang bisa diisi
    protected $fillable = [
        'kode_matkul',
        'nama_matkul',
        'metode',
        'sks',
    ];
}
