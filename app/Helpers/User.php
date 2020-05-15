<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

use Hash;
use Auth;

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
}