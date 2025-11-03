<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KlaimMetode extends Model
{
    use HasFactory;

    protected $table = 'klaim_metode';

    protected $fillable = ['mata_kuliah_id', 'metode'];

    public function mataKuliah()
    {
        return $this->belongsTo(MataKuliah::class);
    }
}
