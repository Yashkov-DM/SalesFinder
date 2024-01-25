<?php

use App\Http\Controllers\Finder\GroupCalculatePriceController;
use App\Http\Controllers\Finder\ImportWbController;
use App\Http\Controllers\Finder\OfferPriceController;
use App\Http\Controllers\Finder\OfferPriceStoreController;
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
Route::get('import/{store_id}', ImportWbController::class)->name('api.import');
Route::post('offered-price', OfferPriceController::class)->name('api.offered-price');
Route::get('offered-price/store/{store_id}/{group_id}', OfferPriceStoreController::class)->name('api.offered-price.store');
Route::get('stock', [StockController::class, 'index'])->name('api.stock');

////GroupCalculatePrice routes
//Route::get('calculate-price', [GroupCalculatePriceController::class, 'index'])->name('api.calculate-price.index');
//Route::post('calculate-price', [GroupCalculatePriceController::class, 'store'])->name('api.calculate-price.store');
//Route::put('calculate-price/{group_id}', [GroupCalculatePriceController::class, 'update'])->name('api.calculate-price.update');
//Route::delete('calculate-price/{group_id}', [GroupCalculatePriceController::class, 'destroy'])->name('api.calculate-price.delete');

Route::prefix('calculate-price')->group(function () {
    Route::get('/', [GroupCalculatePriceController::class, 'index'])->name('api.calculate-price.index');
    Route::post('/', [GroupCalculatePriceController::class, 'store'])->name('api.calculate-price.store');
    Route::put('/{group_id}', [GroupCalculatePriceController::class, 'update'])->name('api.calculate-price.update');
    Route::delete('/{group_id}', [GroupCalculatePriceController::class, 'destroy'])->name('api.calculate-price.delete');
});
