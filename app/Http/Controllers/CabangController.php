<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\CabangRequest;

use App\Cabang;

class CabangController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['cabang'] = Cabang::orderBy('nama', 'asc')->get();
        
        return view('page.cabang.index', $data);
    }

    public function form($id = null){
        if(!empty($id)){
            $cabang = Cabang::find($id);
            $data['cabang'] = (object)[
                'id' => $cabang->id,
                'nama' => $cabang->nama,
                'alamat' => $cabang->alamat,
                'telp' => $cabang->telp,
                'pic' => $cabang->pic
            ];
        }else{
            $data['cabang'] = (object)[
                'id' => '',
                'nama' => '',
                'alamat' => '',
                'telp' => '',
                'pic' => ''
            ];
        }
        return view('page.cabang.form', $data);
    }

    public function store(CabangRequest $request){
        Cabang::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'pic' => $request->pic
        ]);

        return redirect()->route('cabang.index')->with('success', 'Data berhasil disimpan.');
    }

    public function update(CabangRequest $request){
        $cabang = Cabang::find($request->id);
        $cabang->nama = $request->nama;
        $cabang->alamat = $request->alamat;
        $cabang->telp = $request->telp;
        $cabang->pic = $request->pic;
        $cabang->save();

        return redirect()->route('cabang.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(Request $request){
        $cabang = Cabang::find($request->id);
        $cabang->delete();
    }
}
