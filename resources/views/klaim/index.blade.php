@extends('layouts.app')

@section('title', 'Daftar Klaim Metode')

@section('content')
<style>
    .page-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
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
    .btn-primary {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
    }
    .btn-primary:hover {
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
        padding: 16px 20px;
        text-align: left;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .modern-table tbody tr {
        transition: all 0.2s ease;
        border-bottom: 1px solid #e5e7eb;
    }
    .modern-table tbody tr:hover {
        background: #f9fafb;
        transform: scale(1.01);
    }
    .modern-table tbody tr:last-child {
        border-bottom: none;
    }
    .modern-table td {
        padding: 16px 20px;
        color: #374151;
    }
    .status-badge {
        display: inline-block;
        padding: 6px 12px;
        border-radius: 6px;
        font-weight: 600;
        font-size: 13px;
    }
    .status-disetujui {
        background: #d1fae5;
        color: #065f46;
    }
    .status-pending {
        background: #fef3c7;
        color: #92400e;
    }
    .status-ditolak {
        background: #fee2e2;
        color: #991b1b;
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
    <h1 class="page-title">📋 Daftar Klaim Metode Mata Kuliah</h1>
    <a href="{{ route('klaim.create') }}" class="btn-primary">
        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Klaim Baru
    </a>
</div>

<div class="table-container">
    <table class="modern-table">
        <thead>
            <tr>
                <th>Mata Kuliah</th>
                <th>Dosen</th>
                <th>Metode</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <div style="font-weight: 600; color: #1f2937; margin-bottom: 4px;">
                        Pemrograman Dasar
                    </div>
                    <div style="font-size: 13px; color: #6b7280;">IF101</div>
                </td>
                <td>
                    <div style="font-weight: 500; color: #374151;">Budi Santoso</div>
                </td>
                <td>
                    <span style="display: inline-block; padding: 6px 12px; border-radius: 6px; background: #d1fae5; color: #065f46; font-weight: 600; font-size: 13px;">
                        PjBL
                    </span>
                </td>
                <td>
                    <span class="status-badge status-disetujui">✓ Disetujui</span>
                </td>
            </tr>
            <tr>
                <td>
                    <div style="font-weight: 600; color: #1f2937; margin-bottom: 4px;">
                        Struktur Data
                    </div>
                    <div style="font-size: 13px; color: #6b7280;">IF102</div>
                </td>
                <td>
                    <div style="font-weight: 500; color: #374151;">Siti Aminah</div>
                </td>
                <td>
                    <span style="display: inline-block; padding: 6px 12px; border-radius: 6px; background: #dbeafe; color: #1e40af; font-weight: 600; font-size: 13px;">
                        CBM
                    </span>
                </td>
                <td>
                    <span class="status-badge status-pending">⏳ Pending</span>
                </td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
