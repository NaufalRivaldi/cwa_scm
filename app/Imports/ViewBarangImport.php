<?php

namespace App\Imports;

use App\View\Barang;
use App\Barang as vwBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ViewBarangImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        // dd($row);
        $data = vwBarang::where('kodeBarang', $row['kode'])->first();

        if(!empty($data)){
            return new Barang([
                'barangId' => $data->id,
                'order' => $row['order']
            ]);
        }
    }

    public function startRow(): int{
        return 2;
    }
}
