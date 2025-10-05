<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;

// Route::get('', function () {
//     return view('home');
// })->name('home');

Route::get('/', [ItemController::class, 'getItemPage'])->name('home');

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/submit', [AuthController::class, 'loginSubmit'])->name('login.submit');
Route::get('/register', [AuthController::class, 'register'])->name('register');
Route::post('/register/submit', [AuthController::class, 'registerSubmit'])->name('register.submit');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/profile', [AuthController::class, 'profile'])->name('profile');

Route::get('/items', [ItemController::class, 'getItemPage'])->name('items');
Route::get('/items/create', [ItemController::class, 'createItemPage'])->name('items.create');
Route::post('/items/create/submit', [ItemController::class, 'createItemSubmit'])->name('items.create.submit');
Route::get('/items/{id}/edit', [ItemController::class, 'editItemPage'])->name('items.edit');
Route::post('/items/{id}/edit/submit', [ItemController::class, 'editItemSubmit'])->name('items.edit.submit');
Route::post('/items/{id}/delete', [ItemController::class, 'deleteItem'])->name('items.delete');
Route::get('/items/{id}', [ItemController::class, 'viewItem'])->name('items.view');

// Transaction routes
Route::middleware('auth')->group(function () {
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::post('/items/{id}/mark-sold', [TransactionController::class, 'markAsSold'])->name('transaction.markSold');
    Route::get('/transactions/{id}/links', [TransactionController::class, 'showLinks'])->name('transaction.links');
    Route::post('/transactions/{id}/cancel', [TransactionController::class, 'cancel'])->name('transaction.cancel');
    Route::get('/transactions/{id}/report', [TransactionController::class, 'report'])->name('transaction.report');
});

// Public transaction confirmation (accessed via token)
Route::get('/transaction/confirm/{token}', [TransactionController::class, 'showConfirmation'])->name('transaction.confirm');
Route::post('/transaction/confirm/{token}', [TransactionController::class, 'confirm'])->name('transaction.confirm.submit');