<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Merk extends Model
{
    protected $table = 'merk';
    protected $fillable = [
        'kodeMerk', 'nama'
    ];

    public $timestamps = false;

    // fk
    public function barang(){
        return $this->hasMany('App\Barang', 'merkId');
    }
}
