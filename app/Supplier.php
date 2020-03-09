<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'supplier';
    protected $fillable = [
        'kode', 'nama', 'tax', 'alamat', 'telp', 'fax', 'email', 'kredit', 'pic', 'wilayahId'
    ];

    public $timestamps = false;

    // fk
    public function po(){
        return $this->hasMany('App\PO', 'supplierId');
    }

    public function barang(){
        return $this->hasMany('App\Barang', 'supplierId');
    }

    public function wilayah(){
        return $this->belongsTo('App\Wilayah', 'wilayahId');
    }
}
