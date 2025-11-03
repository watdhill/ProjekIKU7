@extends('layouts.rektorat')

@section('title','Rekap Mata Kuliah')

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
        margin: 0 0 24px 0;
    }
    .filter-section {
        background: #f9fafb;
        padding: 24px;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        margin-bottom: 24px;
    }
    .filter-row {
        display: flex;
        gap: 16px;
        flex-wrap: wrap;
        align-items: end;
    }
    .filter-group {
        flex: 1;
        min-width: 200px;
    }
    .filter-label {
        display: block;
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
    .btn-filter {
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
    .btn-filter:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.4);
        transform: translateY(-1px);
    }
    .table-container {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.1);
        overflow: hidden;
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
        padding: 16px 12px;
        text-align: center;
        font-weight: 600;
        font-size: 13px;
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
        padding: 14px 12px;
        text-align: center;
        color: #374151;
        font-size: 14px;
    }
    .kode-cell {
        font-weight: 700;
        color: #2563eb;
        text-align: left !important;
        padding-left: 20px !important;
    }
    .nama-cell {
        text-align: left !important;
        padding-left: 20px !important;
        font-weight: 500;
    }
    .metode-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 12px;
    }
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #6b7280;
    }
    .empty-state-icon {
        font-size: 64px;
        margin-bottom: 16px;
        opacity: 0.5;
    }
</style>

<div class="page-header">
    <h1 class="page-title">📊 Rekap Mata Kuliah</h1>
</div>

<form method="GET" class="filter-section">
    <div class="filter-row">
        <div class="filter-group">
            <label class="filter-label">Semester</label>
            <select name="semester" class="filter-select" onchange="this.form.submit()">
                <option value="">Pilih Semester</option>
                <option value="Ganjil" {{ request('semester')=='Ganjil' ? 'selected' : '' }}>Ganjil</option>
                <option value="Genap" {{ request('semester')=='Genap' ? 'selected' : '' }}>Genap</option>
            </select>
        </div>
        <div class="filter-group">
            <label class="filter-label">Departemen</label>
            <select name="departemen" class="filter-select" onchange="this.form.submit()">
                <option value="">Pilih Departemen</option>
                <option value="Teknik Komputer" {{ request('departemen')=='Teknik Komputer' ? 'selected' : '' }}>Teknik Komputer</option>
                <option value="Sistem Informasi" {{ request('departemen')=='Sistem Informasi' ? 'selected' : '' }}>Sistem Informasi</option>
                <option value="Informatika" {{ request('departemen')=='Informatika' ? 'selected' : '' }}>Informatika</option>
            </select>
        </div>
    </div>
</form>

@if(request('departemen'))
<div style="margin-bottom: 24px; padding: 16px; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 12px; border-left: 4px solid #2563eb;">
    <h2 style="font-size: 20px; font-weight: 700; color: #1e40af; margin: 0;">
        📁 Departemen {{ request('departemen') }}
    </h2>
</div>
@endif

<div class="table-container">
    @if(count($matakuliah ?? []) > 0)
    <div style="overflow-x: auto;">
        <table class="modern-table">
            <thead>
                <tr>
                    <th>Kode</th>
                    <th>Mata Kuliah</th>
                    <th>Metode</th>
                    <th>Partisipasi</th>
                    <th>Proyek</th>
                    <th>Kuis</th>
                    <th>Tugas</th>
                    <th>UTS</th>
                    <th>UAS</th>
                </tr>
            </thead>
            <tbody>
                @foreach($matakuliah ?? [] as $mk)
                <tr>
                    <td class="kode-cell">{{ $mk['kode'] ?? '-' }}</td>
                    <td class="nama-cell">{{ $mk['nama'] ?? '-' }}</td>
                    <td>
                        @if(isset($mk['metode']) && $mk['metode'] != '-')
                            <span class="metode-badge" style="background: #d1fae5; color: #065f46;">
                                {{ $mk['metode'] }}
                            </span>
                        @else
                            <span style="color: #9ca3af;">-</span>
                        @endif
                    </td>
                    <td>{{ $mk['partisipasi'] ?? '-' }}</td>
                    <td>{{ $mk['proyek'] ?? '-' }}</td>
                    <td>{{ $mk['kuis'] ?? '-' }}</td>
                    <td>{{ $mk['tugas'] ?? '-' }}</td>
                    <td>{{ $mk['uts'] ?? '-' }}</td>
                    <td>{{ $mk['uas'] ?? '-' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="empty-state">
        <div class="empty-state-icon">📋</div>
        <h3 style="font-size: 20px; font-weight: 600; color: #374151; margin-bottom: 8px;">
            Belum ada data
        </h3>
        <p style="font-size: 14px; color: #9ca3af;">
            Silakan pilih semester dan departemen untuk melihat data.
        </p>
    </div>
    @endif
</div>
@endsection
