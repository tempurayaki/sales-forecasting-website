@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3>Selamat datang di Dashboard</h3>
                    <p>Ini adalah website untuk memantau penjualan bulanan.</p>
                    <p>Grafik di bawah menunjukkan total penjualan per bulan yang diambil dari database, dengan pemisahan per kategori produk, kecuali kategori 'none'.</p>

                    <!-- Grafik Penjualan Bulanan -->
                    <div class="mt-4">
                        <h4>Grafik Penjualan Bulanan per Kategori</h4>
                        <canvas id="salesChart" width="400" height="200"></canvas>
                    </div>

                    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                    <script>
                        var ctx = document.getElementById('salesChart').getContext('2d');
                        var allSalesData = @json($allSalesData); // Data total sales (ALL)

                        // Persiapkan data untuk grafik
                        var labels = [];
                        var datasets = [];

                        // Ambil data bulan dan tahun unik dari semua kategori dan all
                        allSalesData.forEach(function(item) {
                            labels.push("Month " + item.month + ", " + item.year);  // Gabungkan bulan dan tahun
                        });

                        // Dataset untuk total penjualan semua kategori (ALL)
                        var allData = allSalesData.map(function(item) { return item.total_sales; });
                        datasets.push({
                            label: 'All Products (ALL Categories)',
                            data: allData,
                            borderColor: 'rgb(75, 192, 192)',
                            fill: false
                        });

                        // Dataset untuk masing-masing kategori
                        @foreach($groupedData as $category => $data)
                            var categoryLabels = [];
                            var categoryData = [];
                            @foreach($data as $item)
                                categoryLabels.push("Month " + "{{ $item->month }}" + ", {{ $item->year }}");
                                categoryData.push({{ $item->total_sales }});
                            @endforeach

                            datasets.push({
                                label: '{{ $category }}',
                                data: categoryData,
                                borderColor: getRandomColor(),
                                fill: false
                            });
                        @endforeach

                        // Membuat grafik dengan data yang sudah disiapkan
                        var salesChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: labels,
                                datasets: datasets
                            },
                            options: {
                                responsive: true,
                                plugins: {
                                    legend: {
                                        position: 'top',
                                    },
                                },
                                scales: {
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Bulan (Tahun)'
                                        }
                                    },
                                    y: {
                                        title: {
                                            display: true,
                                            text: 'Total Sales'
                                        },
                                        beginAtZero: true
                                    }
                                }
                            }
                        });

                        // Fungsi untuk menghasilkan warna acak untuk tiap kategori
                        function getRandomColor() {
                            var letters = '0123456789ABCDEF';
                            var color = '#';
                            for (var i = 0; i < 6; i++) {
                                color += letters[Math.floor(Math.random() * 16)];
                            }
                            return color;
                        }
                    </script>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
