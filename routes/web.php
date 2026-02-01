<?php

use App\Http\Controllers\AccountingController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SalesOrderController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\ProductionController;
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
    Route::get('/inventory/{id}/details', [InventoryController::class, 'getDetails'])->name('inventory.details');
    Route::get('/inventory/{id}/edit-product', action: [InventoryController::class, 'editProduct'])->name('inventory.edit-product');
    Route::put('/inventory/{id}', [InventoryController::class, 'update'])->name('inventory.update');
    Route::delete('/inventory/{id}/{type}', [InventoryController::class, 'destroy'])->name('inventory.destroy');
    Route::post('/inventory/{id}/adjust-stock', [InventoryController::class, 'adjustStock'])->name('inventory.adjust-stock');

    // Procurement
    Route::get('/procurement', [ProcurementController::class, 'index'])->name('procurement');
    Route::post('/procurement/suppliers', [ProcurementController::class, 'storeSupplier'])->name('procurement.supplier.store');
    Route::post('/procurement/purchase-orders', [ProcurementController::class, 'storePurchaseOrder'])->name('procurement.purchase-order.store');
    Route::get(
        '/procurement/purchase-orders/{purchaseOrder}/items',
        [ProcurementController::class, 'getPurchaseOrderItems']
    )->name('procurement.purchase-order.items');
    Route::post(
        '/procurement/purchase-orders/{purchaseOrder}/receive-stock',
        [ProcurementController::class, 'receiveStock']
    )->name('procurement.purchase-order.receive-stock');
    Route::get('/procurement/received-stock-reports', [ProcurementController::class, 'receivedStockReports'])->name('procurement.received-stock-reports');
    Route::put('/procurement/suppliers/{id}', [ProcurementController::class, 'updateSupplier'])->name('procurement.supplier.update');
    Route::put('/procurement/purchase-orders/{id}', [ProcurementController::class, 'updatePurchaseOrder'])->name('procurement.purchase-order.update');
    Route::delete('/procurement/suppliers/{id}', [ProcurementController::class, 'removeSupplier'])->name('procurement.supplier.destroy');
    Route::delete('/procurement/purchase-orders/{id}', [ProcurementController::class, 'destroyPurchaseOrder'])->name('procurement.purchase-order.destroy');

    // Production & Work Orders
    Route::get('/production', [ProductionController::class, 'index'])->name('production');
    Route::post('/production', [ProductionController::class, 'store'])->name('production.store');
    Route::put('/production/{workOrder}', [ProductionController::class, 'update'])->name('production.update');
    Route::post('/production/{workOrder}/start', [ProductionController::class, 'start'])->name('production.start');
    Route::post('/production/{workOrder}/complete', [ProductionController::class, 'complete'])->name('production.complete');
    
    // Sales
    Route::resource('sales-orders', SalesOrderController::class);
    Route::get('/sales', [DashboardController::class, 'index'])->name('sales');
    Route::delete('/sales/customers/{id}', [SalesOrderController::class, 'RemoveCustomer'])->name('customers.delete');
    Route::get('/sales/receipt/{orderNumber}', [SalesOrderController::class, 'exportReceipt'])->name('sales.receipt');
    Route::get('/sales/export/report', [SalesOrderController::class, 'exportSalesReport'])->name('sales.export.report');
    Route::get('/customers/export', [CustomerController::class, 'exportCustomers'])->name('customers.export');

    //Accounting
    Route::get('/accounting', [AccountingController::class, 'index'])->name('accounting');
    Route::post('/accounting/transaction', [AccountingController::class, 'salesTransaction'])->name('accounting.transaction.store');
    Route::get('/accounting/receipt/{transactionId}', [AccountingController::class, 'exportTransactionReceipt'])->name('accounting.receipt');
    Route::get('/accounting/export/financial-report', [AccountingController::class, 'exportFinancialReport'])->name('accounting.export.financial');
    Route::get('/accounting/export/transactions', [AccountingController::class, 'exportTransactionHistory'])->name('accounting.export.transactions');
        

    // Profile
    Route::get('/profile', function () {
        return view('profile.edit');
    })->name('profile.edit');
    


    // Customers CRUD
    Route::resource('customers', CustomerController::class);

});
