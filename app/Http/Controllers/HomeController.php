<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Supplier;
use App\Cabang;
use App\PO;

class HomeController extends Controller
{
    public function index(){
        $data['supplier'] = Supplier::all();
        $data['cabang'] = Cabang::all();
        $data['po'] = PO::where('status', '1')->get();

        return view('page.dashboard', $data);
    }
}
