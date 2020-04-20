<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;

use App\Http\Requests\AuthRequest;

class AuthController extends Controller
{
    public function login(AuthRequest $req){
        if(Auth::attempt(['username' => $req->username, 'password' => $req->password], true)){
            return redirect()->route('dashboard')->with('success', 'Selamat datang '.Auth::user()->nama.', selamat bekerja.');
        }else{
            return redirect()->route('login')->with('danger', 'User dan password tidak valid!');
        }
    }

    public function logout(){
        Auth::logout();

        return redirect()->route('login')->with('success', 'Terima kasih telah bekerja.');
    }
}
