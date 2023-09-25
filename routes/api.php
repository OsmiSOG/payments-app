<?php

use App\Http\Controllers\CardTokenizedController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\Transactioner\RunCheckoutController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('client')->group(function () {
        Route::get('/{client?}', [ClientController::class, 'get']);
        Route::post('/', [ClientController::class, 'store']);
        Route::put('/{client}', [ClientController::class, 'update']);
        Route::delete('/{client}', [ClientController::class, 'destroy']);
    });
    Route::prefix('transaction')->group(function () {
        Route::get('/{transaction}', [TransactionController::class, 'get']);
        Route::post('/', [TransactionController::class, 'store']);
        Route::put('/{transaction}', [TransactionController::class, 'update']);
    });
    Route::prefix('tokenized')->group(function () {
        Route::get('/{cardTokenized}', [CardTokenizedController::class, 'get']);
        Route::post('/', [CardTokenizedController::class, 'store']);
        Route::delete('/{cardTokenized}', [CardTokenizedController::class, 'destroy']);
    });
    Route::prefix('checkout')->group(function () {
        Route::post('/', [RunCheckoutController::class, 'normalPayment']);
        Route::post('/tokenized', [RunCheckoutController::class, 'tokenizedPayment']);
    });
});
