<?php

namespace App\View;

use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    protected $table = 'vw_barang';
    protected $fillable = [
        'barangId', 'order'
    ];

    public $timestamps = false;

    // fk
    public function barang(){
        return $this->belongsTo('App\Barang', 'barangId');
    }
}
