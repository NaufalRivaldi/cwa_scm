<?php

namespace App\Imports;

use App\Barang;
use App\Merk;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

use Illuminate\Support\Facades\Session;

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
        if($row['base'] != 'BS'){
            $base = '0';
        }
        if(!empty($data)){
            if(empty($barang)){
                return new Barang([
                    'kodeBarang' => $row['kode'],
                    'nama' => $row['nama'],
                    'base' => $base,
                    'berat' => $row['berat'],
                    'kemasan' => $row['kemasan'],
                    'merkId' => $data->id,
                ]);
            }else{
                $barang->kodeBarang = $row['kode'];
                $barang->nama = $row['nama'];
                $barang->base = $base;
                $barang->berat = $row['berat'];
                $barang->kemasan = $row['kemasan'];
                $barang->merkId = $data->id;
                $barang->save();
            }
        }else{
            echo 'Merk dengan kode: '.$row['merk'].' tidak ada disistem, masukkan terlebih dahulu. <a href="'.route('barang.index').'">kembali</a>.';
        
            // redirect()->route('barang.index')->with('danger', 'Merk dengan kode: '.$row['merk'].' tidak ada disistem, masukkan terlebih dahulu.');
            // Session::put('asd', 'asd');
            // header("Location:".route('barang.index'));
            die();
        }
    }

    public function startRow(): int{
        return 2;
    }
}
