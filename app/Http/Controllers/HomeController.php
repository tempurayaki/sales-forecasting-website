<?php

namespace App\Http\Controllers;

use App\Models\Sales;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // Ambil data total sales per bulan dan per kategori, kecuali kategori 'none'
        $salesData = Sales::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, kategori, SUM(subtotal) as total_sales')
                            ->where('kategori', '!=', 'none')  // Filter kategori yang bukan 'none'
                            ->groupBy('year', 'month', 'kategori')
                            ->orderBy('year', 'asc')  // Urutkan berdasarkan tahun secara ascending
                            ->orderBy('month', 'asc')  // Urutkan berdasarkan bulan secara ascending
                            ->get();

        // Ambil data total sales untuk semua kategori (ALL), kecuali kategori 'none'
        $allSalesData = Sales::selectRaw('YEAR(tanggal) as year, MONTH(tanggal) as month, SUM(subtotal) as total_sales')
                            ->groupBy('year', 'month')
                            ->orderBy('year', 'asc')  // Urutkan berdasarkan tahun secara ascending
                            ->orderBy('month', 'asc')  // Urutkan berdasarkan bulan secara ascending
                            ->get();

        // Mengelompokkan data berdasarkan kategori
        $groupedData = $salesData->groupBy('kategori');

        return view('dashboard.index', compact('groupedData', 'allSalesData'));
    }
}
