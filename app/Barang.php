<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = [
        'kodeBarang', 'nama', 'base', 'harga', 'berat', 'supplierId', 'merkId'
    ];

    public $timestamps = false;

    // fk
    public function diskon(){
        return $this->hasMany('App\Diskon', 'barangId');
    }

    public function detailPO(){
        return $this->hasMany('App\DetailPO', 'barangId');
    }

    public function supplier(){
        return $this->belongsTo('App\Supplier', 'supplierId');
    }

    public function merk(){
        return $this->belongsTo('App\Merk', 'merkId');
    }

    public function harga(){
        return $this->hasMany('App\Harga', 'barangId');
    }
}
