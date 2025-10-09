<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return redirect()->route('sales-orders.index');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected
Route::middleware('auth')->group(function () {
    // Customers CRUD
    Route::resource('customers', CustomerController::class);

    // Sales Orders CRUD
    Route::resource('sales-orders', SalesOrderController::class);
});
