<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PerusahaanRequest;
use Illuminate\Support\Str;

use App\Perusahaan;

class PerusahaanController extends Controller
{
    public function index(){
        $data['perusahaan'] = Perusahaan::orderBy('id', 'asc')->first();

        return view('page.perusahaan.index', $data);
    }

    public function form($id = null){
        if(!empty($id)){
            $data['perusahaan'] = Perusahaan::find($id);
        }else{
            $data['perusahaan'] = (object)[
                'nama' => '',
                'alamat' => '',
                'telp' => '',
                'fax' => '',
                'email' => '',
                'pic' => '',
                'logo' => '',
                'cap' => ''
            ];
        }

        return view('page.perusahaan.form', $data);
    }

    public function store(PerusahaanRequest $request){
        $logo = $this->uploadLogo($request);
        $cap = $this->uploadCap($request);

        Perusahaan::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'telp' => $request->telp,
            'fax' => $request->fax,
            'email' => $request->email,
            'pic' => $request->pic,
            'logo' => $logo,
            'cap' => $cap
        ]);
        
        return redirect()->route('perusahaan.index')->with('success', 'Data berhasil diset.');
    }

    public function update(PerusahaanRequest $request){
        $logo = $request->logoOld;
        $cap = $request->capOld;
        if($request->hasFile('logo')){
            unlink(public_path('upload/logo/'.$request->logoOld));
            $logo = $this->uploadLogo($request);
        }

        if($request->hasFile('cap')){
            unlink(public_path('upload/cap/'.$request->capOld));
            $cap = $this->uploadCap($request);
        }
        
        $data = Perusahaan::find($request->id);
        $data->nama = $request->nama;
        $data->alamat = $request->alamat;
        $data->telp = $request->telp;
        $data->fax = $request->fax;
        $data->email = $request->email;
        $data->pic = $request->pic;
        $data->logo = $logo;
        $data->cap = $cap;
        $data->save();

        return redirect()->route('perusahaan.index')->with('success', 'Data berhasil diupdate.');
    }

    public function uploadLogo($req){
        $filename = time().'-'.Str::random(10).'.'.$req->logo->extension();
        $req->logo->move(public_path('upload/logo'), $filename);

        return $filename;
    }

    public function uploadCap($req){
        $filename = time().'-'.Str::random(10).'.'.$req->cap->extension();
        $req->cap->move(public_path('upload/cap'), $filename);

        return $filename;
    }
}
