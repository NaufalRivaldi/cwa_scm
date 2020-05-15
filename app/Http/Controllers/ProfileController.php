<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RePasswordRequest;

use App\User;

use Auth;
use Str;
use Hash;

class ProfileController extends Controller
{
    public function index(){
        return view('page.profile.index');
    }

    public function edit($id){
        $data['user'] = User::find($id);

        return view('page.profile.edit', $data);
    }

    public function update(Request $request){
        $ttd = $request->ttdOld;
        if($request->hasFile('ttd')){
            if($request->ttdOld != 'ttd.png'){
                unlink(public_path('upload/ttd/'.$request->ttdOld));
            }
            $ttd = $this->upload($request);
        }

        $user = User::find($request->id);
        $user->nama = $request->nama;
        $user->ttd = $ttd;
        $user->save();

        return redirect()->route('profile.index')->with('success', 'Data Berhasil di update.');
    }

    public function upload($req){
        $filename = time().'-'.Str::random(10).'.'.$req->ttd->extension();
        $req->ttd->move(public_path('upload/ttd'), $filename);

        return $filename;
    }

    public function ubahPassword(){
        return view('page.profile.ubahpassword');
    }

    public function repassword(RePasswordRequest $request){
        $user = User::find(Auth::user()->id);
        $oldPassword = bcrypt($request->oldPassword);
        $newPassword = bcrypt($request->newPassword);
        // dd($user);

        if(Hash::check($request->oldPassword, $user->password)){
            $user->password = $newPassword;
            $user->save();
            Auth::logout();

            return redirect()->route('login')->with('success', 'Password berhasil di ubah, silahkan login kembali.');
        }else{
            return redirect()->route('profile.ubahpassword')->with('danger', 'Password tidak valid!');
        }
    }
}
