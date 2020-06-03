<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MerkRequest;
use Maatwebsite\Excel\Facades\Excel;

use App\Merk;
use App\Imports\MerkImport;

class MerkController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['merk'] = Merk::orderBy('kodeMerk', 'asc')->get();
        
        return view('page.merk.index', $data);
    }

    public function form($id = null){
        if(!empty($id)){
            $merk = Merk::find($id);
            $data['merk'] = (object)[
                'id' => $merk->id,
                'kodeMerk' => $merk->kodeMerk,
                'nama' => $merk->nama
            ];
        }else{
            $data['merk'] = (object)[
                'id' => '',
                'kodeMerk' => '',
                'nama' => ''
            ];
        }
        return view('page.merk.form', $data);
    }

    public function store(MerkRequest $request){
        Merk::create([
            'kodeMerk' => $request->kodeMerk,
            'nama' => $request->nama
        ]);

        return redirect()->route('merk.index')->with('success', 'Data berhasil disimpan.');
    }

    public function update(MerkRequest $request){
        $merk = Merk::find($request->id);
        $merk->kodeMerk = $request->kodeMerk;
        $merk->nama = $request->nama;
        $merk->save();

        return redirect()->route('merk.index')->with('success', 'Data berhasil diupdate.');
    }

    public function destroy(Request $request){
        $merk = Merk::find($request->id);
        $merk->delete();
    }

    public function import(Request $request){
        $this->validate($request,[
            'file' => 'required|mimes:csv,xlsx,xls'
        ]);

        $file = $request->file('file');
        $fileName = date('Y-m-d').'-merk.'.$file->getClientOriginalExtension();
        $file->move(public_path('import/merk'), $fileName);

        Excel::import(new MerkImport, public_path('/import/merk/'.$fileName));
        
        return redirect()->route('merk.index')->with('success', 'Merk berhasil diimport');
    }
}
