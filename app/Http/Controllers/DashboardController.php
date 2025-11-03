<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        // Dummy data untuk dashboard
        $totalMatkul = 320;
        $pjbl = 200;
        $cbm = 120;

        return view('dashboard', compact('totalMatkul', 'pjbl', 'cbm'));
    }
}
