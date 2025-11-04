<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlaimMetode extends Model
{
    use HasFactory;

    protected $table = 'klaim_metode';

    protected $fillable = [
        'mata_kuliah_id', 'metode', 'kode_matkul', 'nama_matkul',
        'partisipasi', 'proyek', 'kuis', 'tugas', 'uts', 'uas', 'valid'
    ];

    protected $casts = [
        'valid' => 'boolean',
        'partisipasi' => 'integer',
        'proyek' => 'integer',
        'kuis' => 'integer',
        'tugas' => 'integer',
        'uts' => 'integer',
        'uas' => 'integer'
    ];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class, 'mata_kuliah_id');
    }
}
