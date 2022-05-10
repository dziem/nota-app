<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
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
    return view('dashboard');
});

Route::get('/report-customer', [ReportController::class, 'customer']);

Route::get('/report-item', [ReportController::class, 'item']);

Route::get('/report-restock', [ReportController::class, 'restock'])->name('report.restock');

Route::get('/report-restock/{id}', [ReportController::class, 'restockDetail'])->name('report.restock.detail');

Route::get('/invoice', [InvoiceController::class, 'index']);

Route::post('/invoice', [InvoiceController::class, 'submit']);

Route::resource('/price', PriceController::class);

Route::get('/stock', [StockController::class, 'index'])->name('stock.index');

Route::get('/stock/add', [StockController::class, 'add'])->name('stock.add');

Route::get('/stock/{id}', [StockController::class, 'detail'])->name('stock.detail');

Route::post('/stock/add', [StockController::class, 'submit'])->name('stock.submit');
