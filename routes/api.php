<?php

use App\Http\Controllers\Finder\ImportWbController;
use App\Http\Controllers\Finder\OfferPriceController;
use App\Http\Controllers\Finder\StockController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


//Finder routes
Route::get('import', ImportWbController::class)->name('api.import');
Route::post('offered-price', OfferPriceController::class)->name('api.offered-price');
Route::get('stock', [StockController::class, 'index'])->name('api.stock');
