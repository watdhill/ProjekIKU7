@extends('layouts.app')

@section('content')
<div class="main-content">
    <h2 class="text-lg font-bold mb-3">Tambah Komponen Nilai</h2>
    <form action="#" method="POST" class="bg-white p-4 rounded shadow">
        @csrf
        <div class="mb-3">
            <label for="mata_kuliah">Mata Kuliah</label>
            <select id="mata_kuliah" class="border rounded px-2 py-1 w-full">
                <option>IF101 - Pemrograman Dasar</option>
                <option>IF102 - Struktur Data</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="komponen">Nama Komponen</label>
            <input type="text" id="komponen" class="border rounded px-2 py-1 w-full" placeholder="Proyek / Kasus / UTS / UAS">
        </div>
        <div class="mb-3">
            <label for="bobot">Bobot (%)</label>
            <input type="number" id="bobot" class="border rounded px-2 py-1 w-full" placeholder="Contoh: 50">
        </div>
        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">Simpan Komponen</button>
    </form>
</div>
