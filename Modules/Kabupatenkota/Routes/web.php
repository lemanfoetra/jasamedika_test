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

Route::prefix('kabupatenkota')->group(function() {
    Route::get('/', 'KabupatenkotaController@index')->name('kabupatenkota.index');
    Route::get('list_kabupatenkota', 'KabupatenkotaController@listProvinsi')->name('kabupatenkota.list_kabupatenkota');
    Route::get('create', 'KabupatenkotaController@create')->name('kabupatenkota.create');
    Route::get('edit/{id}', 'KabupatenkotaController@edit')->name('kabupatenkota.edit');
    Route::get('delete/{id}', 'KabupatenkotaController@destroy')->name('kabupatenkota.delete');
    Route::post('store', 'KabupatenkotaController@store')->name('kabupatenkota.store');
});
