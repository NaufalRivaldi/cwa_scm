<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PoRequest;
use Maatwebsite\Excel\Facades\Excel;

use App\PO;
use App\Supplier;
use App\Barang;
use App\Supply;
use App\Cabang;
use App\DetailPO;
use App\Perusahaan;
use App\View\Barang as vwBarang;

use App\Imports\ViewBarangImport;

use Auth;
use PDF;

class PoController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['supplier'] = Supplier::orderBy('nama', 'asc')->get();

        if($_GET){
            $status = $_GET['status'];
            $tglPO = $_GET['tglPO'];
            $supplierId = $_GET['supplierId'];
            if(!empty($supplierId)){
                $data['po'] = PO::where('supplierId', $supplierId)->where('tglPO', 'like', '%'.$tglPO.'%')->where('status', 'like', '%'.$status.'%')->orderBy('id', 'desc')->get();
            }else{
                $data['po'] = PO::where('tglPO', 'like', '%'.$tglPO.'%')->where('status', 'like', '%'.$status.'%')->orderBy('id', 'desc')->get();
            }
        }else{
            $data['po'] = PO::orderBy('id', 'desc')->get();
        }

        return view('page.po.index', $data);
    }

    public function form($id = null){
        if(empty($id)){
            $data['po'] = (object)[
                'nomer' => '',
                'tglPO' => date('Y-m-d'),
                'tglPengiriman' => date('Y-m-d'),
                'metodePembayaran' => '',
                'total' => '',
                'disc' => '',
                'note' => '',
                'status' => '',
                'userId' => '',
                'cabangId' => '',
                'supplierId' => ''
            ];

            $data['imports'] = vwBarang::all();
        }else{
            $data['po'] = PO::find($id);
            // dd($data['po']);
        }

        return view('page.po.form', $data);
    }

    public function view($id){
        $data['no'] = 1;
        $data['po'] = PO::find($id);

        return view('page.po.view', $data);
    }

    public function memo($id){
        $data['no'] = 1;
        $data['po'] = PO::find($id);

        return view('page.po.memo', $data);
    }

    public function print($id){
        $po = PO::find($id);
        $date = date('Y-m-d', strtotime($po->tglPO));
        $data['no'] = 1;
        $data['po'] = $po;
        $data['perusahaan'] = Perusahaan::orderBy('id', 'asc')->first();

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadview('page.po.print_invoice', $data)->setPaper('a5', 'potrait');
        return $pdf->stream();
        // return view('page.po.print_invoice', $data);
    }
    
    public function printMemo($id, $item, $qty){
        $po = PO::find($id);
        $date = date('Y-m-d', strtotime($po->tglPO));
        $data['no'] = 1;
        $data['po'] = $po;
        $data['perusahaan'] = Perusahaan::orderBy('id', 'asc')->first();
        $qty = $this->fixQty($qty);
        $itemArray = explode(',', $item);
        $qtyArray = explode(',', $qty);
        $data['item'] = $itemArray;
        $data['qty'] = $qtyArray;

        $pdf = \App::make('dompdf.wrapper');
        $pdf->loadview('page.po.print_memo', $data)->setPaper('a5', 'potrait');
        return $pdf->stream();
        // return view('page.po.print_memo', $data);
    }

    public function store(PoRequest $request){
        $status = 1;
        $tglPengiriman = '1000-01-01';
        if($request->jml < 20000000){
            $status = 2;
        }

        if(!empty($request->tglPengiriman)){
            $tglPengiriman = $request->tglPengiriman;
        }

        PO::create([
            'nomer' => $request->nomer,
            'tglPO' => $request->tglPO,
            'tglPengiriman' => $tglPengiriman,
            'total' => $request->jml,
            'note' => $request->note,
            'status' => $status,
            'metodePembayaran' => $request->metodePembayaran,
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

        return redirect()->route('po.view', ['id' => $data->id])->with('success', 'PO berhasil di buat.');
    }

    public function update(PoRequest $request){
        $po = PO::find($request->id);
        
        $po->nomer = $request->nomer;
        $po->tglPO = $request->tglPO;
        $po->total = $request->jml;
        $po->note = $request->note;
        $po->metodePembayaran = $request->metodePembayaran;
        $po->cabangId = $request->cabangId;
        $po->supplierId = $request->supplierId;

        $tglPengiriman = '1000-01-01';
        if(!empty($request->tglPengiriman)){
            $tglPengiriman = $request->tglPengiriman;
        }
        $po->tglPengiriman = $tglPengiriman;

        if($request->jml < 20000000){
            $po->status = 2;
        }else{
            $po->status = 1;
        }
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

        return redirect()->route('po.view', ['id' => $request->id])->with('success', 'PO berhasil diupdate.');
    }

    public function destroy(Request $request){
        $data = PO::find($request->id);
        $data->delete();
    }

    public function import(Request $request){
        vwBarang::truncate();
        
        $this->validate($request, [
            'file' => 'required|mimes:xlsx,csv,xls'
        ]);

        $nameFile = 'import-list-barang.'.$request->file->getClientOriginalExtension();
        $request->file->move(public_path('import/listBarang'), $nameFile);

        Excel::import(new ViewBarangImport, public_path('import/listBarang/'.$nameFile));

        return $this->form()->with('success', 'Data telah diimport.');
    }

    public function loadSupplier(Request $request){
        if($request->has('q')){
            $cari = $request->q;
        }else{
            $cari = '';
        }
        $data = Supplier::where('kode', 'like', '%'.$cari.'%')->orWhere('nama', 'like', '%'.$cari.'%')->get();

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
        $barang = Barang::find($request->barangId);
        
        if(empty($data)){
            $array = [
                'harga' => '0',
                'diskon' => '0',
                'kemasan' => $barang->kemasan
            ];
        }elseif(empty($data->harga)){
            $array = [
                'harga' => '0',
                'diskon' => $data->diskon,
                'kemasan' => $barang->kemasan
            ];
        }elseif(empty($data->diskon)){
            $array = [
                'harga' => $data->harga,
                'diskon' => '0',
                'kemasan' => $barang->kemasan
            ];
        }else{
            $array = [
                'harga' => $data->harga,
                'diskon' => $data->diskon,
                'kemasan' => $barang->kemasan
            ];
        }

        return response()->json($array);
    }

    public function nomerPo(Request $request){
        $nomor = '';
        $supplierId = $request->id;
        $supplier = Supplier::find($supplierId);
        $kodeSupplier = $supplier->kode.'-'.$supplier->wilayah->nama;
        
        $bulan = $this->romawi(date('n'));
        $tahun = date('Y');
        $key = $kodeSupplier.'/'.$bulan.'/'.$tahun;

        $data = PO::where('nomer', 'like', '%'.$key.'%')->orderBy('id', 'desc')->first();
        if(empty($data)){
            $nomor = '0001/'.$kodeSupplier.'/'.$bulan.'/'.$tahun;
        }else{
            $row = explode('/', $data->nomer);
            $row[0] += 1;
            
            if(strlen($row[0]) == 1){
                $que = '000'.$row[0];
            }elseif(strlen($row[0]) == 2){
                $que = '00'.$row[0];
            }elseif(strlen($row[0]) == 3){
                $que = '0'.$row[0];
            }else{
                $que = $row[0];
            }
            $nomor = $que.'/'.$row[1].'/'.$row[2].'/'.$row[3];
        }

        return $nomor;
    }

    public function romawi($bulan){
        $array = array('0', 'I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII');
        return $array[$bulan];
    }

    public function fixQty($qty){
        if($qty[0] === ','){
            return substr($qty, 1);
        }

        return $qty;
    }

}
