@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Sales Forecasting</h1>
    
    <div class="card">
        <div class="card-body">
            <form id="forecastForm">
                @csrf
                <div class="form-group">
                    <label for="weeks">Jumlah Minggu untuk Prediksi (1-8):</label>
                    <input type="number" class="form-control" id="weeks" name="weeks" min="1" max="8" value="1" required>
                </div>
                
                <div class="form-group">
                    <label for="category">Pilih Kategori:</label>
                    <select class="form-control" id="category" name="category">
                        <option value="all">Semua Kategori</option>
                        @foreach($categories as $category)
                            <option value="{{ $category }}">{{ $category }}</option>
                        @endforeach
                    </select>
                </div>
                
                <button type="submit" class="btn btn-primary">Generate Forecast</button>
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
    let forecastChart = null;

    forecastForm.addEventListener('submit', function(e) {
        e.preventDefault();
        
        // Tampilkan loading
        forecastResult.innerHTML = '<div class="text-center"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div><p>Generating forecast...</p></div>';
        
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
        
        // Buat konten HTML
        forecastResult.innerHTML = `
            <h3>Hasil Prediksi</h3>
            <div class="chart-container" style="position: relative; height:400px; width:100%">
                <canvas id="forecastChart"></canvas>
            </div>
            <div class="mt-3">
                <h4>Detail Prediksi</h4>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead class="thead-light">
                            <tr>
                                <th>Tanggal</th>
                                <th>Penjualan (Prediksi)</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody id="forecastTableBody">
                            ${data.forecast.dates.map((date, index) => `
                                <tr>
                                    <td>${date}</td>
                                    <td>${data.forecast.sales[index].toFixed(2)}</td>
                                    <td>Prediksi</td>
                                </tr>
                            `).join('')}
                        </tbody>
                    </table>
                </div>
            </div>
        `;
        
        // Buat chart
        const ctx = document.getElementById('forecastChart').getContext('2d');
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
                                return `${context.dataset.label}: ${context.raw.toFixed(2)}`;
                            }
                        }
                    },
                    legend: {
                        position: 'top',
                    }
                }
            }
        });
    }
});
</script>
@endsection