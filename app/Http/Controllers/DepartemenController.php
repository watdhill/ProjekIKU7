<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Departemen;

class DepartemenController extends Controller
{
    public function getByFakultas($fakultas_id)
    {
        $departemen = Departemen::where('fakultas_id', $fakultas_id)->get();
        return response()->json($departemen);
    }
}
