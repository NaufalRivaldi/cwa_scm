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
            return response()->json(Auth::user(), 200);
        }else{
            return response()->json(['error' => 'Anda tidak bisa login.'], 401);
        }
    }

    public function logout(){
        Auth::logout();
    }
}
