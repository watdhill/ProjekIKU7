<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    use HasFactory;

    protected $table = 'dosen';

    protected $fillable = [
        'nip',
        'nama',
        'prodi',
        'email'
    ];

    // Relasi: dosen punya banyak klaim metode
    public function klaimMetode()
    {
        return $this->hasMany(KlaimMetode::class, 'dosen_id');
    }
}
