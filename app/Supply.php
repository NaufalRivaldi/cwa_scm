<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supply extends Model
{
    protected $table = 'supply';
    protected $fillable = [
        'barangId', 'supplierId', 'harga', 'diskon'
    ];
    // protected $primaryKey = ['barangId', 'supplierId'];

    // fk
    public function barang(){
        return $this->belongsTo('App\Barang', 'barangId');
    }

    public function supplier(){
        return $this->belongsTo('App\Supplier', 'supplierId');
    }
}
