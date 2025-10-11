<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PaymentController;

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
    
    // Rating routes
    Route::post('/transactions/{id}/rate', [\App\Http\Controllers\RatingController::class, 'store'])->name('rating.store');
});

// Public transaction confirmation (accessed via token)
Route::get('/transaction/confirm/{token}', [TransactionController::class, 'showConfirmation'])->name('transaction.confirm');
Route::post('/transaction/confirm/{token}', [TransactionController::class, 'confirm'])->name('transaction.confirm.submit');

// Premium listing & payment routes
Route::middleware('auth')->group(function () {
    Route::get('/items/{id}/premium/packages', [PaymentController::class, 'showPackages'])->name('premium.packages');
    Route::post('/items/{id}/premium/payment', [PaymentController::class, 'createPayment'])->name('premium.createPayment');
    Route::get('/payment/{id}/checkout', [PaymentController::class, 'checkout'])->name('payment.checkout');
    Route::get('/payment/{id}/finish', [PaymentController::class, 'finish'])->name('payment.finish');
    Route::get('/payment/{id}/status', [PaymentController::class, 'checkStatus'])->name('payment.status');
});

// Midtrans notification callback (no auth required)
Route::post('/payment/notification', [PaymentController::class, 'notification'])->name('payment.notification');

// Admin routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::get('/analytics', [AdminController::class, 'analytics'])->name('analytics');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
    Route::post('/users/{user}/toggle-admin', [AdminController::class, 'toggleAdmin'])->name('users.toggleAdmin');
    Route::get('/listings', [AdminController::class, 'listings'])->name('listings');
    Route::delete('/listings/{item}', [AdminController::class, 'deleteListing'])->name('listings.delete');
    Route::get('/transactions', [AdminController::class, 'transactions'])->name('transactions');
});