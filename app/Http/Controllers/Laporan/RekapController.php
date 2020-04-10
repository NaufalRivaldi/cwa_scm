<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\PO;
use App\Supplier;

class RekapController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['supplier'] = Supplier::orderBy('nama', 'asc')->get();

        if($_GET){
        	$status = $_GET['status'];
            $tglPO = $_GET['tglPO'];
            $supplierId = $_GET['supplierId'];
            if(!empty($supplierId)){
                $data['po'] = PO::where('status', '!=', '1')->where('status', '!=', '3')->where('supplierId', $supplierId)->where('tglPO', 'like', '%'.$tglPO.'%')->where('status', 'like', '%'.$status.'%')->orderBy('id', 'desc')->get();
            }else{
                $data['po'] = PO::where('status', '!=', '1')->where('status', '!=', '3')->where('tglPO', 'like', '%'.$tglPO.'%')->where('status', 'like', '%'.$status.'%')->orderBy('id', 'desc')->get();
            }
        }else{
        	$data['po'] = PO::where('status', '!=', '1')->where('status', '!=', '3')->orderBy('id', 'desc')->get();
        }
        
        return view('page.laporan.rekap.index', $data);
    }

    public function view($id){
        $data['no'] = '1';
        $data['po'] = PO::find($id);

        return view('page.laporan.rekap.view', $data);
    }
}