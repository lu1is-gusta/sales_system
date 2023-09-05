<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\SalesAndSellerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('sales', [SalesAndSellerController::class, 'index']);
Route::post('sales', [SalesAndSellerController::class, 'storeSale']);
Route::get('sales/{id}', [SalesAndSellerController::class, 'showSale']);
Route::get('sales/{id}/edit', [SalesAndSellerController::class, 'editSale']);
Route::put('sales/{id}/edit', [SalesAndSellerController::class, 'updateSale']);
Route::delete('sales/{id}/delete', [SalesAndSellerController::class, 'deleteSale']);