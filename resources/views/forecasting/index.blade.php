@extends('layouts.app')

@section('title', 'Peramalan Penjualan')

@section('content')
<div class="container">
    
    <div class="card">
        <div class="card-body">
            <form id="forecastForm">
                @csrf
                <div class="row g-3 align-items-end">
                    <!-- Input Weeks -->
                    <div class="col-md-3">
                        <div class="form-group mb-0">
                            <label for="weeks" class="form-label">Jumlah Minggu (1-8):</label>
                            <input type="number" class="form-control" id="weeks" name="weeks" min="1" max="8" value="1" required>
                        </div>
                    </div>
                    
                    <!-- Input Kategori -->
                    <div class="col-md-4">
                        <div class="form-group mb-0">
                            <label for="category" class="form-label">Pilih Kategori:</label>
                            <select class="form-control" id="category" name="category">
                                <option value="all">Semua Kategori</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category }}">{{ $category }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    
                    <!-- Tombol Submit -->
                    <div class="col-md-2">
                        <button type="submit" class="btn btn-primary w-100">Generate Forecast</button>
                    </div>
                    
                    <!-- Export Button -->
                    <div class="col-md-3" id="exportButtons" style="display: none;">
                        <button type="button" class="btn btn-success text-white w-100" onclick="exportCurrentForecast('excel')">
                            <svg width="20" height="20" fill="currentColor">
                                <use xlink:href="{{ asset('vendors/@coreui/icons/svg/free.svg#cil-data-transfer-down') }}"></use>
                            </svg>
                            <i class="fas fa-file-excel"></i> Export Excel
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    
    <div id="forecastResult" class="mt-4">
        <!-- Hasil prediksi akan ditampilkan di sini -->
    </div>
</div>

<!-- Sertakan Chart.js untuk menampilkan grafik -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const forecastForm = document.getElementById('forecastForm');
    const forecastResult = document.getElementById('forecastResult');
    const exportButtons = document.getElementById('exportButtons');
    let forecastChart = null;

    forecastForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Tampilkan loading
        forecastResult.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><p>Generating forecast...</p></div>';
        
        // Sembunyikan tombol export
        exportButtons.style.display = 'none';
        
        const formData = {
            weeks: document.getElementById('weeks').value,
            category: document.getElementById('category').value,
            _token: document.querySelector('input[name="_token"]').value
        };
        
        fetch('{{ route("forecasting.get-forecast") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': formData._token
            },
            body: JSON.stringify(formData)
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                displayForecastResult(data);
                // Tampilkan tombol export setelah hasil berhasil
                exportButtons.style.display = 'block';
            } else {
                forecastResult.innerHTML = `<div class="alert alert-danger">${data.message || 'Terjadi kesalahan saat memproses prediksi'}</div>`;
            }
        })
        .catch(error => {
            forecastResult.innerHTML = `<div class="alert alert-danger">${error.message || 'Terjadi kesalahan saat memproses prediksi'}</div>`;
            console.error('Error:', error);
        });
    });

    function displayForecastResult(data) {
        // Hancurkan chart sebelumnya jika ada
        if (forecastChart) {
            forecastChart.destroy();
        }
        
        // Gabungkan data historis dan prediksi
        const allDates = [...data.historical.dates, ...data.forecast.dates];
        const allSales = [...data.historical.sales, ...data.forecast.sales];
        
        // Hitung statistik
        const historicalTotal = data.historical.sales.reduce((a, b) => a + b, 0);
        const forecastTotal = data.forecast.sales.reduce((a, b) => a + b, 0);
        const historicalAvg = historicalTotal / data.historical.sales.length;
        const forecastAvg = forecastTotal / data.forecast.sales.length;
        
        // Buat konten HTML tanpa tombol export di header
        forecastResult.innerHTML = `
            <div class="card">
                <div class="card-header">
                    <h3 class="mb-0">Hasil Prediksi</h3>
                </div>
                <div class="card-body">
                    <!-- Statistik Ringkas -->
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-primary text-white">
                                <div class="card-body text-center">
                                    <h6>Total Historis</h6>
                                    <h4>${historicalTotal.toLocaleString('id-ID')}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <h6>Total Prediksi</h6>
                                    <h4>${forecastTotal.toLocaleString('id-ID')}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <h6>Rata-rata Historis</h6>
                                    <h4>${historicalAvg.toLocaleString('id-ID', {maximumFractionDigits: 0})}</h4>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <h6>Rata-rata Prediksi</h6>
                                    <h4>${forecastAvg.toLocaleString('id-ID', {maximumFractionDigits: 0})}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Chart -->
                    <div class="chart-container" style="position: relative; height:400px; width:100%">
                        <canvas id="forecastChart"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="card mt-3">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">Detail Prediksi</h4>
                    <button class="btn btn-outline-primary btn-sm" onclick="toggleTable()">
                        <i class="fas fa-eye" id="toggleIcon"></i> <span id="toggleText">Tampilkan Tabel</span>
                    </button>
                </div>
                <div class="card-body" id="tableContainer" style="display: none;">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped">
                            <thead class="thead-dark">
                                <tr>
                                    <th class="text-center">No</th>
                                    <th class="text-center">Tanggal</th>
                                    <th class="text-end">Penjualan (Prediksi)</th>
                                    <th class="text-center">Hari</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody id="forecastTableBody">
                                ${data.forecast.dates.map((date, index) => {
                                    const dayName = new Date(date).toLocaleDateString('id-ID', { weekday: 'long' });
                                    return `
                                    <tr>
                                        <td class="text-center">${index + 1}</td>
                                        <td class="text-center">${date}</td>
                                        <td class="text-end">${data.forecast.sales[index].toLocaleString('id-ID', {maximumFractionDigits: 2})}</td>
                                        <td class="text-center">${dayName}</td>
                                        <td class="text-center">
                                            <span class="badge bg-info text-dark">Prediksi</span>
                                        </td>
                                    </tr>
                                `;}).join('')}
                            </tbody>
                            <tfoot>
                                <tr class="table-primary">
                                    <td colspan="2" class="text-end fw-bold">Total Prediksi</td>
                                    <td class="text-end fw-bold">${forecastTotal.toLocaleString('id-ID', {maximumFractionDigits: 2})}</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        `;
        
        // Buat chart setelah elemen canvas benar-benar ada di DOM
        setTimeout(() => {
            try {
                const canvas = document.getElementById('forecastChart');
                if (!canvas) {
                    throw new Error('Canvas element not found');
                }
                
                const ctx = canvas.getContext('2d');
                forecastChart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: allDates,
                        datasets: [
                            {
                                label: 'Data Historis',
                                data: data.historical.sales,
                                borderColor: 'rgb(75, 192, 192)',
                                backgroundColor: 'rgba(75, 192, 192, 0.1)',
                                tension: 0.1,
                                fill: true
                            },
                            {
                                label: 'Prediksi',
                                data: [...Array(data.historical.sales.length).fill(null), ...data.forecast.sales],
                                borderColor: 'rgb(255, 99, 132)',
                                backgroundColor: 'rgba(255, 99, 132, 0.1)',
                                borderDash: [5, 5],
                                tension: 0.1,
                                fill: true
                            }
                        ]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        scales: {
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Jumlah Penjualan'
                                },
                                ticks: {
                                    callback: function(value) {
                                        return value.toLocaleString('id-ID');
                                    }
                                }
                            },
                            x: {
                                title: {
                                    display: true,
                                    text: 'Tanggal'
                                }
                            }
                        },
                        plugins: {
                            tooltip: {
                                callbacks: {
                                    label: function(context) {
                                        return `${context.dataset.label}: ${context.raw.toLocaleString('id-ID', {maximumFractionDigits: 2})}`;
                                    }
                                }
                            },
                            legend: {
                                position: 'top',
                            }
                        }
                    }
                });
            } catch (error) {
                console.error('Error rendering chart:', error);
                forecastResult.innerHTML += `<div class="alert alert-warning mt-3">Gagal menampilkan grafik: ${error.message}</div>`;
            }
        }, 50);
    }
    
    // Function untuk toggle tabel
    window.toggleTable = function() {
        const tableContainer = document.getElementById('tableContainer');
        const toggleIcon = document.getElementById('toggleIcon');
        const toggleText = document.getElementById('toggleText');
        
        if (tableContainer.style.display === 'none') {
            tableContainer.style.display = 'block';
            toggleIcon.className = 'fas fa-eye-slash';
            toggleText.textContent = 'Sembunyikan Tabel';
        } else {
            tableContainer.style.display = 'none';
            toggleIcon.className = 'fas fa-eye';
            toggleText.textContent = 'Tampilkan Tabel';
        }
    };
    
    // Function untuk export - menggunakan parameter saat ini dari form
    window.exportCurrentForecast = function(format) {
        const weeks = document.getElementById('weeks').value;
        const category = document.getElementById('category').value;
        
        const params = new URLSearchParams({
            weeks: weeks,
            category: category,
            format: format
        });
        
        window.open(`{{ route('forecast.generate-report') }}?${params.toString()}`, '_blank');
    };
});
</script>
@endsection