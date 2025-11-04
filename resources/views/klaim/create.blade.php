@extends('layouts.app')

@section('content')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
    }
    .form-card {
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 32px;
        margin-top: 20px;
    }
    .form-title {
        font-size: 24px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
    }
    .form-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 24px;
    }
    .form-group {
        margin-bottom: 24px;
    }
    .form-label {
        display: block;
        font-size: 14px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 8px;
    }
    .form-label .required {
        color: #ef4444;
        margin-left: 4px;
    }
    .form-select {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        color: #1f2937;
        background-color: #ffffff;
        transition: all 0.2s ease;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23374151' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
    }
    .form-select:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .form-select:hover {
        border-color: #9ca3af;
    }
    .form-select option {
        padding: 8px;
    }
    .btn-submit {
        width: 100%;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        font-weight: 600;
        font-size: 16px;
        padding: 14px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
        margin-top: 8px;
    }
    .btn-submit:hover {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.4);
        transform: translateY(-1px);
    }
    .btn-submit:active {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
    }
    .btn-cancel {
        width: 100%;
        background: #ffffff;
        color: #6b7280;
        font-weight: 600;
        font-size: 16px;
        padding: 14px 24px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        margin-top: 12px;
        text-decoration: none;
        display: inline-block;
        text-align: center;
    }
    .btn-cancel:hover {
        background: #f9fafb;
        border-color: #d1d5db;
        color: #374151;
    }
    .form-help {
        font-size: 13px;
        color: #6b7280;
        margin-top: 6px;
    }
    .error-message {
        color: #ef4444;
        font-size: 13px;
        margin-top: 6px;
    }
</style>

<div class="form-container">
    <div class="form-card">
        <h1 class="form-title">Klaim Metode Mata Kuliah</h1>
        <p class="form-subtitle">Pilih mata kuliah dan metode pembelajaran yang akan digunakan</p>
        <form id="klaimForm">
            <div class="form-group">
                <label for="mata_kuliah" class="form-label">
                    Mata Kuliah
                    <span class="required">*</span>
                </label>
                <select id="mata_kuliah" name="mata_kuliah_id" class="form-select" required>
                    <option value="">-- Pilih Mata Kuliah --</option>
                    <option value="1">IF101 - Pemrograman Dasar</option>
                    <option value="2">IF102 - Struktur Data</option>
                    <option value="3">IF103 - Basis Data</option>
                </select>
                <p class="form-help">Pilih mata kuliah yang akan diklaim metodenya</p>
            </div>
            <div class="form-group">
                <label for="metode" class="form-label">
                    Metode Pembelajaran
                    <span class="required">*</span>
                </label>
                <select id="metode" name="metode" class="form-select" required>
                    <option value="">-- Pilih Metode --</option>
                    <option value="PjBL">Project Based Learning (PjBL)</option>
                    <option value="CBL">Case Based Learning (CBL)</option>
                    <option value="CBM">Case Based Method (CBM)</option>
                    <option value="Biasa">Metode Biasa</option>
                </select>
                <p class="form-help">Pilih metode pembelajaran yang akan digunakan</p>
            </div>
        </form>
        <div id="komponenFormContainer" style="display:none; margin-top:32px;"></div>
        <a href="{{ route('klaim.index') }}" class="btn-cancel">Batal</a>
        <script>
        document.getElementById('metode').addEventListener('change', function() {
            var metode = this.value;
            var mk = document.getElementById('mata_kuliah').value;
            var container = document.getElementById('komponenFormContainer');
            if(metode && mk) {
                container.style.display = 'block';
                container.innerHTML = `
                <form action="/matkul" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" name="mata_kuliah_id" value="${mk}">
                    <input type="hidden" name="metode" value="${metode}">
                    <div id="komponenList">
                        <div class="form-group">
                            <label>Nama Komponen</label>
                            <input type="text" name="komponen_data[0][nama]" class="form-control" required>
                        </div>
                        <div class="form-group">
                            <label>Persentase (%)</label>
                            <input type="number" name="komponen_data[0][presentase]" class="form-control" required>
                        </div>
                    </div>
                    <button type="button" onclick="addKomponen()" class="btn-submit" style="background:#e5e7eb;color:#2563eb;">+ Tambah Komponen</button>
                    <div class="form-group" style="margin-top:24px;">
                        <label>Upload Dokumen (PDF/DOC/DOCX)</label>
                        <input type="file" name="dokumen" accept=".pdf,.doc,.docx" required>
                    </div>
                    <button type="submit" class="btn-submit">Simpan Semua</button>
                </form>
                <script>
                var komponenIndex = 1;
                function addKomponen() {
                    var list = document.getElementById('komponenList');
                    var html = `<div class='form-group'><label>Nama Komponen</label><input type='text' name='komponen_data[${komponenIndex}][nama]' class='form-control' required></div><div class='form-group'><label>Persentase (%)</label><input type='number' name='komponen_data[${komponenIndex}][presentase]' class='form-control' required></div>`;
                    list.insertAdjacentHTML('beforeend', html);
                    komponenIndex++;
                }
                </script>
            `;
            } else {
                container.style.display = 'none';
                container.innerHTML = '';
            }
        });
        </script>
    </div>
</div>
@endsection
