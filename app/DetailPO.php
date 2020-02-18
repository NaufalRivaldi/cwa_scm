<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetailPO extends Model
{
    protected $table = 'detail_po';
    protected $fillable = [
        'poId', 'barangId', 'qty', 'satuan', 'disc'
    ];
    protected $primaryKey = ['poId', 'barangId'];

    public $timestamps = true;

    // fk
    public function barang(){
        return $this->belongsTo('App\Barang', 'barangId');
    }
    
    public function po(){
        return $this->belongsTo('App\PO', 'poId');
    }
}
