<?php

namespace App\Imports;

use App\Merk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MerkImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $merk = Merk::where('kodeMerk', $row['kodemerk'])->first();

        if(empty($merk)){
            return new Merk([
                'kodeMerk' => $row['kodemerk'],
                'nama' => $row['nama']
            ]);
        }else{
            $merk->kodeMerk = $row['kodemerk'];
            $merk->nama = $row['nama'];
            $merk->save();
        }
    }

    public function startRow(): int{
        return 2;
    }
}
