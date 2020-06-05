<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

use Hash;
use Auth;

use App\PO;

class User{
  public static function checkPass(){
    $default = '12345';
    $hashed = Auth::user()->password;

    if(Hash::check($default, $hashed)){
      return true;
    }else{
      return false;
    }
  }

  public static function countVerifikasi(){
    $po = PO::where('status', 1)->get();

    return count($po);
  }
}