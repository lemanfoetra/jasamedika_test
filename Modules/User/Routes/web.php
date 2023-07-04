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
use Modules\User\Http\Controllers\UserController;

Route::prefix('user')->group(function () {
    Route::get('/', 'UserController@index')->name('user.index');
    Route::get('create', [UserController::class, 'create'])->name('user.create');
    Route::get('edit/{user}', [UserController::class, 'edit'])->name('user.edit');
    Route::get('hapus/{id}', [UserController::class, 'remove'])->name('user.delete');
    Route::post('store', [UserController::class, 'store'])->name('user.store');
});
