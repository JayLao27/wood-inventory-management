<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcurementController;
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
    Route::post('/inventory', [InventoryController::class, 'store'])->name('inventory.store');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}/{type}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/{id}/adjust-stock', [InventoryController::class, 'adjustStock'])->name('inventory.adjust-stock');
    // Procurement
    Route::get('/procurement', [ProcurementController::class, 'index'])->name('procurement');
    Route::post('/procurement/suppliers', [ProcurementController::class, 'storeSupplier'])->name('procurement.supplier.store');
    Route::post('/procurement/purchase-orders', [ProcurementController::class, 'storePurchaseOrder'])->name('procurement.purchase-order.store');
    Route::put('/procurement/suppliers/{id}', [ProcurementController::class, 'updateSupplier'])->name('procurement.supplier.update');
    Route::put('/procurement/purchase-orders/{id}', [ProcurementController::class, 'updatePurchaseOrder'])->name('procurement.purchase-order.update');
    Route::delete('/procurement/suppliers/{id}', [ProcurementController::class, 'destroySupplier'])->name('procurement.supplier.destroy');
    Route::delete('/procurement/purchase-orders/{id}', [ProcurementController::class, 'destroyPurchaseOrder'])->name('procurement.purchase-order.destroy');
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
