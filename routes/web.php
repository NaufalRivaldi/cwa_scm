<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function(){
   return view('auth.login')->name('login'); 
});

Route::group(['prefix' => 'auth'], function(){
   Route::post('login', 'AuthController@login')->name('signin');
   Route::post('logout', 'AuthController@login')->name('logout');
});

Route::get('/dashboard', function(){
   return view('dashboard.homepage');
});