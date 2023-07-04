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
use Modules\Role\Http\Controllers\RoleController;

Route::prefix('role')->group(function () {
    Route::get('/', 'RoleController@index')->name('role.index');
    Route::get('create', [RoleController::class, 'create']);
    Route::post('store', [RoleController::class, 'store']);
    Route::get('update/{id}', [RoleController::class, 'edit']);
    Route::get('delete/{id}', [RoleController::class, 'destroy']);
    Route::get('access/{role}', [RoleController::class, 'accessMenu']);
    Route::get('set-access', [RoleController::class, 'setAccess'])->name('role.set-access');
});
