<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

use App\User;

use File;

class UserController extends Controller
{
    public function index(){
        $data['no'] = 1;
        $data['user'] = User::orderBy('nama', 'asc')->get();
        return view('page.user.index', $data);
    }

    public function form($id = null){
        if(!empty($id)){
            $user = User::find($id);
            $data['user'] = (object)[
                'id' => $user->id,
                'nama' => $user->nama,
                'username' => $user->username,
                'ttd' => $user->ttd,
                'level' => $user->level
            ];
        }else{
            $data['user'] = (object)[
                'id' => '',
                'nama' => '',
                'username' => '',
                'ttd' => '',
                'level' => ''
            ];
        }
        return view('page.user.form', $data);
    }

    public function store(UserRequest $request){
        $ttd = $this->upload($request);
        User::create([
            'nama' => $request->nama,
            'username' => $request->username,
            'password' => bcrypt('12346'),
            'ttd' => $ttd,
            'level' => $request->level,
            'remember_token' => Str::random(20)
        ]);

        return redirect()->route('user.index')->with('success', 'Data Berhasil di simpan.');
    }

    public function nonactive($id){
        $user = User::find($id);
        $user->status = 2;
        $user->save();

        return redirect()->route('user.index')->with('warning', 'User berhasil di nonaktifkan.');
    }

    public function active($id){
        $user = User::find($id);
        $user->status = 1;
        $user->save();

        return redirect()->route('user.index')->with('success', 'User berhasil di aktifkan.');
    }

    public function update(UserRequest $request){
        $ttd = $request->ttdOld;
        if($request->hasFile('ttd')){
            if($request->ttdOld != 'ttd.png'){
                unlink(public_path('upload/ttd/'.$request->ttdOld));
            }
            $ttd = $this->upload($request);
        }

        $user = User::find($request->id);
        $user->nama = $request->nama;
        $user->username = $request->username;
        $user->ttd = $ttd;
        $user->level = $request->level;
        $user->save();

        return redirect()->route('user.index')->with('success', 'Data Berhasil di update.');
    }

    public function upload($req){
        $filename = time().'-'.Str::random(10).'.'.$req->ttd->extension();
        $req->ttd->move(public_path('upload/ttd'), $filename);

        return $filename;
    }

    public function deleteFile(Request $request){
        $user = User::find($request->id);
        unlink(public_path('upload/ttd/'.$user->ttd));
        $user->ttd = '';
        $user->save();
        
        return $user;
    }

    public function destroy(Request $request){
        $user = User::find($request->id);
        unlink(public_path('upload/ttd/'.$user->ttd));
        $user->delete();
    }
}
