<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PO extends Model
{
    use SoftDeletes;

    protected $table = 'po';
    protected $fillable = [
        'nomer', 'tglPO', 'tglPengiriman', 'total', 'ppn', 'disc', 'grandTotal', 'status', 'userId', 'cabangId', 'supplierId'
    ];
    protected $dates = ['deleted_at'];

    public $timestamps = true;

    // fk
    public function cabang(){
        return $this->belongsTo('App\Cabang', 'cabangId');
    }
    
    public function supplier(){
        return $this->belongsTo('App\Supplier', 'supplierId');
    }

    public function user(){
        return $this->belongsTo('App\User', 'userId');
    }

    public function detailPO(){
        return $this->hasMany('App\DetailPO', 'poId');
    }
}
