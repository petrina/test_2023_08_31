<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\UserController;
use \App\Http\Middleware\AuthMiddleware;
use \App\Http\Controllers\WalletController;
use \App\Http\Controllers\SellController;

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

Route::post('auth', [UserController::class, 'authentication']);
Route::middleware(AuthMiddleware::class)->group(function () {
    Route::get('wallets', [WalletController::class, 'store']);
    Route::post('wallets/{id}/sell', [SellController::class, 'create']);
    Route::get('sells', [SellController::class, 'store']);
    Route::get('sells/{id}/approve', [SellController::class, 'approve']);
});

Route::get('report', [SellController::class, 'report']);
