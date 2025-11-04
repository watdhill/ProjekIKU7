<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MataKuliah extends Model
{
    use HasFactory;

    protected $table = 'mata_kuliah';

    protected $fillable = [
        'departemen_id', 
        'semester',
        'kode_matkul',
        'nama_matkul',
        'sks',
        'metode',
        'dokumen_path',
        'komponen'
    ];

    protected $casts = [
        'komponen' => 'array',
    ];

    // Relasi: mata kuliah punya banyak klaim metode
    public function klaimMetode()
    {
        return $this->hasMany(KlaimMetode::class, 'mata_kuliah_id');
    }

    public function departemen() {
        return $this->belongsTo(Departemen::class);
    }

    // Relasi: mata kuliah punya banyak komponen nilai
    public function komponenNilai()
    {
        return $this->hasMany(KomponenNilai::class, 'mata_kuliah_id');
    }
}
