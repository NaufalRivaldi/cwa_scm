<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Str;

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

    public function store(UserRequest $req){
        $ttd = $this->upload($req);
        User::create([
            'nama' => $req->nama,
            'username' => $req->username,
            'password' => bcrypt('12346'),
            'ttd' => $ttd,
            'level' => $req->level,
            'remember_token' => Str::random(20)
        ]);

        return redirect()->route('user.index')->with('success', 'Data Berhasil di simpan.');
    }

    public function upload($req){
        $filename = time().'-'.Str::random(10).'.'.$req->ttd->extension();
        $req->ttd->move(public_path('upload/ttd'), $filename);

        return $filename;
    }
}
