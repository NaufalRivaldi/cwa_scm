<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\SupplierRequest;

use App\Supplier;
use App\Wilayah;
use App\Barang;
use App\Supply;

class SupplierController extends Controller
{
    public function index(){
        $data['supplier'] = Supplier::orderBy('kode', 'asc')->get();

        return view('page.supplier.index', $data);
    }

    public function view($id){
        $data['supplier'] = Supplier::find($id);
        $data['barang'] = Supply::where('supplierId', $data['supplier']->id)->get();

        return view('page.supplier.view', $data);
    }

    public function form($id = null){
        if(empty($id)){
            $data['supplier'] = (object)[
                'id' => '',
                'kode' => '',
                'nama' => '',
                'tax' => '',
                'alamat' => '',
                'telp' => '',
                'fax' => '',
                'email' => '',
                'kredit' => '',
                'pic' => '',
                'wilayahId' => ''
            ];
        }else{
            $data['supplier'] = Supplier::find($id);
        }

        return view('page.supplier.form', $data);
    }

    public function store(SupplierRequest $request){
        Supplier::create([
            'kode' => $request->kode,
            'nama' => $request->nama,
            'tax' => $request->tax,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'fax' => $request->fax,
            'email' => $request->email,
            'kredit' => $request->kredit,
            'pic' => $request->pic,
            'wilayahId' => $request->wilayahId
        ]);

        return redirect()->route('supplier.index')->with('success', 'Data berhasil disimpan.');
    }

    public function update(SupplierRequest $request){
        $data = Supplier::find($request->id);
        $data->kode = $request->kode;
        $data->nama = $request->nama;
        $data->tax = $request->tax;
        $data->alamat = $request->alamat;
        $data->telp = $request->telp;
        $data->fax = $request->fax;
        $data->email = $request->email;
        $data->kredit = $request->kredit;
        $data->pic = $request->pic;
        $data->wilayahId = $request->wilayahId;
        $data->save();

        return redirect()->route('supplier.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(Request $request){
        $data = Supplier::find($request->id);
        $data->delete();
    }

    public function loadData(Request $request){
        if($request->has('q')){
            $cari = $request->q;
        }else{
            $cari = '';
        }

        $data = Wilayah::where('nama', 'like', '%'.$cari.'%')->get();
        return response()->json($data);
    }
}
