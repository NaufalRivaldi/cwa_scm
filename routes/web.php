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
      Route::get('/{id}/edit', 'UserController@form')->name('user.edit');
      Route::post('/delete-file', 'UserController@deleteFile')->name('user.delete.file');
      Route::post('/store', 'UserController@store')->name('user.store');
      Route::put('/update', 'UserController@update')->name('user.update');
      Route::post('/destroy', 'UserController@destroy')->name('user.destroy');

      // active
      Route::get('/{id}/nonactive', 'UserController@nonactive')->name('user.nonactive');
      Route::get('/{id}/active', 'UserController@active')->name('user.active');
   });

   // cabang
   Route::group(['prefix' => 'cabang/', 'middkeware' => 'AuthLevel:2'], function(){
      Route::get('/', 'CabangController@index')->name('cabang.index');
      Route::get('/form', 'CabangController@form')->name('cabang.form');
      Route::get('/{id}/edit', 'CabangController@form')->name('cabang.edit');
      Route::post('/store', 'CabangController@store')->name('cabang.store');
      Route::put('/update', 'CabangController@update')->name('cabang.update');
      Route::post('/destroy', 'CabangController@destroy')->name('cabang.destroy');
   });

   // wilayah
   Route::group(['prefix' => 'wilayah/', 'middkeware' => 'AuthLevel:2'], function(){
      Route::get('/', 'WilayahController@index')->name('wilayah.index');
      Route::get('/form', 'WilayahController@form')->name('wilayah.form');
      Route::get('/{id}/edit', 'WilayahController@form')->name('wilayah.edit');
      Route::post('/store', 'WilayahController@store')->name('wilayah.store');
      Route::put('/update', 'WilayahController@update')->name('wilayah.update');
      Route::post('/destroy', 'WilayahController@destroy')->name('wilayah.destroy');
   });
});