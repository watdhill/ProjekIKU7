@extends('layouts.app')

@section('title', 'Input Metode Pembelajaran (IKU 7)')

@section('content')
<div class="container py-4">
    <h1 class="mb-4">Input Metode Pembelajaran (IKU 7)</h1>

    {{-- Dropdown Fakultas --}}
    <div class="mb-3">
        <label for="fakultas" class="form-label fw-bold">Fakultas</label>
        <select id="fakultas" class="form-select">
            <option value="">Pilih Fakultas</option>
            @foreach($fakultasList as $f)
                <option value="{{ $f->id }}">{{ $f->nama_fakultas }}</option>
            @endforeach
        </select>
    </div>

    {{-- Dropdown Departemen --}}
    <div class="mb-3">
        <label for="departemen" class="form-label fw-bold">Departemen</label>
        <select id="departemen" class="form-select">
            <option value="">Pilih Departemen</option>
        </select>
    </div>

    {{-- Dropdown Semester --}}
    <div class="mb-4">
        <label for="semester" class="form-label fw-bold">Semester</label>
        <select id="semester" class="form-select">
            <option value="">Pilih Semester</option>
            <option value="Ganjil 2025">Ganjil 2025</option>
            <option value="Genap 2025">Genap 2025</option>
        </select>
    </div>

    {{-- Daftar Mata Kuliah --}}
    <div id="daftar-mk" class="mt-4"></div>
</div>
@endsection

@push('scripts')
<script>
const fakultas = document.getElementById('fakultas');
const departemen = document.getElementById('departemen');
const semester = document.getElementById('semester');
const daftarMK = document.getElementById('daftar-mk');

// Ambil departemen saat fakultas dipilih
fakultas.addEventListener('change', function() {
    departemen.innerHTML = '<option value="">Pilih Departemen</option>';
    daftarMK.innerHTML = '';

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

// Load matakuliah saat departemen & semester dipilih
function loadMataKuliah(){
    daftarMK.innerHTML = '';

    if(departemen.value && semester.value){
        fetch(`/matkul/${departemen.value}/${semester.value}`)
            .then(res => res.json())
            .then(data => {
                if (data.length === 0) {
                    daftarMK.innerHTML = '<p class="text-muted">Belum ada mata kuliah untuk departemen & semester ini.</p>';
                    return;
                }

                let html = `
                    <table class="table table-bordered align-middle">
                        <thead class="table-secondary">
                            <tr>
                                <th>Kode</th>
                                <th>Nama Mata Kuliah</th>
                                <th>SKS</th>
                                <th>Metode</th>
                            </tr>
                        </thead>
                        <tbody>`;
                
                data.forEach(mk => {
                    html += `
                        <tr>
                            <td>${mk.kode_matkul}</td>
                            <td>${mk.nama_matkul}</td>
                            <td>${mk.sks}</td>
                            <td>
                                <select class="form-select metode" data-id="${mk.id}">
                                    <option value="">-</option>
                                    <option value="PjBL">PjBL</option>
                                    <option value="CBL">CBL</option>
                                </select>
                            </td>
                        </tr>`;
                });

                html += `
                        </tbody>
                    </table>
                    <div class="text-end">
                        <button id="btn-simpan" class="btn btn-primary mt-3">Simpan Metode</button>
                    </div>`;
                
                daftarMK.innerHTML = html;

                document.getElementById('btn-simpan').addEventListener('click', simpanMetode);
            });
    }
}

departemen.addEventListener('change', loadMataKuliah);
semester.addEventListener('change', loadMataKuliah);

// Simpan metode yang dipilih
function simpanMetode(){
    const data = [];
    document.querySelectorAll('.metode').forEach(sel => {
        if (sel.value) {
            data.push({
                mata_kuliah_id: sel.dataset.id,
                metode: sel.value
            });
        }
    });

    if (data.length === 0) {
        alert('Pilih setidaknya satu metode pembelajaran terlebih dahulu!');
        return;
    }

    fetch('/klaim-metode/simpan', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ data })
    })
    .then(res => res.json())
    .then(result => {
        alert(result.message);
    })
    .catch(err => {
        console.error(err);
        alert('Terjadi kesalahan saat menyimpan data.');
    });
}
</script>
@endpush
