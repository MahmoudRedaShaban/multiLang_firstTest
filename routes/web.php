<?php

use App\Http\Controllers\LocaleController;
use App\Http\Controllers\ProdectController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('layouts.app');
});



/* Route Chang Lng in Project */

Route::get('/change-language/{locale}', [LocaleController::class, 'switch'])->name('change.language');


// required from group_madilware not using prefix
// Route::middleware(['localized'])->prefix(app()->getLocale())->group(function () {
//And not using localized ? add prefix in routprovider
// Route::middleware(['localized'])->prefix(app()->getLocale())->group(function () {
Route::group(['middleware'=>'web'],function () {

    Route::get('products', [ProdectController::class, 'index'])->name('products.index');

    Route::get('products/create', [ProdectController::class, 'create'])->name('products.create');
    Route::post('products/create', [ProdectController::class, 'store'])->name('products.store');

    Route::get('products/{product}', [ProdectController::class, 'show'])->name('products.show');

    Route::get('products/{product}/edit', [ProdectController::class, 'edit'])->name('products.edit');
    Route::patch('products/{product}/edit', [ProdectController::class, 'update'])->name('products.update');

    Route::delete('products/{product}', [ProdectController::class, 'destory'])->name('products.destory');

});
