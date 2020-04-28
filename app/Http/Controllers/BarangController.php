<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\BarangRequest;
use App\Imports\BarangImport;
use Maatwebsite\Excel\Facades\Excel;

use App\Barang;
use App\Supplier;
use App\Merk;
use App\Supply;

class BarangController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['merk'] = Merk::orderBy('nama', 'asc')->get();
        
        if($_GET){
            $merkId = $_GET['merkId'];
            $data['barang'] = Barang::where('merkId', $merkId)->orderBy('kodeBarang', 'asc')->get();
        }else{
            $data['barang'] = Barang::orderBy('kodeBarang', 'asc')->get();
        }

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
                'kemasan' => '',
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
            'kemasan' => $request->kemasan,
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

        return redirect()->route('barang.index')->with('success', 'Data berhasil disimpan.');
    }

    public function import(Request $request){
        $this->validate($request,[
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('file');
        $fileName = date('Y-m-d').'-barang.'.$file->getClientOriginalExtension();
        $file->move(public_path('import/barang'), $fileName);

        Excel::import(new BarangImport, public_path('/import/barang/'.$fileName));
        
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diimport');
    }

    public function update(BarangRequest $request){
        $data = Barang::find($request->id);
        $data->kodeBarang = $request->kodeBarang;
        $data->nama = $request->nama;
        $data->base = $request->base;
        $data->berat = $request->berat;
        $data->kemasan = $request->kemasan;
        $data->merkId = $request->merkId;
        $data->save();

        Supply::where('barangId', $request->id)->delete();
        for($i=0; $i<count($request->supplierId); $i++){
            // echo $request->diskon[$i];
            Supply::create([
                'barangId' => $request->id,
                'supplierId' => $request->supplierId[$i],
                'harga' => $request->harga[$i],
                'diskon' => $request->diskon[$i]
            ]);
        }

        return redirect()->route('barang.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(Request $request){
        $data = Barang::find($request->id);
        $data->delete();
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
