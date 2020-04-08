<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPO extends Model
{
    protected $table = 'detail_po';
    protected $fillable = [
        'poId', 'barangId', 'qty', 'satuan', 'disc', 'harga'
    ];
    // protected $primaryKey = ['poId', 'barangId'];

    public $timestamps = false;

    // fk
    public function barang(){
        return $this->belongsTo('App\Barang', 'barangId');
    }
    
    public function po(){
        return $this->belongsTo('App\PO', 'poId');
    }

    public function rekap(){
        return $this->hasMany('App\Rekap', 'detailPoId');
    }
}
