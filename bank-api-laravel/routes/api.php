<?php

use App\Http\Controllers\AccountController;
use Illuminate\Support\Facades\Route;

Route::group(['middleware' => 'auth:sanctum'], function () {
    Route::post('account/{currency}', [AccountController::class, 'create']);
    Route::get('accounts', [AccountController::class, 'index']);
    Route::put('transfer/{fromAccount}/{toNumber}', [AccountController::class, 'transfer'])->name('transfer');
});
