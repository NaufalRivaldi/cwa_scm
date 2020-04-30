<?php

namespace App\Http\Controllers\Laporan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\PO;
use App\Supplier;
use App\DetailPO;

class RekapController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['supplier'] = Supplier::orderBy('nama', 'asc')->get();

        if($_GET){
            $tglPO = $_GET['tglPO'];
            $supplierId = $_GET['supplierId'];
            if(!empty($supplierId)){
                $data['detailpo'] = DetailPO::whereHas('po', function($table) use ($tglPO, $supplierId){
                    $table->where('status', '!=', '1')->where('status', '!=', '3')->where('supplierId', $supplierId)->where('tglPO', 'like', '%'.$tglPO.'%');
                })->orderBy('id', 'desc')->get();
            }else{
                $data['detailpo'] = DetailPO::whereHas('po', function($table) use ($tglPO){
                    $table->where('status', '!=', '1')->where('status', '!=', '3')->where('tglPO', 'like', '%'.$tglPO.'%');
                })->orderBy('id', 'desc')->get();
            }
        }else{
            $data['detailpo'] = DetailPO::whereHas('po', function($table){
                $table->where('status', '!=', '1')->where('status', '!=', '3');
            })->orderBy('id', 'desc')->get();
        }
        
        return view('page.laporan.rekap.index', $data);
    }

    public function view($id){
        $data['no'] = '1';
        $data['po'] = PO::find($id);

        return view('page.laporan.rekap.view', $data);
    }

    public function export()
    {
        $data['no'] = 1;
        $data['supplier'] = Supplier::orderBy('nama', 'asc')->get();
        $data['date'] = date('Y-m-d');
        $data['user'] = auth()->user()->nama;

        if($_GET){
            $tglPO = $_GET['tglPO'];
            $supplierId = $_GET['supplierId'];
            if(!empty($supplierId)){
                $data['po'] = PO::where('status', '!=', '1')->where('status', '!=', '3')->where('supplierId', $supplierId)->where('tglPO', 'like', '%'.$tglPO.'%')->orderBy('id', 'desc')->get();
            }else{
                $data['po'] = PO::where('status', '!=', '1')->where('status', '!=', '3')->where('tglPO', 'like', '%'.$tglPO.'%')->orderBy('id', 'desc')->get();
            }
        }else{
        	$data['po'] = PO::where('status', '!=', '1')->where('status', '!=', '3')->orderBy('id', 'desc')->get();
        }

        // dd($data);

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadview('page.laporan.rekap.export', $data)->setPaper('a4', 'potrait');
        return $pdf->stream();

        // return view('page.laporan.rekap.export', $data);


    }
}
