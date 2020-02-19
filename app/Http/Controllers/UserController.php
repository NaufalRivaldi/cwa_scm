<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;

class UserController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['user'] = User::orderBy('nama', 'asc')->get();
        return view('page.user.index', $data);
    }

    public function form($id = null){
        return view('page.user.form');
    }
}
