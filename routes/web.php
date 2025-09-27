<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;

// Route::get('', function () {
//     return view('home');
// })->name('home');

Route::get('/', [ItemController::class, 'getItemPage'])->name('home');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/submit', [AuthController::class, 'loginSubmit'])->name('login.submit');

Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/submit', [AuthController::class, 'registerSubmit'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');