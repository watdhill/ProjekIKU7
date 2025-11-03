@extends('layouts.rektorat')

@section('title','Dashboard Monitoring')

@push('styles')
<style>
.header-flex {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}
.filter-group {
    display: flex;
    gap: 12px;
    flex-wrap: wrap;
}
.filter-group select {
    padding: 10px 16px;
    border: 1.5px solid #e5e7eb;
    border-radius: 8px;
    font-size: 14px;
    color: #1f2937;
    background-color: #ffffff;
    transition: all 0.2s ease;
    min-width: 180px;
}
.filter-group select:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}
.cards {
    display: flex;
    gap: 20px;
    margin-bottom: 30px;
}
.card {
    flex: 1;
    color: #fff;
    padding: 28px;
    border-radius: 16px;
    text-align: center;
    transition: all 0.3s ease;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    position: relative;
    overflow: hidden;
}
.card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 100%);
    pointer-events: none;
}
.card:hover {
    transform: translateY(-8px);
    box-shadow: 0 8px 12px rgba(0, 0, 0, 0.15);
}
.card h2 {
    font-size: 36px;
    margin-bottom: 8px;
    font-weight: 700;
}
.card p {
    font-size: 16px;
    opacity: 0.95;
    font-weight: 500;
}
.chart-wrapper {
    display: flex;
    gap: 24px;
    background: #fff;
    border-radius: 16px;
    padding: 32px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07), 0 1px 3px rgba(0, 0, 0, 0.1);
    margin-bottom: 30px;
    opacity: 1;
    transition: opacity 0.5s ease-in-out;
}
.chart-fade-out {
    opacity: 0;
}
</style>
@endpush

@section('content')
<!-- ===================== FILTER DASHBOARD ===================== -->
<div class="header-flex">
    <h1 class="text-xl font-bold">Rekap Dashboard</h1>
    <div class="filter-group">
        <select id="semesterSelect" class="border rounded p-2">
            <option value="ganjil-2025">Ganjil 2025</option>
            <option value="genap-2025">Genap 2025</option>
            <option value="ganjil-2024">Ganjil 2024</option>
            <option value="genap-2024">Genap 2024</option>
        </select>
        <select id="fakultasSelect" class="border rounded p-2">
            <option value="all">Semua Fakultas</option>
            <option value="Fakultas A">Fakultas A</option>
            <option value="Fakultas B">Fakultas B</option>
            <option value="Fakultas C">Fakultas C</option>
            <option value="Fakultas D">Fakultas D</option>
        </select>
        <select id="prodiSelect" class="border rounded p-2">
            <option value="all">Semua Prodi</option>
            <option value="Teknik Komputer">Teknik Komputer</option>
            <option value="Sistem Informasi">Sistem Informasi</option>
            <option value="Informatika">Informatika</option>
        </select>
    </div>
</div>

<!-- ===================== KARTU RINGKASAN ===================== -->
<div class="cards">
    <div class="card" style="background:#2563eb;">
        <h2 id="total-mk" style="font-size:28px; margin:0;">320</h2>
        <p>Total Mata Kuliah</p>
    </div>
    <div class="card" style="background:#f77f00;">
        <h2 id="total-pjbl" style="font-size:28px; margin:0;">200</h2>
        <p>PjBL</p>
    </div>
    <div class="card" style="background:#008080;">
        <h2 id="total-cbm" style="font-size:28px; margin:0;">120</h2>
        <p>CBM</p>
    </div>
</div>

<!-- ===================== CHART METODE PEMBELAJARAN ===================== -->
<div class="chart-wrapper" id="chartWrapper">
    <div style="flex:1; text-align:center;">
        <canvas id="pieChart"></canvas>
    </div>
    <div style="flex:2;">
        <h3 style="font-size:16px; margin-bottom:10px; color:#333;">Presentase Metode Pembelajaran Per Fakultas / Prodi</h3>
        <canvas id="barChart"></canvas>
    </div>
</div>

<!-- ===================== FOOTER ===================== -->
<div style="margin-top:30px; padding:10px; text-align:center; color:#555; font-size:14px;">
    © 2025 MYUNAND Universitas Andalas
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// ==================== INISIALISASI ====================
const pieChartCtx = document.getElementById("pieChart");
const barChartCtx = document.getElementById("barChart");
const chartWrapper = document.getElementById('chartWrapper');

let pieChart, barChart;
const totalMKEl = document.getElementById('total-mk');
const totalPJBLEl = document.getElementById('total-pjbl');
const totalCBMEl = document.getElementById('total-cbm');

// ==================== FUNGSI ANIMASI ANGKA ====================
function animateValue(element, start, end, duration) {
    const startTime = performance.now();
    function update(currentTime) {
        const progress = Math.min((currentTime - startTime) / duration, 1);
        const value = Math.floor(start + (end - start) * progress);
        element.textContent = value;
        if (progress < 1) requestAnimationFrame(update);
    }
    requestAnimationFrame(update);
}

// ==================== FUNGSI RENDER CHART ====================
function renderCharts(fakultas, prodi) {
    chartWrapper.classList.add('chart-fade-out'); // efek fade out sebelum update

    setTimeout(() => {
        const totalMK = Math.floor(Math.random() * 100) + 250;
        const pjbl = Math.floor(Math.random() * (totalMK / 2)) + (totalMK / 2);
        const cbm = totalMK - pjbl;

        const labels = prodi !== "all"
            ? [prodi]
            : (fakultas !== "all"
                ? ["Prodi 1", "Prodi 2", "Prodi 3"]
                : ["Fakultas A", "Fakultas B", "Fakultas C", "Fakultas D"]
            );

        const pjblData = labels.map(() => Math.floor(Math.random() * 50 + 50));
        const cbmData = labels.map(() => Math.floor(Math.random() * 50 + 40));

        // animasi angka kartu
        animateValue(totalMKEl, parseInt(totalMKEl.textContent), totalMK, 800);
        animateValue(totalPJBLEl, parseInt(totalPJBLEl.textContent), pjbl, 800);
        animateValue(totalCBMEl, parseInt(totalCBMEl.textContent), cbm, 800);

        // Pie Chart
        if (pieChart) pieChart.destroy();
        pieChart = new Chart(pieChartCtx, {
            type: "pie",
            data: {
                labels: [
                    `PjBL (${((pjbl/totalMK)*100).toFixed(1)}%)`,
                    `CBM (${((cbm/totalMK)*100).toFixed(1)}%)`
                ],
                datasets: [{
                    data: [pjbl, cbm],
                    backgroundColor: ["#f77f00", "#008080"]
                }]
            },
            options: {
                responsive: true,
                animation: {
                    animateScale: true,
                    animateRotate: true,
                    duration: 1000,
                    easing: 'easeInOutQuad'
                },
                plugins: { legend: { position: 'bottom' } }
            }
        });

        // Bar Chart dengan animasi smooth
        if (barChart) barChart.destroy();
        barChart = new Chart(barChartCtx, {
            type: "bar",
            data: {
                labels: labels,
                datasets: [
                    { label: "PjBL", data: pjblData, backgroundColor: "#f77f00" },
                    { label: "CBM", data: cbmData, backgroundColor: "#008080" }
                ]
            },
            options: {
                responsive: true,
                animation: {
                    duration: 1200,
                    easing: 'easeInOutCubic'
                },
                scales: {
                    y: { beginAtZero: true, max: 100, ticks: { stepSize: 20 } }
                },
                transitions: {
                    active: {
                        animation: {
                            duration: 1200,
                            easing: 'easeInOutQuad'
                        }
                    }
                }
            }
        });

        chartWrapper.classList.remove('chart-fade-out'); // efek fade in setelah update
    }, 300); // jeda sedikit supaya transisi smooth
}

// ==================== EVENT DROPDOWN ====================
document.getElementById('semesterSelect').addEventListener('change', () => {
    const f = document.getElementById('fakultasSelect').value;
    const p = document.getElementById('prodiSelect').value;
    renderCharts(f, p);
});
document.getElementById('fakultasSelect').addEventListener('change', () => {
    const f = document.getElementById('fakultasSelect').value;
    const p = document.getElementById('prodiSelect').value;
    renderCharts(f, p);
});
document.getElementById('prodiSelect').addEventListener('change', () => {
    const f = document.getElementById('fakultasSelect').value;
    const p = document.getElementById('prodiSelect').value;
    renderCharts(f, p);
});

// ==================== LOAD AWAL ====================
renderCharts('all','all');
</script>
@endpush
