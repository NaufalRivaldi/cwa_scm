<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\PO;
use App\DetailPO;
use App\Rekap;

class RekapController extends Controller
{
    public function index(){
        $data['no'] = 1;
        
        if($_GET){
            $data['detailPo'] = DetailPO::where('poId', $_GET['id'])->get();
            $data['po'] = PO::find($_GET['id']);
        }
        return view('page.rekap.index', $data);
    }

    public function nopo(Request $request){
        if($request->has('q')){
            $cari = $request->q;
        }else{
            $cari = '';
        }
        $data = PO::where('status', '!=', '1')->where('status', '!=', '3')->where('nomer', 'like', '%'.$cari.'%')->get();

        return response()->json($data);
    }

    public function store(Request $request){
        $id = $request->id;
        $val = $request->val;
        $type = $request->type;

        switch ($type) {
            case '1':
                $this->setTRD($id, $val);
                break;

            case '2':
                $this->setTDO($id, $val);
                break;

            case '3':
                $this->setTD($id, $val);
                break;
            
            default:
                $this->setKeterangan($id, $val);
                break;
        }
    }

    public function status(Request $request){
        $id = $request->id;
        $val = $request->val;
        $data = PO::find($id);
        
        if($val == '1'){
            $data->status = '4';
        }else{
            $data->status = '2';
        }

        $data->save();
    }

    public function setTRD($id, $val){
        $data = Rekap::where('detailPoId', $id)->first();
        if(empty($data)){
            Rekap::create([
                'trd' => $val,
                'detailPoId' => $id
            ]);
        }else{
            $data->trd = $val;
            $data->save();
        }
    }

    public function setTDO($id, $val){
        $data = Rekap::where('detailPoId', $id)->first();
        if(empty($data)){
            Rekap::create([
                'tdo' => $val,
                'detailPoId' => $id
            ]);
        }else{
            $data->tdo = $val;
            $data->save();
        }
    }

    public function setTD($id, $val){
        $data = Rekap::where('detailPoId', $id)->first();
        if(empty($data)){
            Rekap::create([
                'td' => $val,
                'detailPoId' => $id
            ]);
        }else{
            $data->td = $val;
            $data->save();
        }
    }

    public function setKeterangan($id, $val){
        $data = Rekap::where('detailPoId', $id)->first();
        if(empty($data)){
            Rekap::create([
                'keterangan' => $val,
                'detailPoId' => $id
            ]);
        }else{
            $data->keterangan = $val;
            $data->save();
        }
    }
}
