@extends('layouts.system')

@section('main-content')
    <!-- Main Content -->
    <div class="flex-1 p-8 bg-amber-50">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Procurement Management</h1>
                    <p class="text-gray-600 mt-2">Manage suppliers, purchase orders, and material sourcing</p>
                </div>
                <div class="flex space-x-3">
                    <button class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition">
                        Reports
                    </button>
                    <button class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition">
                        Receive Stock
                    </button>
                </div>
            </div>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
            <!-- Total Spent Card -->
            <div class="bg-slate-700 rounded-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Total Spent</h3>
                        <p class="text-3xl font-bold mt-2">₱{{ number_format($totalSpent, 2) }}</p>
                        <p class="text-slate-300 text-sm mt-1">All purchase orders</p>
                    </div>
                    <div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Payments Made Card -->
            <div class="bg-slate-700 rounded-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Payments Made</h3>
                        <p class="text-3xl font-bold mt-2 text-green-400">₱{{ number_format($paymentsMade, 2) }}</p>
                        <p class="text-slate-300 text-sm mt-1">Paid to suppliers</p>
                    </div>
                    <div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="bg-slate-700 rounded-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Pending Payments</h3>
                        <p class="text-3xl font-bold mt-2 text-orange-400">₱{{ number_format($pendingPayments, 2) }}</p>
                        <p class="text-slate-300 text-sm mt-1">Outstanding amount</p>
                    </div>
                    <div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Active Suppliers Card -->
            <div class="bg-slate-700 rounded-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Active Suppliers</h3>
                        <p class="text-3xl font-bold mt-2">{{ $activeSuppliers }}</p>
                        <p class="text-slate-300 text-sm mt-1">Verified suppliers</p>
                    </div>
                    <div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                    </div>
                </div>
            </div>

            <!-- Low Stock Alerts Card -->
            <div class="bg-slate-700 rounded-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Low Stock Alerts</h3>
                        <p class="text-3xl font-bold mt-2 text-red-400">{{ $lowStockAlerts }}</p>
                        <p class="text-slate-300 text-sm mt-1">Items requiring attention</p>
                    </div>
                    <div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <!-- Procurement Management Section -->
        <div class="bg-slate-700 rounded-lg p-6">
            <div class="flex justify-between items-center mb-6">
                <div>
                    <h2 class="text-xl font-bold text-white">Procurement Management</h2>
                    <p class="text-slate-300 text-sm mt-1">Manage purchase orders and supplier relationships</p>
                </div>
                <div id="purchaseOrdersButton" class="flex space-x-3">
                    <button onclick="openAddPurchaseOrderModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        <span> New Purchase Order</span>
                    </button>
                </div>
                <div id="suppliersButton" class="flex space-x-3 hidden">
                    <button onclick="openAddSupplierModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        <span> New Supplier</span>
                    </button>
                </div>
            </div>

            <!-- Search and Filter Bar -->
            <div class="flex justify-between items-center mb-6">
                <div class="flex-1 max-w-md">
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                        </div>
                        <input type="text" placeholder="Search order or suppliers....." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>
                <button class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 3a1 1 0 000 2h11.586l-1.293 1.293a1 1 0 101.414 1.414L16.414 6H19a1 1 0 100-2H3zM3 11a1 1 0 100 2h11.586l-1.293-1.293a1 1 0 111.414-1.414L16.414 14H19a1 1 0 100-2H3z"/>
                    </svg>
                    <span>All Status</span>
                </button>
                <button class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition ml-2">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 3a1 1 0 000 2h11.586l-1.293 1.293a1 1 0 101.414 1.414L16.414 6H19a1 1 0 100-2H3zM3 11a1 1 0 100 2h11.586l-1.293-1.293a1 1 0 111.414-1.414L16.414 14H19a1 1 0 100-2H3z"/>
                    </svg>
                    <span>All Payments</span>
                </button>
            </div>

            <!-- Tabs -->
            <div class="flex space-x-1 mb-6">
                <button onclick="showTab('purchase-orders')" id="purchase-orders-tab" class="px-[240px] py-2 rounded-lg" style="background-color: #FFF1DA; color: #111827;">PurchaseOrders</button>
                <button onclick="showTab('suppliers')" id="suppliers-tab" class="px-[240px] py-2 rounded-lg border" style="background-color: #374151; border: 1px solid #FFFFFF; color: #FFFFFF;">Suppliers</button>
            </div>

            <!-- Purchase Orders Table -->
            <div id="purchase-orders-table" class="overflow-x-auto">
                <table class="w-full text-white">
                    <thead>
                        <tr class="border-b border-slate-600">
                            <th class="text-left py-3 px-4 font-medium">Order #</th>
                            <th class="text-left py-3 px-4 font-medium">Supplier</th>
                            <th class="text-left py-3 px-4 font-medium">Order Date</th>
                            <th class="text-left py-3 px-4 font-medium">Expected Delivery</th>
                            <th class="text-left py-3 px-4 font-medium">Status</th>
                            <th class="text-left py-3 px-4 font-medium">Total Amount</th>
                            <th class="text-left py-3 px-4 font-medium">Payment Status</th>
                            <th class="text-left py-3 px-4 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-600">
                        @forelse($purchaseOrders ?? [] as $order)
                        <tr class="hover:bg-slate-600 cursor-pointer">
                            <td class="py-3 px-4">{{ $order->order_number ?? 'PO-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="py-3 px-4">{{ $order->supplier->name }}</td>
                            <td class="py-3 px-4">{{ $order->order_date->format('m/d/Y') }}</td>
                            <td class="py-3 px-4">{{ $order->expected_delivery->format('m/d/Y') }}</td>
                            <td class="py-3 px-4">
                                @if($order->status === 'Delivered')
                                    <span class="text-green-400">{{ $order->status }}</span>
                                @elseif($order->status === 'Confirmed')
                                    <span class="text-blue-400">{{ $order->status }}</span>
                                @elseif($order->status === 'Overdue')
                                    <span class="text-red-400">{{ $order->status }}</span>
                                @else
                                    <span class="text-gray-300">{{ $order->status }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">₱{{ number_format($order->total_amount, 2) }}</td>
                            <td class="py-3 px-4">
                                @if($order->payment_status === 'Paid')
                                    <span class="text-green-400">{{ $order->payment_status }}</span>
                                @elseif($order->payment_status === 'Partial')
                                    <span class="text-orange-400">{{ $order->payment_status }}</span>
                                @else
                                    <span class="text-gray-300">{{ $order->payment_status }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button onclick="event.stopPropagation(); viewOrder({{ $order->id }})" class="p-1 hover:bg-slate-500 rounded">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                            <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                    <button onclick="event.stopPropagation(); editOrder({{ $order->id }})" class="p-1 hover:bg-slate-500 rounded">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </button>
                                    <button onclick="event.stopPropagation(); deleteOrder({{ $order->id }})" class="p-1 hover:bg-slate-500 rounded">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" class="py-8 px-4 text-center text-slate-400">No purchase orders found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Suppliers Table -->
            <div id="suppliers-table" class="overflow-x-auto hidden">
                <table class="w-full text-white">
                    <thead>
                        <tr class="border-b border-slate-600">
                            <th class="text-left py-3 px-4 font-medium">Name</th>
                            <th class="text-left py-3 px-4 font-medium">Contact Person</th>
                            <th class="text-left py-3 px-4 font-medium">Phone</th>
                            <th class="text-left py-3 px-4 font-medium">Email</th>
                            <th class="text-left py-3 px-4 font-medium">Payment Terms</th>
                            <th class="text-left py-3 px-4 font-medium">Status</th>
                            <th class="text-left py-3 px-4 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-600">
                        @forelse($suppliers ?? [] as $supplier)
                        <tr class="hover:bg-slate-600 cursor-pointer">
                            <td class="py-3 px-4">{{ $supplier->name }}</td>
                            <td class="py-3 px-4">{{ $supplier->contact_person }}</td>
                            <td class="py-3 px-4">{{ $supplier->phone }}</td>
                            <td class="py-3 px-4">{{ $supplier->email }}</td>
                            <td class="py-3 px-4">{{ $supplier->payment_terms }}</td>
                            <td class="py-3 px-4">
                                @if($supplier->status === 'active')
                                    <span class="text-green-400">{{ ucfirst($supplier->status) }}</span>
                                @else
                                    <span class="text-red-400">{{ ucfirst($supplier->status) }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button onclick="event.stopPropagation(); editSupplier({{ $supplier->id }})" class="p-1 hover:bg-slate-500 rounded">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                        </svg>
                                    </button>
                                    <button onclick="event.stopPropagation(); deleteSupplier({{ $supplier->id }})" class="p-1 hover:bg-slate-500 rounded">
                                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-8 px-4 text-center text-slate-400">No suppliers found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Add Supplier Modal -->
    <div id="addSupplierModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Add New Supplier</h3>
                        <button onclick="closeAddSupplierModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="addSupplierForm" method="POST" action="{{ route('procurement.supplier.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Company Name *</label>
                                <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Contact Person *</label>
                                <input type="text" name="contact_person" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Phone *</label>
                                <input type="text" name="phone" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Email *</label>
                                <input type="email" name="email" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Payment Terms *</label>
                                <select name="payment_terms" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Select Payment Terms</option>
                                    <option value="Net 15">Net 15</option>
                                    <option value="Net 30">Net 30</option>
                                    <option value="Net 45">Net 45</option>
                                    <option value="Net 60">Net 60</option>
                                    <option value="Cash on Delivery">Cash on Delivery</option>
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Status</label>
                                <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                            
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-gray-700 mb-2">Address *</label>
                                <textarea name="address" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required></textarea>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeAddSupplierModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Add Supplier
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Purchase Order Modal -->
    <div id="addPurchaseOrderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Add New Purchase Order</h3>
                        <button onclick="closeAddPurchaseOrderModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="addPurchaseOrderForm" method="POST" action="{{ route('procurement.purchase-order.store') }}">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Supplier *</label>
                                <select name="supplier_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Select Supplier</option>
                                    @foreach($suppliers ?? [] as $supplier)
                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Order Date *</label>
                                <input type="date" name="order_date" value="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Expected Delivery *</label>
                                <input type="date" name="expected_delivery" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Order Items</h4>
                            <div id="orderItems">
                                <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Material *</label>
                                        <select name="items[0][material_id]" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                            <option value="">Select Material</option>
                                            @foreach($materials ?? [] as $material)
                                                <option value="{{ $material->id }}" data-price="{{ $material->unit_cost }}">{{ $material->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                                        <input type="number" name="items[0][quantity]" step="0.01" min="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price *</label>
                                        <input type="number" name="items[0][unit_price]" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    </div>
                                    
                                    <div class="flex items-end">
                                        <button type="button" onclick="removeItem(this)" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                                            Remove
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <button type="button" onclick="addItem()" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                                + Add Item
                            </button>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeAddPurchaseOrderModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Create Purchase Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functionality
        function showTab(tab) {
            const purchaseOrdersTab = document.getElementById('purchase-orders-tab');
            const suppliersTab = document.getElementById('suppliers-tab');
            const purchaseOrdersTable = document.getElementById('purchase-orders-table');
            const suppliersTable = document.getElementById('suppliers-table');
            const purchaseOrdersButton = document.getElementById('purchaseOrdersButton');
            const suppliersButton = document.getElementById('suppliersButton');
            
            if (tab === 'purchase-orders') {
                purchaseOrdersTab.style.backgroundColor = '#FFF1DA';
                purchaseOrdersTab.style.color = '#111827';
                purchaseOrdersTab.style.border = 'none';
                suppliersTab.style.backgroundColor = '#374151';
                suppliersTab.style.color = '#FFFFFF';
                suppliersTab.style.border = '1px solid #FFFFFF';
                purchaseOrdersTable.classList.remove('hidden');
                suppliersTable.classList.add('hidden');
                purchaseOrdersButton.classList.remove('hidden');
                suppliersButton.classList.add('hidden');
            } else {
                suppliersTab.style.backgroundColor = '#FFF1DA';
                suppliersTab.style.color = '#111827';
                suppliersTab.style.border = 'none';
                purchaseOrdersTab.style.backgroundColor = '#374151';
                purchaseOrdersTab.style.color = '#FFFFFF';
                purchaseOrdersTab.style.border = '1px solid #FFFFFF';
                suppliersTable.classList.remove('hidden');
                purchaseOrdersTable.classList.add('hidden');
                purchaseOrdersButton.classList.add('hidden');
                suppliersButton.classList.remove('hidden');
            }
        }

        // Modal functions
        function openAddSupplierModal() {
            document.getElementById('addSupplierModal').classList.remove('hidden');
        }

        function closeAddSupplierModal() {
            document.getElementById('addSupplierModal').classList.add('hidden');
            document.getElementById('addSupplierForm').reset();
        }

        function openAddPurchaseOrderModal() {
            document.getElementById('addPurchaseOrderModal').classList.remove('hidden');
        }

        function closeAddPurchaseOrderModal() {
            document.getElementById('addPurchaseOrderModal').classList.add('hidden');
            document.getElementById('addPurchaseOrderForm').reset();
        }

        // Purchase Order Item Management
        let itemCount = 1;

        function addItem() {
            const container = document.getElementById('orderItems');
            const newItem = document.createElement('div');
            newItem.className = 'grid grid-cols-1 md:grid-cols-4 gap-4 mb-4';
            newItem.innerHTML = `
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Material *</label>
                    <select name="items[${itemCount}][material_id]" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                        <option value="">Select Material</option>
                        @foreach($materials ?? [] as $material)
                            <option value="{{ $material->id }}" data-price="{{ $material->unit_cost }}">{{ $material->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                    <input type="number" name="items[${itemCount}][quantity]" step="0.01" min="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price *</label>
                    <input type="number" name="items[${itemCount}][unit_price]" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>
                
                <div class="flex items-end">
                    <button type="button" onclick="removeItem(this)" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Remove
                    </button>
                </div>
            `;
            container.appendChild(newItem);
            itemCount++;
        }

        function removeItem(button) {
            button.closest('.grid').remove();
        }

        // Action functions
        function viewOrder(id) {
            // Implement view order functionality
            console.log('View order:', id);
        }

        function editOrder(id) {
            // Implement edit order functionality
            console.log('Edit order:', id);
        }

        function deleteOrder(id) {
            if (confirm('Are you sure you want to delete this purchase order?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/procurement/purchase-orders/${id}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        function editSupplier(id) {
            // Implement edit supplier functionality
            console.log('Edit supplier:', id);
        }

        function deleteSupplier(id) {
            if (confirm('Are you sure you want to delete this supplier?')) {
                const form = document.createElement('form');
                form.method = 'POST';
                form.action = `/procurement/suppliers/${id}`;
                
                const csrfToken = document.createElement('input');
                csrfToken.type = 'hidden';
                csrfToken.name = '_token';
                csrfToken.value = '{{ csrf_token() }}';
                
                const methodField = document.createElement('input');
                methodField.type = 'hidden';
                methodField.name = '_method';
                methodField.value = 'DELETE';
                
                form.appendChild(csrfToken);
                form.appendChild(methodField);
                document.body.appendChild(form);
                form.submit();
            }
        }

        // Initialize tab state on page load
        document.addEventListener('DOMContentLoaded', function() {
            showTab('purchase-orders');
            const purchaseOrdersTab = document.getElementById('purchase-orders-tab');
            purchaseOrdersTab.style.borderRadius = '10px';
            const suppliersTab = document.getElementById('suppliers-tab');
            suppliersTab.style.borderRadius = '10px';
        });
    </script>
@endsection
