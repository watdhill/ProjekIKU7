@extends('layouts.app')

@section('title', 'Input Mata Kuliah')

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<style>
    .form-container {
        max-width: 900px;
        margin: 0 auto;
    }
    .form-card {
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.1);
        padding: 40px;
        margin-top: 20px;
    }
    .form-title {
        font-size: 28px;
        font-weight: 700;
        color: #1f2937;
        margin-bottom: 8px;
        text-align: center;
    }
    .form-subtitle {
        font-size: 14px;
        color: #6b7280;
        margin-bottom: 32px;
        text-align: center;
    }
    .form-section {
        margin-bottom: 32px;
        padding: 24px;
        background: #f9fafb;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
    }
    .form-section-title {
        font-size: 16px;
        font-weight: 600;
        color: #374151;
        margin-bottom: 20px;
        padding-bottom: 12px;
        border-bottom: 2px solid #e5e7eb;
    }
    .form-row {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
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
    .form-select, .form-control {
        width: 100%;
        padding: 12px 16px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        color: #1f2937;
        background-color: #ffffff;
        transition: all 0.2s ease;
        appearance: none;
    }
    .form-select {
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' viewBox='0 0 12 12'%3E%3Cpath fill='%23374151' d='M6 9L1 4h10z'/%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right 16px center;
        padding-right: 40px;
    }
    .form-select:focus, .form-control:focus {
        outline: none;
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
    }
    .form-select:hover, .form-control:hover {
        border-color: #9ca3af;
    }
    .matakuliah-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .matakuliah-table thead {
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
    }
    .matakuliah-table th {
        padding: 16px;
        text-align: center;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .matakuliah-table td {
        padding: 16px;
        border-bottom: 1px solid #e5e7eb;
        text-align: center;
        color: #374151;
    }
    .matakuliah-table tbody tr {
        transition: all 0.2s ease;
    }
    .matakuliah-table tbody tr:hover {
        background: #f9fafb;
    }
    .matakuliah-table tbody tr:last-child td {
        border-bottom: none;
    }
    .matakuliah-table input[type="radio"] {
        width: 20px;
        height: 20px;
        cursor: pointer;
        accent-color: #2563eb;
    }
    .komponen-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        background: #ffffff;
        border-radius: 12px;
        overflow: hidden;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }
    .komponen-table thead {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
    }
    .komponen-table th {
        padding: 16px;
        text-align: center;
        font-weight: 600;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }
    .komponen-table td {
        padding: 16px;
        border-bottom: 1px solid #e5e7eb;
    }
    .komponen-table tbody tr:last-child td {
        border-bottom: none;
    }
    .komponen-table .komponen-name {
        font-weight: 600;
        color: #374151;
        padding-left: 24px;
    }
    .komponen-table input[type="number"] {
        width: 100px;
        padding: 10px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        text-align: center;
        font-size: 15px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .komponen-table input[type="number"]:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
    .total-info {
        font-size: 18px;
        font-weight: 700;
        padding: 16px 24px;
        border-radius: 8px;
        margin-top: 24px;
        text-align: center;
        transition: all 0.3s ease;
    }
    .total-info.success {
        background: #d1fae5;
        color: #065f46;
        border: 2px solid #10b981;
    }
    .total-info.error {
        background: #fee2e2;
        color: #991b1b;
        border: 2px solid #ef4444;
    }
    .btn-simpan {
        width: 100%;
        background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
        color: #ffffff;
        font-weight: 600;
        font-size: 16px;
        padding: 16px 24px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
        margin-top: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .btn-simpan:hover:not(:disabled) {
        background: linear-gradient(135deg, #1d4ed8 0%, #1e40af 100%);
        box-shadow: 0 4px 6px rgba(37, 99, 235, 0.4);
        transform: translateY(-1px);
    }
    .btn-simpan:active:not(:disabled) {
        transform: translateY(0);
        box-shadow: 0 2px 4px rgba(37, 99, 235, 0.3);
    }
    .btn-simpan:disabled {
        background: #9ca3af;
        cursor: not-allowed;
        box-shadow: none;
    }
    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    @keyframes fadeIn {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .empty-state {
        text-align: center;
        padding: 40px;
        color: #6b7280;
    }
    .empty-state-icon {
        font-size: 48px;
        margin-bottom: 16px;
    }
    .btn-tambah {
        background: linear-gradient(135deg, #10b981 0%, #059669 100%);
        color: #ffffff;
        font-weight: 600;
        font-size: 14px;
        padding: 10px 16px;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.2s ease;
        box-shadow: 0 2px 4px rgba(16, 185, 129, 0.3);
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .btn-tambah:hover {
        background: linear-gradient(135deg, #059669 0%, #047857 100%);
        box-shadow: 0 4px 6px rgba(16, 185, 129, 0.4);
        transform: translateY(-1px);
    }
    .btn-hapus-komponen {
        background: #ef4444;
        color: #ffffff;
        border: none;
        padding: 6px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 13px;
        font-weight: 600;
        transition: all 0.2s ease;
    }
    .btn-hapus-komponen:hover {
        background: #dc2626;
    }
    .warning-box {
        background: #fef3c7;
        border: 2px solid #f59e0b;
        border-radius: 8px;
        padding: 16px;
        margin-top: 16px;
        color: #92400e;
    }
    .warning-box strong {
        display: block;
        margin-bottom: 8px;
        font-size: 16px;
    }
    .warning-box p {
        margin: 0;
        font-size: 14px;
    }
    .komponen-table input[type="text"] {
        width: 200px;
        padding: 10px;
        border: 1.5px solid #e5e7eb;
        border-radius: 8px;
        font-size: 15px;
        transition: all 0.2s ease;
    }
    .komponen-table input[type="text"]:focus {
        outline: none;
        border-color: #10b981;
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
    }
</style>

<div class="form-container">
    <div class="form-card">
        <h1 class="form-title">Input Mata Kuliah</h1>
        <p class="form-subtitle">Pilih fakultas, departemen, dan semester untuk menginput mata kuliah</p>

        {{-- Form Filter --}}
        <div class="form-section">
            <h3 class="form-section-title">📋 Filter Data</h3>
            <div class="form-row">
                <div class="form-group">
                    <label for="fakultas" class="form-label">
                        Fakultas
                        <span class="required">*</span>
                    </label>
                <select id="fakultas" class="form-select">
                    <option value="">Pilih Fakultas</option>
                    @foreach($fakultasList as $f)
                        <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
                    @endforeach
                </select>
            </div>

                <div class="form-group">
                    <label for="departemen" class="form-label">
                        Departemen
                        <span class="required">*</span>
                    </label>
                <select id="departemen" class="form-select">
                    <option value="">Pilih Departemen</option>
                </select>
            </div>

            <div class="form-group">
                    <label for="semester" class="form-label">
                        Semester
                        <span class="required">*</span>
                    </label>
                    <select id="semester" class="form-select">
                    <option value="">Pilih Semester</option>
                    <option value="1">Semester 1</option>
                    <option value="2">Semester 2</option>
                    <option value="3">Semester 3</option>
                    <option value="4">Semester 4</option>
                        <option value="5">Semester 5</option>
                        <option value="6">Semester 6</option>
                        <option value="7">Semester 7</option>
                        <option value="8">Semester 8</option>
                </select>
            </div>
            </div>
        </div>

            {{-- Daftar Mata Kuliah --}}
            <div id="daftar-mk" class="mt-4"></div>

        {{-- Klaim Metode --}}
        <div id="klaim-metode" class="fade-in" style="display:none;">
            <div class="form-section">
                <h3 class="form-section-title">🎓 Klaim Metode Pembelajaran</h3>
                <div class="form-group">
                    <label for="metode" class="form-label">
                        Metode Pembelajaran
                        <span class="required">*</span>
                    </label>
                    <select id="metode" class="form-select" required>
                        <option value="">Pilih Metode</option>
                        <option value="PjBL">Project Based Learning (PjBL)</option>
                        <option value="CBL">Case Based Learning (CBL)</option>
                        <option value="CBM">Case Based Method (CBM)</option>
                        <option value="Biasa">Metode Biasa</option>
                    </select>
                </div>
                <button id="btn-simpan-metode" class="btn-simpan" style="margin-top: 16px;">
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Metode
                </button>
            </div>
        </div>

            {{-- Komponen Penilaian --}}
        <div id="komponen-penilaian" class="fade-in" style="display:none;">
            <div class="form-section">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid #e5e7eb;">
                    <h3 class="form-section-title" style="margin: 0;">📊 Komponen Penilaian</h3>
                    <button id="btn-tambah-komponen" class="btn-tambah" type="button">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                        </svg>
                        Tambah Komponen
                    </button>
                </div>
                <div style="overflow-x: auto;">
                    <table class="komponen-table" id="komponen-tbody">
                        <thead>
                            <tr>
                                <th style="text-align: left;">Komponen</th>
                                <th>Persentase (%)</th>
                                <th width="80">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="komponen-list">
                            <!-- Komponen akan ditambahkan secara dinamis -->
                        </tbody>
                    </table>
                </div>
                
                <div id="total-info" class="total-info error">
                    <strong>⚠️ PERINGATAN:</strong> Total harus tepat 100%. Total saat ini: <span id="total-value">0</span>%
                </div>
                
                <div id="warning-message" class="warning-box" style="display:none;">
                    <strong>⚠️ Data tidak dapat disimpan!</strong>
                    <p>Total persentase harus tepat 100% untuk dapat menyimpan data.</p>
                </div>

                {{-- Input Dokumen --}}
                <div class="form-group" style="margin-top: 32px; padding-top: 24px; border-top: 2px solid #e5e7eb;">
                    <h3 class="form-section-title" style="margin-bottom: 20px;">📄 Upload Dokumen</h3>
                    <label for="dokumen" class="form-label">
                        Upload Dokumen Pendukung
                        <span class="required">*</span>
                    </label>
                    <input type="file" 
                           id="dokumen" 
                           name="dokumen" 
                           class="form-control" 
                           accept=".pdf,.doc,.docx"
                           required
                           style="padding: 12px;">
                    <p class="form-help">Format yang diperbolehkan: PDF, DOC, DOCX (Maks. 5MB)</p>
                    
                    <div id="dokumen-preview" style="margin-top: 16px; display: none;">
                        <div style="display: flex; align-items: center; gap: 12px; padding: 12px; background: #f9fafb; border-radius: 8px;">
                            <svg width="24" height="24" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: #2563eb;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <span id="dokumen-name" style="flex: 1; font-weight: 600; color: #374151;"></span>
                            <button type="button" id="btn-hapus-dokumen" style="background: #ef4444; color: white; border: none; padding: 6px 12px; border-radius: 6px; cursor: pointer;">
                                Hapus
                            </button>
                        </div>
                    </div>
                </div>
                
                <button id="btn-simpan" class="btn-simpan" disabled>
                    <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Simpan Data
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
const fakultas = document.getElementById('fakultas');
const departemen = document.getElementById('departemen');
const semester = document.getElementById('semester');
const daftarMK = document.getElementById('daftar-mk');
const klaimMetodeContainer = document.getElementById('klaim-metode');
const komponenContainer = document.getElementById('komponen-penilaian');
const btnSimpan = document.getElementById('btn-simpan');
const btnSimpanMetode = document.getElementById('btn-simpan-metode');
const totalInfo = document.getElementById('total-info');
const totalValue = document.getElementById('total-value');
const warningMessage = document.getElementById('warning-message');
const komponenList = document.getElementById('komponen-list');
const metodeSelect = document.getElementById('metode');
const dokumenInput = document.getElementById('dokumen');
const dokumenPreview = document.getElementById('dokumen-preview');
const dokumenName = document.getElementById('dokumen-name');

let selectedMataKuliahId = null;
let metodeSaved = false;
let komponenCounter = 0;

// Komponen default
const defaultKomponen = ['Partisipasi', 'Proyek', 'Kuis', 'Tugas', 'UTS', 'UAS'];

// Inisialisasi komponen default
defaultKomponen.forEach(komp => {
    addKomponen(komp);
});

// === Ambil Departemen saat Fakultas dipilih ===
fakultas.addEventListener('change', function() {
    departemen.innerHTML = '<option value="">Pilih Departemen</option>';
    daftarMK.innerHTML = '';
    klaimMetodeContainer.style.display = 'none';
    komponenContainer.style.display = 'none';
    btnSimpan.disabled = true;
    metodeSaved = false;
    selectedMataKuliahId = null;

    if(!this.value) return;

    fetch(`/departemen/${this.value}`)
        .then(res => res.json())
        .then(data => {
            data.forEach(d => {
                const option = document.createElement('option');
                option.value = d.id;
                option.textContent = d.nama_departemen;
                departemen.appendChild(option);
            });
        });
});

// === Load Mata Kuliah saat Departemen & Semester dipilih ===
function loadMataKuliah() {
    daftarMK.innerHTML = '';
    klaimMetodeContainer.style.display = 'none';
    komponenContainer.style.display = 'none';
    btnSimpan.disabled = true;
    metodeSaved = false;
    selectedMataKuliahId = null;

    if (departemen.value && semester.value) {
        fetch(`/matkul/${departemen.value}/${semester.value}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    daftarMK.innerHTML = `
                        <div class="form-section">
                            <div class="empty-state">
                                <div class="empty-state-icon">📚</div>
                                <h4 style="color: #374151; margin-bottom: 8px;">Tidak ada mata kuliah</h4>
                                <p>Belum ada mata kuliah untuk semester ini</p>
                            </div>
                        </div>`;
                    return;
                }

                let html = `
                    <div class="form-section fade-in">
                        <h3 class="form-section-title">📖 Daftar Mata Kuliah</h3>
                        <div style="overflow-x: auto;">
                            <table class="matakuliah-table">
                                <thead>
                                    <tr>
                                    <th>Pilih</th>
                                    <th>Kode</th>
                                        <th>Nama Mata Kuliah</th>
                                    <th>SKS</th>
                                </tr>
                            </thead>
                            <tbody>`;
                data.forEach(mk => {
                    html += `
                        <tr>
                            <td>
                                <input type="radio" name="pilih-mk" value="${mk.id}">
                            </td>
                            <td style="font-weight: 600; color: #2563eb;">${mk.kode_matkul}</td>
                            <td style="text-align: left; padding-left: 24px;">${mk.nama_matkul}</td>
                            <td>${mk.sks}</td>
                        </tr>`;
                });
                html += `</tbody></table></div></div>`;
                daftarMK.innerHTML = html;

                // Event saat radio dipilih
                document.querySelectorAll('input[name="pilih-mk"]').forEach(radio => {
                    radio.addEventListener('change', function() {
                        selectedMataKuliahId = this.value;
                        klaimMetodeContainer.style.display = 'block';
                        komponenContainer.style.display = 'none';
                        metodeSaved = false;
                        metodeSelect.value = '';
                        resetPersentase();
                    });
                });
            })
            .catch(error => {
                console.error('Error:', error);
                daftarMK.innerHTML = `
                    <div class="form-section">
                        <div class="empty-state">
                            <div class="empty-state-icon">⚠️</div>
                            <h4 style="color: #374151; margin-bottom: 8px;">Terjadi kesalahan</h4>
                            <p>Gagal memuat data mata kuliah</p>
                        </div>
                    </div>`;
            });
    }
}

departemen.addEventListener('change', loadMataKuliah);
semester.addEventListener('change', loadMataKuliah);

// === Simpan Metode ===
btnSimpanMetode.addEventListener('click', async function() {
    try {
        if (!metodeSelect.value) {
            alert('Harap pilih metode pembelajaran terlebih dahulu!');
            komponenContainer.style.display = 'none';
            return;
        }
        if (!selectedMataKuliahId) {
            alert('Harap pilih mata kuliah terlebih dahulu!');
            komponenContainer.style.display = 'none';
            return;
        }

        const token = document.querySelector('meta[name="csrf-token"]').content;
        const response = await fetch('{{ route("klaim.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': token,
                'Accept': 'application/json'
            },
            body: JSON.stringify({
                data: [{
                    mata_kuliah_id: selectedMataKuliahId,
                    metode: metodeSelect.value
                }]
            })
        });

        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        const data = await response.json();

        if (data.success) {
            metodeSaved = true;
            komponenContainer.style.display = 'block';
            alert('Metode pembelajaran berhasil disimpan!');
        } else {
            throw new Error(data.message || 'Gagal menyimpan metode');
        }
    } catch (error) {
        console.error('Error:', error);
        alert(error.message || 'Gagal menyimpan metode pembelajaran');
        komponenContainer.style.display = 'none';
    }
});
metodeSelect.addEventListener('change', function() {
    komponenContainer.style.display = 'none';
    metodeSaved = false;
    resetPersentase();
});

// === Tambah Komponen ===
document.getElementById('btn-tambah-komponen').addEventListener('click', function() {
    addKomponen('');
});

function addKomponen(nama = '') {
    komponenCounter++;
    const row = document.createElement('tr');
    row.dataset.komponenId = komponenCounter;
    row.innerHTML = `
        <td>
            <input type="text" 
                   class="komponen-nama" 
                   placeholder="Nama Komponen"
                   value="${nama}"
                   style="width: 100%;">
        </td>
        <td style="text-align: center;">
            <input type="number" 
                   class="presentase" 
                   min="0" 
                   max="100" 
                   value="0"
                   step="1">
        </td>
        <td style="text-align: center;">
            <button type="button" class="btn-hapus-komponen" onclick="hapusKomponen(${komponenCounter})">
                Hapus
            </button>
        </td>
    `;
    komponenList.appendChild(row);

    // Event listener untuk input presentase
    row.querySelector('.presentase').addEventListener('input', updateTotal);
}

// === Hapus Komponen ===
window.hapusKomponen = function(id) {
    const row = document.querySelector(`tr[data-komponen-id="${id}"]`);
    if (row) {
        row.remove();
        updateTotal();
    }
}

// === Reset Persentase Komponen ===
function resetPersentase() {
    document.querySelectorAll('.presentase').forEach(input => input.value = 0);
    updateTotal();
}

// === Hitung Total Persentase ===
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('presentase')) {
        updateTotal();
    }
});

function updateTotal() {
    let total = 0;
    document.querySelectorAll('.presentase').forEach(input => {
        total += parseInt(input.value || 0);
    });

    totalValue.textContent = total;

    if (total === 100) {
        totalInfo.innerHTML = `<strong>✅ Valid:</strong> Total tepat 100%`;
        totalInfo.className = 'total-info success';
        warningMessage.style.display = 'none';
        btnSimpan.disabled = false;
    } else if (total > 100) {
        totalInfo.innerHTML = `<strong>⚠️ PERINGATAN:</strong> Total melebihi 100%. Total saat ini: <span id="total-value">${total}</span>%`;
        totalInfo.className = 'total-info error';
        warningMessage.style.display = 'block';
        btnSimpan.disabled = true;
    } else {
        totalInfo.innerHTML = `<strong>⚠️ PERINGATAN:</strong> Total kurang dari 100%. Total saat ini: <span id="total-value">${total}</span>%`;
        totalInfo.className = 'total-info error';
        warningMessage.style.display = 'block';
        btnSimpan.disabled = true;
    }
}

// === Upload Dokumen ===
dokumenInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        // Validasi ukuran file (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file maksimal 5MB!');
            this.value = '';
            return;
        }

        // Validasi tipe file
        const allowedTypes = ['application/pdf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'];
        if (!allowedTypes.includes(file.type)) {
            alert('Format file tidak diperbolehkan! Hanya PDF, DOC, atau DOCX.');
            this.value = '';
            return;
        }

        dokumenName.textContent = file.name;
        dokumenPreview.style.display = 'block';
    }
});

document.getElementById('btn-hapus-dokumen').addEventListener('click', function() {
    dokumenInput.value = '';
    dokumenPreview.style.display = 'none';
});

// === Submit Form ===
btnSimpan.addEventListener('click', function(e) {
    e.preventDefault();
    
    if (!metodeSaved) {
        alert('⚠️ Harap simpan metode pembelajaran terlebih dahulu!');
        return false;
    }

    const total = Array.from(document.querySelectorAll('.presentase')).reduce((sum, input) => {
        return sum + parseInt(input.value || 0);
    }, 0);

    if (total !== 100) {
        alert('⚠️ Total persentase harus tepat 100%! Total saat ini: ' + total + '%');
        warningMessage.scrollIntoView({ behavior: 'smooth', block: 'center' });
        return false;
    }

    if (!dokumenInput.files[0]) {
        alert('⚠️ Harap upload dokumen pendukung!');
        dokumenInput.focus();
        return false;
    }

    // Kumpulkan data komponen
    const komponenData = [];
    document.querySelectorAll('#komponen-list tr').forEach(row => {
        const nama = row.querySelector('.komponen-nama').value.trim();
        const presentase = row.querySelector('.presentase').value;
        if (nama && presentase > 0) {
            komponenData.push({
                nama: nama,
                presentase: parseInt(presentase)
            });
        }
    });

    // Buat FormData untuk submit
    const formData = new FormData();
    formData.append('_token', '{{ csrf_token() }}');
    formData.append('mata_kuliah_id', selectedMataKuliahId);
    formData.append('metode', metodeSelect.value); // Pastikan metode terkirim
    // Sertakan data filter agar controller dapat mengarahkan kembali ke rekap dengan filter yang sama
    formData.append('fakultas', fakultas.value || '');
    formData.append('departemen', departemen.value || '');
    formData.append('semester', semester.value || '');
    formData.append('komponen_data', JSON.stringify(komponenData));
    formData.append('dokumen', dokumenInput.files[0]);

    // Submit menggunakan fetch
    fetch('{{ route("matkul.store") }}', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (response.redirected) {
            window.location.href = response.url;
            return;
        }
        return response.json();
    })
    .then(data => {
        if (data && data.success) {
            alert('Data berhasil disimpan!');
            window.location.href = data.redirect || '{{ route("matkul.index") }}';
        } else if (data && data.errors) {
            let errorMsg = 'Terjadi kesalahan:\n';
            for (let key in data.errors) {
                errorMsg += '- ' + data.errors[key][0] + '\n';
            }
            alert(errorMsg);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Terjadi kesalahan saat menyimpan data');
    });
});
</script>
@endpush
