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
   return view('auth.login'); 
})->name('login');

Route::group(['prefix' => 'auth'], function(){
   Route::post('login', 'AuthController@login')->name('signin');
   Route::post('logout', 'AuthController@login')->name('logout');
});

Route::get('/dashboard', function(){
   return view('dashboard.homepage');
});

Route::group(['middleware' => 'auth'], function(){
   // auth
   Route::post('logout', 'AuthController@logout')->name('logout');

   // dashboard
   Route::get('dashboard', 'HomeController@index')->name('dashboard');   

   // user
   Route::group(['prefix' => 'user/', 'middleware' => 'AuthLevel:2'], function(){
      Route::get('/', 'UserController@index')->name('user.index');
      Route::get('/form', 'UserController@form')->name('user.form');
      Route::post('/store', 'UserController@store')->name('user.store');
   });
});