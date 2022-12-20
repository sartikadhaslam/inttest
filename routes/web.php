<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PurchaseRequestController;

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

Route::get('/', [App\Http\Controllers\PurchaseRequestController::class, 'index']);

Route::resource('purchase-request', PurchaseRequestController::class);
Route::get('/purchase-request', [App\Http\Controllers\PurchaseRequestController::class, 'index'])->name('purchase-request.index');
Route::get('/purchase-request/add', [App\Http\Controllers\PurchaseRequestController::class, 'add'])->name('purchase-request.add');
Route::post('/purchase-request/store', [App\Http\Controllers\PurchaseRequestController::class, 'storeHeader'])->name('purchase-request.store');
Route::post('/purchase-request/store/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'storeDetail'])->name('purchase-request.store-detail');
Route::get('/purchase-request/edit/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'edit'])->name('purchase-request.edit');
Route::get('/purchase-request/view/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'view'])->name('purchase-request.view');
Route::delete('/purchase-request/destroy/item/{no}/{id}', [App\Http\Controllers\PurchaseRequestController::class, 'destroy'])->name('purchase-request.destroy');
Route::get('/getPrCode', [App\Http\Controllers\PurchaseRequestController::class, 'prCode'])->name('get-pr-code');
Route::get('/getItem', [App\Http\Controllers\PurchaseRequestController::class, 'getItem'])->name('get-item');