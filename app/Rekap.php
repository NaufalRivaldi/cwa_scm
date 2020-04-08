<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Rekap extends Model
{
    protected $table = 'rekap';
    protected $fillable = [
        'trd', 'tdo', 'td', 'keterangan', 'detailPoId', 'created_at', 'updated_at'
    ];

    // fk
    public function detailPo(){
        return $this->belongsTo('App\detailPO', 'detailPoId');
    }
}
