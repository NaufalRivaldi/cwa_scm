<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Harga extends Model
{
    protected $table = 'harga';
    protected $fillable = [
        'barangId', 'wilayahId', 'harga'
    ];
    protected $primaryKey = ['barangId', 'wilayahId'];

    // fk
    public function barang(){
        return $this->belongsTo('App\Barang', 'barangId');
    }

    public function wilayah(){
        return $this->belongsTo('App\Wilayah', 'wilayahId');
    }
}
