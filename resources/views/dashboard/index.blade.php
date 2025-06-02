@extends('layouts.app')

@section('title', '')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-12">
            <!-- Header Section -->
            <div class="card shadow-sm mb-4">
                <div class="card-body bg-gradient-primary text-white">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2 class="mb-2">
                                Dashboard Peramalan Penjualan
                            </h2>
                            <p class="mb-0 opacity-75">
                                Aplikasi peramalan penjualan menggunakan teknologi RNN dengan layer GRU untuk analisis prediktif yang akurat
                                untuk membantu pengambilan keputusan bisnis dan perencanaan strategi pemasaran.
                            </p>
                        </div>
                        {{-- <div class="col-md-4 text-end">
                            <div class="d-inline-block p-3 bg-white bg-opacity-25 rounded-circle">
                                <i class="fas fa-brain fa-2x"></i>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>

            <!-- Info Cards Row -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-robot fa-2x text-primary"></i>
                            </div>
                            <h5 class="card-title">Model Peramalan</h5>
                            <p class="card-text text-muted">
                                Menggunakan Recurrent Neural Network (RNN) dengan layer Gated Recurrent Unit (GRU)
                            </p>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card border-0 shadow-sm h-100">
                        <div class="card-body text-center">
                            <div class="mb-3">
                                <i class="fas fa-chart-bar fa-2x text-success"></i>
                            </div>
                            <h5 class="card-title">Analisis Pola</h5>
                            <p class="card-text text-muted">
                                Menganalisis pola penjualan historis untuk mengidentifikasi tren dan musiman
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chart Section -->
            <div class="card shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-0">
                                <i class="fas fa-chart-line me-2 text-primary"></i>
                                Grafik Penjualan Bulanan per Kategori
                            </h4>
                            <small class="text-muted">Visualisasi data penjualan untuk semua kategori produk</small>
                        </div>
                        <div class="col-auto">
                            <div class="btn-group" role="group">
                                <button type="button" class="btn btn-outline-primary btn-sm active" id="lineChart">
                                    <i class="fas fa-chart-line me-1"></i>Line
                                </button>
                                <button type="button" class="btn btn-outline-primary btn-sm" id="barChart">
                                    <i class="fas fa-chart-bar me-1"></i>Bar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="position: relative; height: 400px;">
                        <canvas id="salesChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS -->
<style>
    .bg-gradient-primary {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }
    
    .card {
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
    }
    
    .card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
    }
    
    .chart-container {
        background: linear-gradient(145deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 8px;
        padding: 20px;
    }
    
    .btn-group .btn {
        border-radius: 20px !important;
        margin: 0 2px;
    }
    
    .card-header {
        background: linear-gradient(90deg, #ffffff 0%, #f8f9fa 100%) !important;
    }
    
    @media (max-width: 768px) {
        .chart-container {
            height: 300px !important;
        }
        
        .card-body.bg-gradient-primary .col-md-4 {
            margin-top: 20px;
            text-align: center !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/js/all.min.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var ctx = document.getElementById('salesChart').getContext('2d');
        var allSalesData = @json($allSalesData);
        var currentChartType = 'line';
        var salesChart;

        // Predefined color palette untuk konsistensi
        var colorPalette = [
            '#FF6B6B', '#4ECDC4', '#45B7D1', '#96CEB4', '#FFEAA7',
            '#DDA0DD', '#98D8C8', '#F7DC6F', '#BB8FCE', '#85C1E9',
            '#F8C471', '#82E0AA', '#F1948A', '#85C1E9', '#D7BDE2'
        ];
        
        function getColorByIndex(index) {
            return colorPalette[index % colorPalette.length];
        }

        function initChart() {
            // Persiapkan data untuk grafik
            var labels = [];
            var datasets = [];

            // Ambil data bulan dan tahun unik
            allSalesData.forEach(function(item) {
                labels.push("Bulan " + item.month + " - " + item.year);
            });

            // Dataset untuk total penjualan semua kategori (ALL)
            var allData = allSalesData.map(function(item) { return item.total_sales; });
            datasets.push({
                label: 'Semua Kategori (ALL)',
                data: allData,
                borderColor: '#667eea',
                backgroundColor: currentChartType === 'bar' ? 'rgba(102, 126, 234, 0.8)' : 'rgba(102, 126, 234, 0.1)',
                fill: currentChartType === 'line' ? false : true,
                borderWidth: 3,
                tension: 0.4,
                pointBackgroundColor: '#667eea',
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6,
                pointHoverRadius: 8
            });

            // Dataset untuk masing-masing kategori
            var colorIndex = 1;
            @foreach($groupedData as $category => $data)
                var categoryLabels = [];
                var categoryData = [];
                @foreach($data as $item)
                    categoryLabels.push("Bulan " + "{{ $item->month }}" + " - {{ $item->year }}");
                    categoryData.push({{ $item->total_sales }});
                @endforeach

                var currentColor = getColorByIndex(colorIndex);
                datasets.push({
                    label: '{{ $category }}',
                    data: categoryData,
                    borderColor: currentColor,
                    backgroundColor: currentChartType === 'bar' ? currentColor + 'CC' : currentColor + '1A',
                    fill: currentChartType === 'line' ? false : true,
                    borderWidth: 2,
                    tension: 0.4,
                    pointBackgroundColor: currentColor,
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 4,
                    pointHoverRadius: 6
                });
                colorIndex++;
            @endforeach

            // Destroy existing chart if exists
            if (salesChart) {
                salesChart.destroy();
            }

            // Membuat grafik baru
            salesChart = new Chart(ctx, {
                type: currentChartType,
                data: {
                    labels: labels,
                    datasets: datasets
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                usePointStyle: true,
                                padding: 20,
                                font: {
                                    size: 12,
                                    family: "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif"
                                }
                            }
                        },
                        tooltip: {
                            backgroundColor: 'rgba(0,0,0,0.8)',
                            titleColor: 'white',
                            bodyColor: 'white',
                            borderColor: '#667eea',
                            borderWidth: 1,
                            cornerRadius: 8,
                            displayColors: true,
                            callbacks: {
                                label: function(context) {
                                    return context.dataset.label + ': ' + 
                                           new Intl.NumberFormat('id-ID').format(context.parsed.y) + ' unit';
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
                            title: {
                                display: true,
                                text: 'Periode (Bulan - Tahun)',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            grid: {
                                display: true,
                                color: 'rgba(0,0,0,0.1)'
                            },
                            ticks: {
                                maxRotation: 45,
                                minRotation: 0
                            }
                        },
                        y: {
                            title: {
                                display: true,
                                text: 'Total Penjualan (Unit)',
                                font: {
                                    size: 14,
                                    weight: 'bold'
                                }
                            },
                            beginAtZero: true,
                            grid: {
                                display: true,
                                color: 'rgba(0,0,0,0.1)'
                            },
                            ticks: {
                                callback: function(value) {
                                    return new Intl.NumberFormat('id-ID').format(value);
                                }
                            }
                        }
                    },
                    interaction: {
                        intersect: false,
                        mode: 'index'
                    },
                    animation: {
                        duration: 1000,
                        easing: 'easeInOutQuart'
                    }
                }
            });
        }

        // Initialize chart
        initChart();

        // Chart type switcher
        document.getElementById('lineChart').addEventListener('click', function() {
            currentChartType = 'line';
            document.getElementById('lineChart').classList.add('active');
            document.getElementById('barChart').classList.remove('active');
            initChart();
        });

        document.getElementById('barChart').addEventListener('click', function() {
            currentChartType = 'bar';
            document.getElementById('barChart').classList.add('active');
            document.getElementById('lineChart').classList.remove('active');
            initChart();
        });
    });
</script>
@endsection