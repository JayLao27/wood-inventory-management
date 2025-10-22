<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

    // Auth
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.attempt');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Protected
    Route::middleware('auth')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    // Inventory    
    Route::get('/inventory', [InventoryController::class, 'index'])->name('inventory');
    // Sales
    Route::get('/sales', [DashboardController::class, 'index'])->name('sales');




    // Profile
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    


    // Customers CRUD
    Route::resource('customers', CustomerController::class);

    // Sales Orders CRUD
    Route::resource('sales-orders', SalesOrderController::class);
});
