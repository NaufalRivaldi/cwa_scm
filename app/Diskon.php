<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diskon extends Model
{
    protected $table = 'diskon';
    protected $fillable = [
        'wilayahId', 'barangId', 'diskon'
    ];
    protected $primaryKey = ['wilayahId', 'barangId'];

    public $timestamps = false;

    // fk
    public function wilayah(){
        return $this->belongsTo('App\Wilayah', 'wilayahId');
    }
    
    public function barang(){
        return $this->belongsTo('App\Barang', 'barangId');
    }
}
