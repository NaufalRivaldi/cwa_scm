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
   Route::group(['prefix' => 'cabang/', 'middleware' => 'AuthLevel:1,2'], function(){
      Route::get('/', 'CabangController@index')->name('cabang.index');
      Route::get('/form', 'CabangController@form')->name('cabang.form');
      Route::get('/{id}/edit', 'CabangController@form')->name('cabang.edit');
      Route::post('/store', 'CabangController@store')->name('cabang.store');
      Route::put('/update', 'CabangController@update')->name('cabang.update');
      Route::post('/destroy', 'CabangController@destroy')->name('cabang.destroy');
   });

   // wilayah
   Route::group(['prefix' => 'wilayah/', 'middleware' => 'AuthLevel:1,2'], function(){
      Route::get('/', 'WilayahController@index')->name('wilayah.index');
      Route::get('/form', 'WilayahController@form')->name('wilayah.form');
      Route::get('/{id}/edit', 'WilayahController@form')->name('wilayah.edit');
      Route::post('/store', 'WilayahController@store')->name('wilayah.store');
      Route::put('/update', 'WilayahController@update')->name('wilayah.update');
      Route::post('/destroy', 'WilayahController@destroy')->name('wilayah.destroy');
   });

   // supplier
   Route::group(['prefix' => 'supplier/', 'middleware' => 'AuthLevel:1,2'], function(){
      Route::get('/', 'SupplierController@index')->name('supplier.index');
      Route::get('/{id}/view', 'SupplierController@view')->name('supplier.view');
      Route::get('/form', 'SupplierController@form')->name('supplier.form');
      Route::get('/cari', 'SupplierController@loadData')->name('wilayah.cari');
      Route::get('/{id}/edit', 'SupplierController@form')->name('supplier.edit');
      Route::post('/store', 'SupplierController@store')->name('supplier.store');
      Route::put('/update', 'SupplierController@update')->name('supplier.update');
      Route::post('/destroy', 'SupplierController@destroy')->name('supplier.destroy');
   });

   // Merk
   Route::group(['prefix' => 'merk/', 'middleware' => 'AuthLevel:1,2'], function(){
      Route::get('/', 'MerkController@index')->name('merk.index');
      Route::get('/form', 'MerkController@form')->name('merk.form');
      Route::get('/{id}/edit', 'MerkController@form')->name('merk.edit');
      Route::post('/store', 'MerkController@store')->name('merk.store');
      Route::put('/update', 'MerkController@update')->name('merk.update');
      Route::post('/destroy', 'MerkController@destroy')->name('merk.destroy');

      // import
      Route::post('/import', 'MerkController@import')->name('merk.import');
   });

   // perusahaan
   Route::group(['prefix' => 'perusahaan/', 'middleware' => 'AuthLevel:2'], function(){
      Route::get('/', 'PerusahaanController@index')->name('perusahaan.index');
      Route::get('/form', 'PerusahaanController@form')->name('perusahaan.form');
      Route::get('/{id}/edit', 'PerusahaanController@form')->name('perusahaan.edit');
      Route::post('/store', 'PerusahaanController@store')->name('perusahaan.store');
      Route::put('/update', 'PerusahaanController@update')->name('perusahaan.update');
      Route::post('/destroy', 'PerusahaanController@destroy')->name('perusahaan.destroy');
   });

   // barang
   Route::group(['prefix' => 'barang/', 'middleware' => 'AuthLevel:1,2'], function(){
      Route::get('/', 'BarangController@index')->name('barang.index');
      Route::get('/form', 'BarangController@form')->name('barang.form');
      Route::get('/{id}/edit', 'BarangController@form')->name('barang.edit');
      Route::get('/{id}/view', 'BarangController@view')->name('barang.view');
      Route::get('/cari/supplier', 'BarangController@loadSupplier')->name('barang.supplier');
      Route::get('/cari/merk', 'BarangController@loadMerk')->name('barang.merk');
      Route::post('/store', 'BarangController@store')->name('barang.store');
      Route::put('/update', 'BarangController@update')->name('barang.update');
      Route::post('/destroy', 'BarangController@destroy')->name('barang.destroy');
      
      // import
      Route::post('/import', 'BarangController@import')->name('barang.import');
      Route::post('/import.harga', 'BarangController@importHarga')->name('barang.import.harga');
   });

   // po
   Route::group(['prefix' => 'po/', 'middleware' => 'AuthLevel:1,2'], function(){
      Route::get('/', 'PoController@index')->name('po.index');
      Route::get('/form', 'PoController@form')->name('po.form');
      Route::post('/import', 'PoController@import')->name('po.import');
      Route::get('/{id}/edit', 'PoController@form')->name('po.edit');
      Route::get('/{id}/view', 'PoController@view')->name('po.view');
      Route::get('/cari/supplier', 'PoController@loadSupplier')->name('po.supplier');
      Route::get('/cari/cabang', 'PoController@loadCabang')->name('po.cabang');
      Route::get('/cari/barang', 'PoController@loadBarang')->name('po.barang');
      Route::get('/cari/merk', 'PoController@loadMerk')->name('po.merk');
      Route::post('/data/supplier', 'PoController@dataSupplier')->name('po.data.supplier');
      Route::get('/data/harga', 'PoController@dataHarga')->name('po.data.harga');
      Route::get('/data/nomer', 'PoController@nomerPo')->name('po.data.nomer');
      Route::post('/store', 'PoController@store')->name('po.store');
      Route::put('/update', 'PoController@update')->name('po.update');
      Route::post('/destroy', 'PoController@destroy')->name('po.destroy');

      // print
      Route::get('/{id}/print', 'PoController@print')->name('po.print');

      // memo
      Route::get('{id}/memo', 'PoController@memo')->name('po.memo');
      Route::get('memo/print/{id}/{item}', 'PoController@printMemo')->name(('po.memo.print'));
   });
   
   // verifikasi
   Route::group(['prefix' => 'verifikasi/', 'middleware' => 'AuthLevel:2'], function(){
      Route::get('/', 'VerifikasiController@index')->name('verifikasi.index');
      Route::get('/form', 'VerifikasiController@form')->name('verifikasi.form');
      Route::get('/{id}/edit', 'VerifikasiController@form')->name('verifikasi.edit');
      Route::get('/{id}/view', 'VerifikasiController@view')->name('verifikasi.view');
      Route::get('/{id}/validasi', 'VerifikasiController@validasi')->name('verifikasi.validasi');
      Route::post('/store', 'VerifikasiController@store')->name('verifikasi.store');
      Route::post('/verifikasi', 'VerifikasiController@verifikasi')->name('verifikasi.verifikasi');
      Route::put('/update', 'VerifikasiController@update')->name('verifikasi.update');
      Route::post('/destroy', 'VerifikasiController@destroy')->name('verifikasi.destroy');
      
      Route::post('/verifikasi-self', 'VerifikasiController@verself')->name('verifikasi.self');
   });

   Route::group(['prefix' => 'rekap/', 'middleware' => 'AuthLevel:1,2'], function(){
      Route::get('/', 'RekapController@index')->name('rekap.index');
      Route::get('/nopo', 'RekapController@nopo')->name('rekap.nopo');
      Route::post('/store', 'RekapController@store')->name('rekap.store');
      Route::post('/status', 'RekapController@status')->name('rekap.status');
   });

   Route::group(['prefix' => 'laporan/'], function(){
      Route::group(['prefix' => 'rekap'], function(){
         Route::get('/', 'Laporan\RekapController@index')->name('laporan.rekap.index');
         Route::get('/export', 'Laporan\RekapController@export')->name('laporan.rekap.export');
         Route::get('/{id}/view', 'Laporan\RekapController@view')->name('laporan.rekap.view');
         Route::get('/export', 'Laporan\RekapController@export')->name('laporan.rekap.export');
      });
   });

   Route::group(['prefix' => 'profile/'], function(){
      Route::get('/', 'ProfileController@index')->name('profile.index');
      Route::get('/{id}/edit', 'ProfileController@edit')->name('profile.edit');
      Route::put('/update', 'ProfileController@update')->name('profile.update');
      Route::get('/ubah-password', 'ProfileController@ubahPassword')->name('profile.ubahpassword');
      Route::post('/repassword', 'ProfileController@repassword')->name('profile.repassword');
   });

});