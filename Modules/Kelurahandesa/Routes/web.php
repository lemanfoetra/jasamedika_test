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

Route::prefix('kelurahandesa')->group(function () {
    Route::get('/', 'KelurahandesaController@index')->name('kelurahandesa.index');
    Route::get('list_desa', 'KelurahandesaController@listDesa')->name('kelurahandesa.list_desa');
    Route::get('create', 'KelurahandesaController@create')->name('kelurahandesa.create');
    Route::get('edit/{id}', 'KelurahandesaController@edit')->name('kelurahandesa.edit');
    Route::get('delete/{id}', 'KelurahandesaController@destroy')->name('kelurahandesa.delete');
    Route::post('store', 'KelurahandesaController@store')->name('kelurahandesa.store');

    Route::get('list_kab', 'KelurahandesaController@list_kab')->name('kelurahandesa.list_kab');
    Route::get('list_kec', 'KelurahandesaController@list_kec')->name('kelurahandesa.list_kec');
});
