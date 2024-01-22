<?php

use App\Http\Controllers\Finder\ImportWbController;
use App\Http\Controllers\Finder\OfferPriceController;
use Illuminate\Http\Request;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

//Finder routes
Route::get('import', ImportWbController::class)->name('api.import');
Route::post('offered-price', OfferPriceController::class)->name('api.offered-price');
