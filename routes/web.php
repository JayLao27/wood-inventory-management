<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('Auth.Login');
});

Route::get('/sales', function () {
    return view('Systems.sales');
})->middleware(['auth', 'verified'])->name('sales');


// In routes/web.php (already provided in artifacts)

// Customer API Routes
Route::get('/api/customers', [CustomerController::class, 'index']);
Route::post('/api/customers', [CustomerController::class, 'store']);
Route::put('/api/customers/{customer}', [CustomerController::class, 'update']);
Route::delete('/api/customers/{customer}', [CustomerController::class, 'destroy']);

// Sales Order API Routes
Route::get('/api/sales-orders', [SalesOrderController::class, 'index']);
Route::post('/api/sales-orders', [SalesOrderController::class, 'store']);
Route::put('/api/sales-orders/{salesOrder}', [SalesOrderController::class, 'update']);
Route::delete('/api/sales-orders/{salesOrder}', [SalesOrderController::class, 'destroy']);

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';