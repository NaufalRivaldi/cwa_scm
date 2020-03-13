<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PO;
use App\Supplier;
use App\Barang;

class PoController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['po'] = PO::orderBy('id', 'desc')->get();

        return view('page.po.index', $data);
    }

    public function form($id = null){
        if(empty($id)){
            $data['po'] = (object)[
                'nomer' => $this->nomerPo(),
                'tglPO' => date('Y-m-d'),
                'tglPengiriman' => '',
                'total' => '',
                'ppn' => '',
                'disc' => '',
                'grandTotal' => '',
                'status' => '',
                'userId' => '',
                'cabangId' => '',
                'supplierId' => ''
            ];
        }else{
            $data['po'] = PO::find($id);
        }

        return view('page.po.form', $data);
    }

    public function loadSupplier(Request $request){
        if($request->has('q')){
            $cari = $request->q;
        }else{
            $cari = '';
        }
        $data = Supplier::where('nama', 'like', '%'.$cari.'%')->get();

        return response()->json($data);
    }

    public function loadBarang(Request $request){
        if($request->has('q')){
            $cari = $request->q;
        }else{
            $cari = '';
        }

        $data = Barang::where('kodeBarang', 'like', '%'.$cari.'%')->orWhere('nama', 'like', '%'.$cari.'%')->get();
        return response()->json($data);
    }

    public function dataSupplier(Request $request){
       $data = Supplier::find($request->id);
        
       return response()->json($data);
    }

    public function nomerPo(){
        $nomor = '';
        $bulan = $this->romawi(date('n'));
        $tahun = date('Y');
        $key = $bulan.'/'.$tahun;

        $data = PO::where('nomer', 'like', '%'.$key.'%')->orderBy('id', 'desc')->first();
        if(empty($data)){
            $nomor = '1/WLDN-DPS/'.$bulan.'/'.$tahun;
        }else{
            $row = explode('/', $data->nomer);
            $row[0] += 1;
            $nomor = $row[0].'/'.$row[1].'/'.$row[2].'/'.$row[3];
        }

        return $nomor;
    }

    public function romawi($bulan){
        $array = array('0', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        return $array[$bulan];
    }
}
