<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'barang';
    protected $fillable = [
        'kodeBarang', 'nama', 'base', 'berat', 'merkId'
    ];

    public $timestamps = false;

    // fk
    public function detailPO(){
        return $this->hasMany('App\DetailPO', 'barangId');
    }

    public function merk(){
        return $this->belongsTo('App\Merk', 'merkId');
    }

    public function supply(){
        return $this->hasMany('App\Supply', 'barangId');
    }
}
