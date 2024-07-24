<?php

use App\Http\Controllers\Api\AccountController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\TransactionController;
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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware('auth:sanctum')->group(function () {
    // Auth
    Route::get('auth/user', [AuthController::class, 'user']);
    Route::post('auth/logout', [AuthController::class, 'logout']);

    // Dashboard
    Route::get('dashboard.admin', [DashboardController::class, 'admin']);
    Route::get('dashboard.customer', [DashboardController::class, 'customer']);

    // Accounts
    Route::get('accounts', [AccountController::class, 'index']);
    Route::post('accounts', [AccountController::class, 'store']);
    Route::get('accounts/{user}', [AccountController::class, 'show']);
    Route::put('accounts/{user}', [AccountController::class, 'update']);
    Route::delete('accounts/{user}', [AccountController::class, 'destroy']);

    // Transaction
    Route::get('transactions', [TransactionController::class, 'index']);
    Route::put('transactions/deposit', [TransactionController::class, 'deposit']);
    Route::put('transactions/withdraw', [TransactionController::class, 'withdraw']);
    Route::put('transactions/transfer', [TransactionController::class, 'transfer']);
});

Route::post('auth/login', [AuthController::class, 'login'])->middleware('guest');
