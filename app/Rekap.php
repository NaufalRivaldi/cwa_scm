<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekap extends Model
{
    protected $table = 'rekap';
    protected $guarded = [];

    // fk
    public function detailPo(){
        return $this->belongsTo('App\detailPO', 'detailPoId');
    }
}
