<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Material;
use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\SalesOrder;
use App\Models\WorkOrder;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $salesOrders = SalesOrder::with(['customer', 'items.product'])->latest()->get();
        $customers = Customer::orderBy('name')->get();
        $products = Product::orderBy('product_name')->get();

        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();
        $startOfLastMonth = $now->copy()->subMonth()->startOfMonth();
        $endOfLastMonth = $now->copy()->subMonth()->endOfMonth();
        $startOfWeek = $now->copy()->startOfWeek();

        // Revenue & income (from sales)
        $totalRevenue = (float) SalesOrder::sum('total_amount');
        $revenueThisMonth = (float) SalesOrder::whereBetween('order_date', [$startOfMonth, $endOfMonth])->sum('total_amount');
        $revenueLastMonth = (float) SalesOrder::whereBetween('order_date', [$startOfLastMonth, $endOfLastMonth])->sum('total_amount');
        $income = $totalRevenue; // income = revenue from sales

        $revenueChangePercent = $revenueLastMonth > 0
            ? round((($revenueThisMonth - $revenueLastMonth) / $revenueLastMonth) * 100, 1)
            : ($revenueThisMonth > 0 ? 100 : 0);

        // Expenses (from purchase orders)
        $totalExpenses = (float) PurchaseOrder::sum('total_amount');
        $expensesThisMonth = (float) PurchaseOrder::whereBetween('order_date', [$startOfMonth, $endOfMonth])->sum('total_amount');
        $expensesLastMonth = (float) PurchaseOrder::whereBetween('order_date', [$startOfLastMonth, $endOfLastMonth])->sum('total_amount');
        $expensesChangePercent = $expensesLastMonth > 0
            ? round((($expensesThisMonth - $expensesLastMonth) / $expensesLastMonth) * 100, 1)
            : ($expensesThisMonth > 0 ? 100 : 0);

        // Net profit
        $netProfit = $totalRevenue - $totalExpenses;
        $netProfitThisMonth = $revenueThisMonth - $expensesThisMonth;
        $netProfitLastMonth = $revenueLastMonth - $expensesLastMonth;
        $netProfitChangePercent = $netProfitLastMonth != 0
            ? round((($netProfitThisMonth - $netProfitLastMonth) / abs($netProfitLastMonth)) * 100, 1)
            : ($netProfitThisMonth != 0 ? 100 : 0);

       
        // In production (work orders)
        $inProductionCount = WorkOrder::whereIn('status', ['in_progress', 'quality_check'])->count();
        $overdueWorkOrders = WorkOrder::whereNotIn('status', ['completed'])
            ->where('due_date', '<', $now->toDateString())
            ->count();

        // Active/new orders
        $activeOrdersCount = SalesOrder::whereIn('status', ['Pending', 'In production', 'Ready'])->count();
        $newOrdersThisWeek = SalesOrder::whereDate('order_date', '>=', $startOfWeek)->count();

        // Low stock (materials + products)
        $lowStockMaterials = Material::whereRaw('current_stock <= minimum_stock')->orderBy('current_stock')->get();
        $lowStockCount = $lowStockMaterials->count();

        // Sales report: last 6 months by month
        $salesReportMonths = collect();
        $salesReportRevenue = collect();
        $salesReportExpenses = collect();
        for ($i = 5; $i >= 0; $i--) {
            $month = $now->copy()->subMonths($i);
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();
            $salesReportMonths->push($month->format('M Y'));
            $salesReportRevenue->push((float) SalesOrder::whereBetween('order_date', [$start, $end])->sum('total_amount'));
            $salesReportExpenses->push((float) PurchaseOrder::whereBetween('order_date', [$start, $end])->sum('total_amount'));
        }

        // Chart data (last 6 months)
        $chartLabels = $salesReportMonths->toArray();
        $chartRevenue = $salesReportRevenue->toArray();
        $chartExpenses = $salesReportExpenses->toArray();
        $chartProfit = $salesReportRevenue->zip($salesReportExpenses)->map(fn ($p) => $p[0] - $p[1])->values()->toArray();

        return view('Systems.dashboard', compact(
            'salesOrders',
            'customers',
            'products',
            'totalRevenue',
            'revenueChangePercent',
            'income',
            'totalExpenses',
            'expensesChangePercent',
            'netProfit',
            'netProfitChangePercent',
            'activeOrdersCount',
            'newOrdersThisWeek',
            'inProductionCount',
            'overdueWorkOrders',
            'lowStockCount',
            'lowStockMaterials',
            'chartLabels',
            'chartRevenue',
            'chartExpenses',
            'chartProfit',
            'salesReportMonths',
            'salesReportRevenue',
            'salesReportExpenses'
        ));
    }
}
