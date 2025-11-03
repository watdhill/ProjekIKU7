@extends('layouts.rektorat')

@section('title','Input Nilai Mahasiswa')

@section('content')
<style>
    .page-header {
        margin-bottom: 32px;
        padding-bottom: 20px;
        border-bottom: 2px solid #e5e7eb;
    }
    .page-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin: 0;
    }
    .filter-section {
        background: #f9fafb;
        padding: 24px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        margin-bottom: 24px;
    }
    .filter-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 16px;
        margin-bottom: 16px;
    }
    .filter-group {
        display: flex;
        flex-direction: column;
    }
    .filter-label {
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    .filter-select {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        color: #1f2937;
        background-color: #ffffff;
        transition: all 0.2s ease;
    }
    .filter-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        padding: 12px 24px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
    }
    .btn-primary:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.4);
        transform: translateY(-1px);
    }
    .info-card {
        background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%);
        padding: 20px;
        border-radius: 12px;
        border-left: 4px solid #2563eb;
        margin-bottom: 24px;
    }
    .info-card h3 {
        font-size: 18px;
        font-weight: 700;
        color: #1e40af;
        margin: 0 0 12px 0;
    }
    .info-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 12px;
    }
    .info-item {
        font-size: 14px;
        color: #1e40af;
    }
    .info-item strong {
        display: block;
        margin-bottom: 4px;
        font-weight: 600;
    }
    .table-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        margin-bottom: 24px;
    }
    .modern-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .modern-table thead {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
    }
    .modern-table th {
        padding: 14px 12px;
        text-align: center;
        font-weight: 600;
        font-size: 12px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .modern-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e5e7eb;
    }
    .modern-table tbody tr:hover {
        background: #f9fafb;
    }
    .modern-table tbody tr:last-child {
        border-bottom: none;
    }
    .modern-table td {
        padding: 12px;
        text-align: center;
        color: #374151;
        font-size: 14px;
    }
    .modern-table input[type="number"] {
        width: 70px;
        padding: 8px;
        border: 1.5px solid #e5e7eb;
        border-radius: 6px;
        text-align: center;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .modern-table input[type="number"]:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .komponen-nilai {
        font-weight: 600;
        color: #059669;
    }
</style>

<div class="page-header">
    <h1 class="page-title">📝 Input Nilai Mahasiswa</h1>
</div>

<form method="GET" class="filter-section">
    <div class="filter-row">
        <div class="filter-group">
            <label class="filter-label">Fakultas</label>
            <select name="fakultas" class="filter-select">
                <option value="">Pilih Fakultas</option>
                <option value="Teknik" {{ request('fakultas')=='Teknik' ? 'selected' : '' }}>Teknologi Informasi</option>
                <option value="Ekonomi" {{ request('fakultas')=='Ekonomi' ? 'selected' : '' }}>Ekonomi</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-label">Prodi</label>
            <select name="prodi" class="filter-select">
                <option value="">Pilih Prodi</option>
                <option value="Informatika" {{ request('prodi')=='Informatika' ? 'selected' : '' }}>Informatika</option>
                <option value="Teknik Komputer" {{ request('prodi')=='Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                <option value="Manajemen" {{ request('prodi')=='Manajemen' ? 'selected' : '' }}>Manajemen</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-label">Mata Kuliah</label>
            <select name="matakuliah" class="filter-select">
                <option value="">Pilih Mata Kuliah</option>
                <option value="IF101" {{ request('matakuliah')=='IF101' ? 'selected' : '' }}>Algoritma</option>
                <option value="IF102" {{ request('matakuliah')=='IF102' ? 'selected' : '' }}>Basis Data</option>
                <option value="MK201" {{ request('matakuliah')=='MK201' ? 'selected' : '' }}>Manajemen 101</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-label">Semester</label>
            <select name="semester" class="filter-select">
                <option value="">Pilih Semester</option>
                <option value="Ganjil 2025" {{ request('semester')=='Ganjil 2025' ? 'selected' : '' }}>Ganjil 2025</option>
                <option value="Genap 2025" {{ request('semester')=='Genap 2025' ? 'selected' : '' }}>Genap 2025</option>
            </select>
        </div>
    </div>
    <button type="submit" class="btn-primary">Tampilkan</button>
</form>

@if(request('matakuliah') && request('prodi') && request('semester'))
<div class="info-card">
    <h3>📋 Detail Mata Kuliah</h3>
    <div class="info-row">
        <div class="info-item">
            <strong>Program Studi:</strong>
            {{ request('prodi') }}
        </div>
        <div class="info-item">
            <strong>Kode Mata Kuliah:</strong>
            {{ request('matakuliah') }}
        </div>
        <div class="info-item">
            <strong>Mata Kuliah:</strong>
            @if(request('matakuliah')=='IF101') Algoritma
            @elseif(request('matakuliah')=='IF102') Basis Data
            @elseif(request('matakuliah')=='MK201') Manajemen 101
            @endif
        </div>
        <div class="info-item">
            <strong>Semester:</strong>
            {{ request('semester') }}
        </div>
    </div>
</div>

<form method="POST" action="#">
    @csrf
    <div class="table-container">
        <div style="overflow-x: auto;">
            <table class="modern-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>NIM</th>
                        <th>Nama</th>
                        <th>Prodi</th>
                        <th>Status</th>
                        <th>Total Nilai</th>
                        <th>Partisipasi</th>
                        <th>Proyek</th>
                        <th>Kuis</th>
                        <th>Tugas</th>
                        <th>UTS</th>
                        <th>UAS</th>
                    </tr>
                </thead>
                <tbody>
                    @for($i=1; $i<=5; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td>2023100{{ $i }}</td>
                        <td style="text-align: left; padding-left: 16px; font-weight: 500;">
                            Mahasiswa {{ $i }}
                        </td>
                        <td>{{ request('prodi') }}</td>
                        <td>
                            <span style="display: inline-block; padding: 4px 8px; background: #d1fae5; color: #065f46; border-radius: 4px; font-size: 12px; font-weight: 600;">
                                Aktif
                            </span>
                        </td>
                        <td>
                            <input type="number" name="total[]" class="total-input" min="0" max="100" value="0">
                        </td>
                        <td class="komponen-nilai partisipasi">0</td>
                        <td class="komponen-nilai proyek">0</td>
                        <td class="komponen-nilai kuis">0</td>
                        <td class="komponen-nilai tugas">0</td>
                        <td class="komponen-nilai uts">0</td>
                        <td class="komponen-nilai uas">0</td>
                    </tr>
                    @endfor
                </tbody>
            </table>
        </div>
    </div>
    <button type="submit" class="btn-primary">💾 Simpan Data</button>
</form>

<script>
    const presentase = {
        partisipasi: 10,
        proyek: 20,
        kuis: 15,
        tugas: 20,
        uts: 15,
        uas: 20
    };

    document.querySelectorAll('.total-input').forEach(input => {
        input.addEventListener('input', () => {
            let total = parseFloat(input.value) || 0;
            let row = input.closest('tr');

            row.querySelector('.partisipasi').textContent = (total * presentase.partisipasi / 100).toFixed(2);
            row.querySelector('.proyek').textContent = (total * presentase.proyek / 100).toFixed(2);
            row.querySelector('.kuis').textContent = (total * presentase.kuis / 100).toFixed(2);
            row.querySelector('.tugas').textContent = (total * presentase.tugas / 100).toFixed(2);
            row.querySelector('.uts').textContent = (total * presentase.uts / 100).toFixed(2);
            row.querySelector('.uas').textContent = (total * presentase.uas / 100).toFixed(2);
        });
    });
</script>
@endif
@endsection
