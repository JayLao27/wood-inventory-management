<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\SalesOrder;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $salesOrders = SalesOrder::with(['customer', 'items.product'])->latest()->get();
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('name')->get();

        return view('Systems.dashboard', compact('salesOrders', 'customers', 'products'));
    }
}
