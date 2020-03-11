<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BarangRequest;

use App\Barang;
use App\Supplier;
use App\Merk;
use App\Supply;

class BarangController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['barang'] = Barang::orderBy('kodeBarang', 'asc')->get();

        return view('page.barang.index', $data);
    }

    public function form($id = null){
        $data['no'] = '1';
        if(empty($id)){
            $data['barang'] = (object)[
                'kodeBarang' => '',
                'nama' => '',
                'base' => '',
                'berat' => '',
                'merkId' => '',
            ];
        }else{
            $data['barang'] = Barang::find($id);
        }
        $data['supplier'] = Supplier::orderBy('nama', 'asc')->get();

        return view('page.barang.form', $data);
    }

    public function view($id){
        $data['barang'] = Barang::find($id);

        return view('page.barang.view', $data);
    }

    public function store(BarangRequest $request){
        Barang::create([
            'kodeBarang' => $request->kodeBarang,
            'nama' => $request->nama,
            'base' => $request->base,
            'berat' => $request->berat,
            'merkId' => $request->merkId
        ]);

        $barang = Barang::orderBy('id', 'desc')->first();

        for($i=0; $i<count($request->supplierId); $i++){
            // echo $request->diskon[$i];
            Supply::create([
                'barangId' => $barang->id,
                'supplierId' => $request->supplierId[$i],
                'harga' => $request->harga[$i],
                'diskon' => $request->diskon[$i]
            ]);
        }

        return redirect()->route('barang.index')->with('Data berhasil disimpan.');
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

    public function loadMerk(Request $request){
        if($request->has('q')){
            $cari = $request->q;
        }else{
            $cari = '';
        }
        $data = Merk::where('nama', 'like', '%'.$cari.'%')->get();

        return response()->json($data);
    }
}
