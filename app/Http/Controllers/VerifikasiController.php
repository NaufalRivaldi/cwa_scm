<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PO;
use App\DetailPO;

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
}
