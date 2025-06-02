<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\Sales;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ForecastExport;

class SalesForecastController extends Controller
{
    // API endpoint
    protected $apiUrl = 'http://127.0.0.1:5000/predict';
    
    /**
     * Tampilkan halaman forecasting
     */
    public function index()
    {
        // Ambil daftar kategori unik (kecuali 'none')
        $categories = Sales::where('kategori', '!=', 'none')
                         ->select('kategori')
                         ->distinct()
                         ->pluck('kategori');
        
        return view('forecasting.index', compact('categories'));
    }
    
    /**
     * Ambil data historis dan buat prediksi
     */
    public function getForecast(Request $request)
    {
        $request->validate([
            'weeks' => 'required|integer|min:1|max:8',
            'category' => 'nullable|string'
        ]);
        
        // Jumlah minggu untuk prediksi
        $weeksToForecast = $request->weeks;
        $selectedCategory = $request->category;
        
        // Ambil data historis dari database
        $historicalData = $this->getHistoricalData($selectedCategory);
        
        if (count($historicalData['date']) < 7) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data historis harus minimal 7 hari'
            ], 400);
        }
        
        // Lakukan prediksi untuk beberapa minggu ke depan
        $forecastData = $this->generateMultiDayForecast($historicalData, $weeksToForecast * 7);
        
        if (isset($forecastData['error'])) {
            return response()->json([
                'status' => 'error',
                'message' => $forecastData['error']
            ], 500);
        }
        
        // Simpan data untuk export (optional: store in session)
        session([
            'forecast_data' => [
                'historical' => $historicalData,
                'forecast' => $forecastData,
                'category' => $selectedCategory,
                'weeks' => $weeksToForecast,
                'generated_at' => now()
            ]
        ]);
        
        return response()->json([
            'status' => 'success',
            'historical' => [
                'dates' => $historicalData['date'],
                'sales' => $historicalData['sales']
            ],
            'forecast' => [
                'dates' => $forecastData['dates'],
                'sales' => $forecastData['sales']
            ]
        ]);
    }
    
    /**
     * Export forecast data to Excel
     */
    public function exportExcel(Request $request)
    {
        $forecastData = session('forecast_data');
        
        if (!$forecastData) {
            return redirect()->back()->with('error', 'Tidak ada data prediksi untuk di-export. Silakan buat prediksi terlebih dahulu.');
        }
        
        $filename = 'sales_forecast_' . 
                   ($forecastData['category'] ?? 'all_categories') . '_' . 
                   $forecastData['weeks'] . 'weeks_' . 
                   date('Y-m-d_H-i-s') . '.xlsx';
        
        return Excel::download(new ForecastExport($forecastData), $filename);
    }
    
    /**
     * Export forecast data to CSV
     */
    public function exportCsv(Request $request)
    {
        $forecastData = session('forecast_data');
        
        if (!$forecastData) {
            return redirect()->back()->with('error', 'Tidak ada data prediksi untuk di-export. Silakan buat prediksi terlebih dahulu.');
        }
        
        $filename = 'sales_forecast_' . 
                   ($forecastData['category'] ?? 'all_categories') . '_' . 
                   $forecastData['weeks'] . 'weeks_' . 
                   date('Y-m-d_H-i-s') . '.csv';
        
        return Excel::download(new ForecastExport($forecastData), $filename, \Maatwebsite\Excel\Excel::CSV);
    }
    
    /**
     * Generate forecast report data for direct download (alternative method)
     */
    public function generateForecastReport(Request $request)
    {
        $request->validate([
            'weeks' => 'required|integer|min:1|max:8',
            'category' => 'nullable|string',
            'format' => 'required|in:excel,csv'
        ]);
        
        $weeksToForecast = $request->weeks;
        $selectedCategory = $request->category;
        $format = $request->format;
        
        // Ambil data historis dari database
        $historicalData = $this->getHistoricalData($selectedCategory);
        
        if (count($historicalData['date']) < 7) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data historis harus minimal 7 hari'
            ], 400);
        }
        
        // Lakukan prediksi
        $forecastData = $this->generateMultiDayForecast($historicalData, $weeksToForecast * 7);
        
        if (isset($forecastData['error'])) {
            return response()->json([
                'status' => 'error',
                'message' => $forecastData['error']
            ], 500);
        }
        
        // Prepare data for export
        $exportData = [
            'historical' => $historicalData,
            'forecast' => $forecastData,
            'category' => $selectedCategory,
            'weeks' => $weeksToForecast,
            'generated_at' => now()
        ];
        
        $filename = 'sales_forecast_' . 
                   ($selectedCategory ?? 'all_categories') . '_' . 
                   $weeksToForecast . 'weeks_' . 
                   date('Y-m-d_H-i-s');
        
        if ($format === 'excel') {
            return Excel::download(new ForecastExport($exportData), $filename . '.xlsx');
        } else {
            return Excel::download(new ForecastExport($exportData), $filename . '.csv', \Maatwebsite\Excel\Excel::CSV);
        }
    }
    
    /**
     * Ambil data historis dari database
     */
    private function getHistoricalData($category = null)
    {
        $query = Sales::query();
        
        // Filter berdasarkan kategori jika dipilih
        if ($category && $category !== 'all') {
            $query->where('kategori', $category);
        } else {
            $query->where('kategori', '!=', 'none');
        }
        
        // Agregasi data per hari
        $dailySales = $query->selectRaw('DATE(tanggal) as date, SUM(subtotal) as total_sales')
                           ->groupBy('date')
                           ->orderBy('date')
                           ->get();
        
        $dates = [];
        $sales = [];
        
        foreach ($dailySales as $day) {
            $dates[] = $day->date;
            $sales[] = floatval($day->total_sales);
        }
        
        return [
            'date' => $dates,
            'sales' => $sales
        ];
    }
    
    /**
     * Generate multiple days forecast
     */
    private function generateMultiDayForecast($initialData, $days)
    {
        $dates = $initialData['date'];
        $sales = $initialData['sales'];
        
        $forecastDates = [];
        $forecastSales = [];
        
        for ($i = 0; $i < $days; $i++) {
            // Data untuk prediksi hari berikutnya
            $inputData = [
                'date' => $dates,
                'sales' => $sales
            ];
            
            // Panggil API prediksi
            try {
                $response = Http::post($this->apiUrl, $inputData);
                $result = $response->json();
                
                if ($result['status'] === 'success') {
                    // Tambahkan hasil prediksi ke data
                    $forecastDates[] = $result['prediction_date'];
                    $forecastSales[] = $result['predicted_sales'];
                    
                    // Update data untuk prediksi berikutnya
                    array_shift($dates);
                    array_shift($sales);
                    $dates[] = $result['prediction_date'];
                    $sales[] = $result['predicted_sales'];
                } else {
                    return [
                        'error' => 'API error: ' . ($result['error'] ?? 'Unknown error')
                    ];
                }
            } catch (\Exception $e) {
                return [
                    'error' => 'Failed to connect to prediction API: ' . $e->getMessage()
                ];
            }
        }
        
        return [
            'dates' => $forecastDates,
            'sales' => $forecastSales
        ];
    }
}