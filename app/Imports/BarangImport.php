<?php

namespace App\Imports;

use App\Barang;
use App\Merk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $base = '1';
        $data = Merk::where('kodeMerk', $row['merk'])->first();
        $barang = Barang::where('kodeBarang', $row['kode'])->first();
        // dd($row['base']);
        if($row['base'] != 1){
            $base = '0';
        }
        if(!empty($data) && empty($barang)){
            return new Barang([
                'kodeBarang' => $row['kode'],
                'nama' => $row['nama'],
                'base' => $base,
                'berat' => $row['berat'],
                'merkId' => $data->id,
            ]);
        }
    }

    public function startRow(): int{
        return 2;
    }
}
