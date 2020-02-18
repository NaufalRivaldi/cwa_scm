<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Wilayah extends Model
{
    protected $table = 'wilayah';
    protected $fillable = [
        'nama', 'keterangan'
    ];

    public $timestamps = false;

    // fk
    public function supplier(){
        return $this->hasMany('App\Supplier', 'wilayahId');
    }

    public function diskon(){
        return $this->hasMany('App\diskon', 'wilayahId');
    }
}
