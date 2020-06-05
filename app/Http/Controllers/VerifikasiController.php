<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PO;
use App\DetailPO;

use Auth;

class VerifikasiController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['po'] = PO::where('status', '1')->orderBy('id', 'desc')->get();

        return view('page.verifikasi.index', $data);
    }

    public function view($id){
        $data['no'] = 1;
        $data['po'] = PO::find($id);

        return view('page.verifikasi.view', $data);
    }

    public function verifikasi(Request $request){
        // dd($request->all());
        if($request->setVerifikasi == 1){
            $status = 2;
        }else{
            $status = 3;
        }
        $data = explode(',', $request->cek);
        for($i=0; $i<count($data); $i++){
            $po = PO::find($data[$i]);
            $po->status = $status;
            $po->userId = Auth::user()->id;
            $po->save();
        }

        return redirect()->route('verifikasi.index')->with('success', 'PO sudah di verifikasi');
    }

    public function verself(Request $request){
        $po = PO::find($request->id);
        if(!empty($request->verifikasi)){
            $po->status = '2';
        }else{
            $po->status = '3';
        }
        $po->userId = Auth::user()->id;
        $po->save();
        
        return redirect()->route('verifikasi.index')->with('success', 'PO sudah di verifikasi');
    }
}
