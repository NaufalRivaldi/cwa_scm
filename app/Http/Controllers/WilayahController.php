<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\WilayahRequest;

use App\Wilayah;

class WilayahController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['wilayah'] = Wilayah::orderBy('nama', 'asc')->get();
        
        return view('page.wilayah.index', $data);
    }

    public function form($id = null){
        if(!empty($id)){
            $wilayah = Wilayah::find($id);
            $data['wilayah'] = (object)[
                'id' => $wilayah->id,
                'nama' => $wilayah->nama,
                'keterangan' => $wilayah->keterangan
            ];
        }else{
            $data['wilayah'] = (object)[
                'id' => '',
                'nama' => '',
                'keterangan' => ''
            ];
        }
        return view('page.wilayah.form', $data);
    }

    public function store(WilayahRequest $request){
        Wilayah::create([
            'nama' => $request->nama,
            'keterangan' => $request->keterangan
        ]);

        return redirect()->route('wilayah.index')->with('success', 'Data berhasil disimpan.');
    }

    public function update(WilayahRequest $request){
        $wilayah = Wilayah::find($request->id);
        $wilayah->nama = $request->nama;
        $wilayah->keterangan = $request->keterangan;
        $wilayah->save();

        return redirect()->route('wilayah.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(Request $request){
        $wilayah = Wilayah::find($request->id);
        $wilayah->delete();
    }
}
