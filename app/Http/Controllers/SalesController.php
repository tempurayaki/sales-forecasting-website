<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Sales;

use App\Imports\SalesImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class SalesController extends Controller
{

    protected $sales;

    public function __construct(Sales $sales)
    {
        $this->sales = $sales;
    }

    public function index(Request $request)
    {
        $rows = Sales::paginate(10);
        return view('sales.index', compact('rows'));
    }

    public function create(Request $request)
    {
        return view('sales.add');
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'tanggal' => ['required', 'date'],
            'nama_produk' => ['required', 'string', 'min:3', 'max:2000'],
            'subtotal' => ['required', 'integer', 'min:4', 'max:1000000'],
            'kategori' => ['required', 'string', 'min:3', 'max:2000'],
        ], [
            'required' => 'Field :attribute harus diisi.'
        ]);

        $tanggal = Carbon::parse($request->input('tanggal'))->format('Y/m/d');

        $sales = $this->sales->create([
            'tanggal' => $tanggal,   // Menyimpan tanggal yang sudah diformat
            'nama_produk' => $request->input('nama_produk'),
            'subtotal' => $request->input('subtotal'),
            'kategori' => $request->input('kategori'),
        ]);
        return redirect()->route('sales')->with('success', 'Data sukses ditambahkan. ');
    }

    public function edit(Request $request, $id)
    {
        // dd($id);

        $sales = $this->sales->find($id);
        // dd($sales);
        if ($sales) {
            return view('sales.edit', compact('sales'));
        } else {
            return redirect()->route('sales')->with('failed', 'Data tidak ditemukan');
        }
    }

    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'tanggal' => ['required', 'date'],
            'nama_produk' => ['required', 'string', 'min:3', 'max:2000'],
            'subtotal' => ['required', 'integer', 'min:4', 'max:1000000'],
            'kategori' => ['required', 'string', 'min:3', 'max:2000'],
        ], [
            'required' => 'Field :attribute harus diisi.'
        ]);

        $sales = $this->sales->find($id);

        if ($sales) {
            // Perbarui data
            $sales->update([
                'tanggal' => $request->input('tanggal'),
                'nama_produk' => $request->input('nama_produk'),
                'subtotal' => $request->input('subtotal'),
                'kategori' => $request->input('kategori'),
            ]);

            return redirect()->route('sales')->with('success', 'Data sukses diedit.');
        } else {
            return redirect()->route('sales')->with('failed', 'Data tidak ditemukan');
        }
    }

    public function destroy(Request $request, $id)
    {
        $sales = $this->sales->find($id);

        if ($sales) {
            $sales->destroy($id);
            return redirect()->route('sales')->with('success', 'Data sukses dihapus');
        } else {
            return redirect()->route('sales')->with('failed', 'Data tidak ditemukan');
        }
    }

    public function upload(Request $request)
    {
        return view('sales.import');
    }

    public function import(Request $request)
    {
        // Validasi file yang di-upload
        $request->validate([
            'excel_file' => 'required|mimes:csv,xlsx', // Validasi ekstensi file Excel dan CSV
        ], [
            'excel_file.mimes' => 'File yang di-upload harus berformat Excel (xlsx) atau CSV.',
        ]);

        try {
            // Ambil file yang di-upload
            $file = $request->file('excel_file');
            
            // Tentukan delimiter untuk CSV jika menggunakan semicolon
            $delimiter = ';'; // Ganti dengan ',' jika itu pemisah yang digunakan
    
            // Jika file CSV, tentukan delimiter manual
            if ($file->getClientOriginalExtension() === 'csv') {
                Excel::filter('chunk')->import(new SalesImport, $file, null, \Maatwebsite\Excel\Excel::CSV);
                // Pindahkan file jika perlu
            } else {
                Excel::import(new SalesImport, $file);
            }
    
            return redirect()->route('sales')->with('success', 'Data berhasil diimpor!');
        } catch (\Exception $e) {
            
            return back()->with('error', 'Terjadi kesalahan saat mengimpor data: ' . $e->getMessage());
        }
    }
}
