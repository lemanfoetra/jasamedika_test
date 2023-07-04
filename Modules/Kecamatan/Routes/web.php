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

Route::prefix('kecamatan')->group(function () {
    Route::get('/', 'KecamatanController@index')->name('kecamatan.index');
    Route::get('list_kecamatan', 'KecamatanController@listKecamatan')->name('kecamatan.list_kecamatan');
    Route::get('create', 'KecamatanController@create')->name('kecamatan.create');
    Route::get('edit/{id}', 'KecamatanController@edit')->name('kecamatan.edit');
    Route::get('delete/{id}', 'KecamatanController@destroy')->name('kecamatan.delete');
    Route::post('store', 'KecamatanController@store')->name('kecamatan.store');

    Route::get('list_kab', 'KecamatanController@list_kab')->name('kecamatan.list_kab');
});
