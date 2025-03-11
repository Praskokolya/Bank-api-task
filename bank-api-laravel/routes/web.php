<?php

use App\Http\Controllers\AuthController;
use App\Repositories\AccountRepository;
use Illuminate\Auth\Events\Logout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use function PHPSTORM_META\map;

Route::get('/', function () {
    return view('welcome');
});
Route::get('auth/login', function () {
    return view('auth.login');
})->name('login');
Route::get('auth/register', function () {
    return view('auth.register');
});
Route::post('auth/register', [AuthController::class, 'register'])->name('auth.register');
Route::post('auth/login', [AuthController::class, 'login'])->name('auth.login.create');
Route::get('transfer', function(){
    return view('transfer');
});

Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('home');
    })->name('home');    
});