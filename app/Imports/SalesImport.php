<?php

namespace App\Imports;

use App\Models\Sales;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class SalesImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {

        // dd([
        //     'tanggal' => $row['tanggal'],
        //     'nama_produk' => $row['nama_produk'],
        //     'subtotal' => $row['subtotal'],
        //     'kategori' => $row['kategori'],
        // ]);

        $formattedDate = null;
        if (isset($row['tanggal'])) {
            try {
                // Pastikan format tanggal sesuai dengan apa yang ada di file
                $formattedDate = Carbon::instance(\PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal']))->format('Y/m/d');
            } catch (\Exception $e) {
                // Tangani error jika format tidak sesuai
                dd($e);  // Atau kirim log jika perlu
            }
        }

        return new Sales([
            'tanggal' => $formattedDate,
            'nama_produk' => $row['nama_produk'],
            'subtotal' => $row['subtotal'],
            'kategori' => $row['kategori'],
        ]);
    }
}
