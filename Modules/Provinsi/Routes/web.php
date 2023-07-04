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

Route::prefix('provinsi')->group(function () {
    Route::get('/', 'ProvinsiController@index')->name('provinsi.index');
    Route::get('list_provinsi', 'ProvinsiController@listProvinsi')->name('provinsi.list_provinsi');
    Route::get('create', 'ProvinsiController@create')->name('provinsi.create');
    Route::get('edit/{id}', 'ProvinsiController@edit')->name('provinsi.edit');
    Route::get('delete/{id}', 'ProvinsiController@destroy')->name('provinsi.delete');
    Route::post('store', 'ProvinsiController@store')->name('provinsi.store');
});
