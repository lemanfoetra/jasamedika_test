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
use Modules\Auth\Http\Controllers\AuthController;


Route::prefix('auth')->group(function () {
    Route::get('login', 'AuthController@index')->name('login');
    Route::get('user', 'AuthController@user')->name('login.user');
    Route::get('logout', 'AuthController@logout')->name('login.logout');
    Route::post('auth', [AuthController::class, 'auth'])->name('login.auth');
});
