<?php

namespace App\Imports;

use App\Supply;
use App\Barang;
use App\Supplier;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class HargaImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */

    public function __construct(){

        $this->i = 1;
    }

    public function model(array $row)
    {
        $barang = Barang::where('kodeBarang', $row['kodebarang'])->first();
        $supplier = Supplier::where('kode', $row['kodesupplier'])->first();
        $this->i += 1;
        if(!empty($barang)){
            if(!empty($supplier)){
                $data = Supply::where('barangId', $barang->id)->where('supplierId', $supplier->id)->first();
                if(empty($data)){
                    return new Supply([
                        'barangId' => $barang->id,
                        'supplierId' => $supplier->id,
                        'harga' => $row['harga'],
                        'diskon' => $row['diskon']
                    ]);
                }else{
                    $data->harga = $row['harga'];
                    $data->diskon = $row['diskon'];
                    $data->save();
                }
            }else{
                echo 'Supplier dengan kode: '.$row['kodesupplier'].' tidak ada disistem, masukkan terlebih dahulu. <a href="'.route('barang.index').'">kembali</a>.';
                die();
                // return redirect()->route('barang.index')->with('danger', 'Supplier kode: '.$row['kodesupplier'].' belum ada disistem, masukan terlebih dahulu.');
            }
        }else{
            dd($this->i);
            echo 'Barang dengan kode: '.$row['kodebarang'].' tidak ada disistem, masukkan terlebih dahulu. <a href="'.route('barang.index').'">kembali</a>.';
            die();
            // return redirect()->route('barang.index')->with('danger', 'Barang kode: '.$row['kodebarang'].' belum ada disistem, masukan terlebih dahulu atau update data master.');
        }
    }

    public function startRow(): int{
        return 2;
    }
}
