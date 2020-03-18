<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PoRequest;

use App\PO;
use App\Supplier;
use App\Barang;
use App\Supply;
use App\Cabang;
use App\DetailPO;

use Auth;

class PoController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['po'] = PO::orderBy('id', 'desc')->get();

        return view('page.po.index', $data);
    }

    public function form($id = null){
        if(empty($id)){
            $data['po'] = (object)[
                'nomer' => $this->nomerPo(),
                'tglPO' => date('Y-m-d'),
                'tglPengiriman' => '',
                'total' => '',
                'ppn' => '',
                'disc' => '',
                'grandTotal' => '',
                'note' => '',
                'status' => '',
                'userId' => '',
                'cabangId' => '',
                'supplierId' => ''
            ];
        }else{
            $data['po'] = PO::find($id);
        }

        return view('page.po.form', $data);
    }

    public function view($id){
        $data['no'] = 1;
        $data['po'] = PO::find($id);

        return view('page.po.view', $data);
    }

    public function store(PoRequest $request){
        $status = 1;
        if($request->grandTotal > 20000000){
            $status = 2;
        }
        PO::create([
            'nomer' => $request->nomer,
            'tglPO' => $request->tglPO,
            'tglPengiriman' => $request->tglPengiriman,
            'total' => $request->jml,
            'ppn' => $request->ppn,
            'grandTotal' => $request->grandTotal,
            'note' => $request->note,
            'status' => $status,
            'userId' => Auth::user()->id,
            'cabangId' => $request->cabangId,
            'supplierId' => $request->supplierId
        ]);
                
        $data = PO::orderBy('id', 'desc')->first();
        if(!empty($request->barangId)){
            for($i=0; $i<count($request->barangId); $i++){
                DetailPO::create([
                    'poId' => $data->id,
                    'barangId' => $request->barangId[$i],
                    'qty' => $request->qty[$i],
                    'satuan' => $request->kemasan[$i],
                    'disc' => $request->disc[$i],
                    'harga' => $request->harga[$i]
                ]);
            }
        }

        return redirect()->route('po.index')->with('success', 'PO berhasil di buat.');
    }

    public function update(PoRequest $request){
        $po = PO::find($request->id);
        $po->tglPengiriman = $request->tglPengiriman;
        $po->total = $request->jml;
        $po->ppn = $request->ppn;
        $po->grandTotal = $request->grandTotal;
        $po->note = $request->note;
        $po->cabangId = $request->cabangId;
        $po->supplierId = $request->supplierId;
        $po->save();

        $detailPo = DetailPO::where('poId', $request->id)->delete();
        if(!empty($request->barangId)){
            for($i=0; $i<count($request->barangId); $i++){
                DetailPO::create([
                    'poId' => $request->id,
                    'barangId' => $request->barangId[$i],
                    'qty' => $request->qty[$i],
                    'satuan' => $request->kemasan[$i],
                    'disc' => $request->disc[$i],
                    'harga' => $request->harga[$i]
                ]);
            }
        }

        return redirect()->route('po.index')->with('success', 'PO berhasil diupdate.');
    }

    public function destroy(Request $request){
        $data = PO::find($request->id);
        $data->delete();
    }

    public function loadSupplier(Request $request){
        if($request->has('q')){
            $cari = $request->q;
        }else{
            $cari = '';
        }
        $data = Supplier::where('nama', 'like', '%'.$cari.'%')->get();

        return response()->json($data);
    }

    public function loadCabang(Request $request){
        if($request->has('q')){
            $cari = $request->q;
        }else{
            $cari = '';
        }
        $data = Cabang::where('nama', 'like', '%'.$cari.'%')->get();

        return response()->json($data);
    }

    public function loadBarang(Request $request){
        if($request->has('q')){
            $cari = $request->q;
        }else{
            $cari = '';
        }

        $data = Barang::where('kodeBarang', 'like', '%'.$cari.'%')->orWhere('nama', 'like', '%'.$cari.'%')->get();
        return response()->json($data);
    }

    public function dataSupplier(Request $request){
       $data = Supplier::find($request->id);
        
       return response()->json($data);
    }

    public function dataHarga(Request $request){
        $data = Supply::where('barangId', $request->barangId)->where('supplierId', $request->supplierId)->first();
        $array = [
            'harga' => $data->harga,
            'diskon' => $data->diskon,
            'berat' => $data->barang->berat
        ];

        return response()->json($array);
    }

    public function nomerPo(){
        $nomor = '';
        $bulan = $this->romawi(date('n'));
        $tahun = date('Y');
        $key = $bulan.'/'.$tahun;

        $data = PO::where('nomer', 'like', '%'.$key.'%')->orderBy('id', 'desc')->first();
        if(empty($data)){
            $nomor = '1/WLDN-DPS/'.$bulan.'/'.$tahun;
        }else{
            $row = explode('/', $data->nomer);
            $row[0] += 1;
            $nomor = $row[0].'/'.$row[1].'/'.$row[2].'/'.$row[3];
        }

        return $nomor;
    }

    public function romawi($bulan){
        $array = array('0', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        return $array[$bulan];
    }

}
