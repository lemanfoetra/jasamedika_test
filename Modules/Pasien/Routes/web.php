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

use Illuminate\Support\Facades\Route;

Route::prefix('pasien')->group(function () {
    Route::get('/', 'PasienController@index')->name('pasien.index');
    Route::get('list_pasien', 'PasienController@listPasien')->name('pasien.list_pasien');
    Route::get('create', 'PasienController@create')->name('pasien.create');
    Route::get('edit/{id}', 'PasienController@edit')->name('pasien.edit');
    Route::get('delete/{id}', 'PasienController@destroy')->name('pasien.delete');
    Route::post('store', 'PasienController@store')->name('pasien.store');

    Route::get('list_kab', 'PasienController@list_kab')->name('pasien.list_kab');
    Route::get('list_kec', 'PasienController@list_kec')->name('pasien.list_kec');
    Route::get('list_kel', 'PasienController@list_kel')->name('pasien.list_kel');
});
