<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cabang extends Model
{
    protected $table = 'cabang';
    protected $fillable = [
        'nama', 'alamat', 'telp', 'pic'
    ];

    public $timestamps = false;

    // fk
    public function po(){
        return $this->hasMany('App\PO', 'cabangId');
    }
}
