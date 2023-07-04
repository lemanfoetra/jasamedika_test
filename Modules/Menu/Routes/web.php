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
use Modules\Menu\Http\Controllers\MenuController;

Route::prefix('menu')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('menu.index');
    Route::get('create', [MenuController::class, 'create'])->name('menu.create');
    Route::get('edit/{id}', [MenuController::class, 'edit'])->name('menu.edit');
    Route::get('delete/{id}', [MenuController::class, 'destroy'])->name('menu.delete');
    Route::post('store', [MenuController::class, 'store'])->name('menu.store');
});
