@extends('layouts.system')

@section('main-content')
    <!-- Main Content -->
    <div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Procurement Management</h1>
                    <p class="text-gray-600 mt-2">Manage suppliers, purchase orders, and material sourcing</p>
                </div>
                @php
                    $receiveCount = is_countable($openPurchaseOrders ?? $purchaseOrders ?? [])
                        ? count($openPurchaseOrders ?? $purchaseOrders ?? [])
                        : 0;
                @endphp
                <div class="flex space-x-3">
                    <button onclick="openReceivedStockReportsModal()" class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition">
                        Reports
                    </button>
                    <button onclick="openReceiveStockModal()" class="relative px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition">
                        Receive Stock
                        @if($receiveCount > 0)
                            <span class="absolute -top-2 -right-2 min-w-[1.5rem] h-6 px-1 rounded-full border-2 border-red-500 text-red-600 bg-white text-xs font-bold flex items-center justify-center">
                                {{ $receiveCount }}
                            </span>
                        @endif
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
                        @php
                            $totalSpentFormatted = number_format($totalSpent, 0);
                            $totalSpentLength = strlen($totalSpentFormatted);
                            $totalSpentSize = $totalSpentLength > 15 ? 'text-lg' : ($totalSpentLength > 12 ? 'text-xl' : 'text-2xl');
                        @endphp
                        <p class="{{ $totalSpentSize }} font-bold mt-2">₱{{ $totalSpentFormatted }}</p>
                        <p class="text-slate-300 text-sm mt-1">All purchase orders</p>
                    </div>
                    <div>
                      @include('components.icons.dollar', ['class' => 'icon-dollar'])
                    </div>
                </div>
            </div>

            <!-- Payments Made Card -->
            <div class="bg-slate-700 rounded-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Payments Made</h3>
                        @php
                            $paymentsMadeFormatted = number_format($paymentsMade, 0);
                            $paymentsMadeLength = strlen($paymentsMadeFormatted);
                            $paymentsMadeSize = $paymentsMadeLength > 15 ? 'text-lg' : ($paymentsMadeLength > 12 ? 'text-xl' : 'text-2xl');
                        @endphp
                        <p class="{{ $paymentsMadeSize }} font-bold mt-2 text-green-400">₱{{ $paymentsMadeFormatted }}</p>
                        <p class="text-slate-300 text-sm mt-1">Paid to suppliers</p>
                    </div>
                    <div >
                        @include('components.icons.dollar', ['class' => 'icon-dollar'])
                    </div>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="bg-slate-700 rounded-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Pending Payments</h3>
                        @php
                            $pendingPaymentsFormatted = number_format($pendingPayments, 0);
                            $pendingPaymentsLength = strlen($pendingPaymentsFormatted);
                            $pendingPaymentsSize = $pendingPaymentsLength > 15 ? 'text-lg' : ($pendingPaymentsLength > 12 ? 'text-xl' : 'text-2xl');
                        @endphp
                        <p class="{{ $pendingPaymentsSize }} font-bold mt-2 text-orange-400">₱{{ $pendingPaymentsFormatted }}</p>
                        <p class="text-slate-300 text-sm mt-1">Outstanding amount</p>
                    </div>
                    <div >
                         @include('components.icons.dollar', ['class' => 'icon-dollar'])
                    </div>
                </div>
            </div>

            <!-- Active Suppliers Card -->
            <div class="bg-slate-700 rounded-lg p-6 text-white">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-sm font-medium text-slate-300">Suppliers</h3>
                        <p class="text-3xl font-bold mt-2">{{ $activeSuppliers }}</p>
                        <p class="text-slate-300 text-sm mt-1">Suppliers</p>
                    </div>
                    <div>
                      @include('components.icons.cart', ['class' => 'icon-cart'])
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
                    <div >
                        @include('components.icons.cart', ['class' => 'icon-cart'])
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
                    <button onclick="openAddPurchaseOrderModal()" class="px-4 py-2  bg-white text-[#374151] rounded-lg hover:bg-[#DEE4EF] transition flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        <span> New Purchase Order</span>
                    </button>
                </div>
                <div id="suppliersButton" class="flex space-x-3 hidden">
                    <button onclick="openAddSupplierModal()" class="px-4 py-2 bg-white text-[#374151] rounded-lg hover:bg-[#DEE4EF] transition flex items-center space-x-2">
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
                        <input id="searchInput" type="text" placeholder="Search orders or suppliers..." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    </div>
                </div>

                <div class="flex items-center space-x-2">
                    <select id="statusFilter" class="px-3 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
                        <option value="all">All Status</option>
                        <option value="paid">Paid</option>
                        <option value="partial">Partial</option>
                        <option value="pending">Pending</option>
                    </select>

                    
                </div>
            </div>

            <!-- Tabs -->
            <div class="flex space-x-1 mb-6">
                <button onclick="showTab('purchase-orders')" id="purchase-orders-tab" class="flex-auto px-[240px] py-2 rounded-lg" style="background-color: #FFF1DA; color: #111827;">Orders</button>
                <button onclick="showTab('suppliers')" id="suppliers-tab" class="flex-auto px-[240px] py-2 rounded-lg border" style="background-color: #374151; border: 1px solid #FFFFFF; color: #FFFFFF;">Suppliers</button>
            </div>

            <!-- Purchase Orders Table -->
            <div id="purchase-orders-table" class="overflow-y-auto" style="max-height: 60vh;">
                <table class="w-full border-collapse text-left text-sm text-white">
                    <thead class="bg-slate-800 text-slate-300 sticky top-0">
                        <tr>
                            <th class="px-4 py-3 font-medium">Order #</th>
                            <th class="px-4 py-3 font-medium">Supplier</th>
                            <th class="px-4 py-3 font-medium">Order Date</th>
                            <th class="px-4 py-3 font-medium">Expected Delivery</th>
                            <th class="px-4 py-3 font-medium">Total Amount</th>
                            <th class="px-4 py-3 font-medium">Payment Status</th>
                            <th class="px-4 py-3 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-600">
                        @forelse($purchaseOrders ?? [] as $order)
                        <tr class="hover:bg-slate-600 transition cursor-pointer">
                            <td class="px-4 py-3 font-mono text-slate-300">{{ $order->order_number ?? 'PO-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }}</td>
                            <td class="px-4 py-3 text-slate-300 font-medium">{{ $order->supplier->name }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $order->order_date->format('M d, Y') }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $order->expected_delivery->format('M d, Y') }}</td>
                            <td class="px-4 py-3 font-bold text-slate-300">₱{{ number_format($order->total_amount, 2) }}</td>
                            <td class="px-4 py-3">
                                @if($order->payment_status === 'Paid')
                                    <span class="text-xs font-semibold text-green-400">{{ $order->payment_status }}</span>
                                @elseif($order->payment_status === 'Partial')
                                    <span class="text-xs font-semibold text-yellow-400">{{ $order->payment_status }}</span>
                                @else
                                    <span class="text-xs font-semibold text-slate-400">{{ $order->payment_status }}</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex space-x-2">
                                    <button onclick="event.stopPropagation(); openViewOrderModal({{ $order->id }})" class="p-1 hover:bg-slate-500 rounded" title="View Items">
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
            <div id="suppliers-table" class="overflow-y-auto hidden" style="max-height: 60vh;">
                <table class="w-full border-collapse text-left text-sm text-white">
                    <thead class="bg-slate-800 text-slate-300 sticky top-0">
                        <tr>
                            <th class="px-4 py-3 font-medium">Name</th>
                            <th class="px-4 py-3 font-medium">Contact Person</th>
                            <th class="px-4 py-3 font-medium">Phone</th>
                            <th class="px-4 py-3 font-medium">Email</th>
                            <th class="px-4 py-3 font-medium">Payment Terms</th>
                            <th class="px-4 py-3 font-medium">Status</th>
                            <th class="px-4 py-3 font-medium">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-600">
                        @forelse($suppliers ?? [] as $supplier)
                        <tr class="hover:bg-slate-600 transition cursor-pointer">
                            <td class="px-4 py-3 font-medium text-slate-300">{{ $supplier->name }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $supplier->contact_person }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $supplier->phone }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $supplier->email }}</td>
                            <td class="px-4 py-3 text-slate-300">{{ $supplier->payment_terms }}</td>
                            <td class="px-4 py-3">
                                @if($supplier->status === 'active')
                                    <span class="text-xs font-semibold text-green-400">{{ ucfirst($supplier->status) }}</span>
                                @else
                                    <span class="text-xs font-semibold text-red-400">{{ ucfirst($supplier->status) }}</span>
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
                                <label class="block text-sm font-medium text-gray-700 mb-2">Supplier Name *</label>
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
                                        <select name="items[0][material_id]" class="material-select w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                            <option value="">Select Material</option>
                                            @foreach($materials ?? [] as $material)
                                                <option value="{{ $material->id }}" data-price="{{ $material->unit_cost }}">{{ $material->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                                        <input type="number" name="items[0][quantity]" step="1" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 mb-2">Unit Price *</label>
                                        <input type="number" name="items[0][unit_price]" step="0.01" min="0" placeholder="0.00" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
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

    <!-- Receive Stock Modal -->
    <div id="receiveStockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Receive Stock</h3>
                        <button onclick="closeReceiveStockModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="receiveStockForm" method="POST">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Purchase Order *</label>
                                <select name="purchase_order_id" id="purchaseOrderSelect" onchange="loadPurchaseOrderItems(this.value)" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                    <option value="">Select Purchase Order</option>
                                    @foreach(($openPurchaseOrders ?? $purchaseOrders ?? []) as $order)
                                        <option value="{{ $order->id }}" data-order-id="{{ $order->id }}">{{ $order->order_number ?? 'PO-' . str_pad($order->id, 6, '0', STR_PAD_LEFT) }} - {{ $order->supplier->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Received Date *</label>
                                <input type="date" name="received_date" value="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <h4 class="text-lg font-medium text-gray-900 mb-4">Items to Receive</h4>
                            <div id="receiveStockItems" class="overflow-y-auto" style="max-height: 50vh;">
                                <p class="text-gray-500 text-center py-8">Please select a purchase order to view items</p>
                            </div>
                        </div>
                        
                        <div class="mb-6">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                            <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Add any notes about this delivery..."></textarea>
                        </div>
                        
                        <div class="flex justify-end space-x-3 mt-6">
                            <button type="button" onclick="closeReceiveStockModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                Cancel
                            </button>
                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                Receive Stock
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Order Items Modal -->
    <div id="viewOrderItemsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Order Items</h3>
                        <button onclick="closeViewOrderItemsModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <div class="mb-6">
                        <div class="grid grid-cols-2 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Order Number</label>
                                <p id="viewOrderNumber" class="text-gray-900 font-medium">-</p>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                                <p id="viewSupplierName" class="text-gray-900 font-medium">-</p>
                            </div>
                        </div>
                        
                        <h4 class="text-lg font-medium text-gray-900 mb-4">Items</h4>
                        <div class="overflow-x-auto border border-gray-200 rounded-lg">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100 border-b border-gray-200">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-medium text-gray-700">Material</th>
                                        <th class="px-4 py-3 text-right font-medium text-gray-700">Ordered</th>
                                        <th class="px-4 py-3 text-right font-medium text-gray-700">Received</th>
                                        <th class="px-4 py-3 text-right font-medium text-gray-700">Remaining</th>
                                        <th class="px-4 py-3 text-right font-medium text-gray-700">Unit Price</th>
                                        <th class="px-4 py-3 text-right font-medium text-gray-700">Total</th>
                                    </tr>
                                </thead>
                                <tbody id="viewOrderItemsTable" class="divide-y divide-gray-200">
                                    <tr>
                                        <td colspan="6" class="px-4 py-8 text-center text-gray-500">Loading items...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <div class="flex justify-end">
                        <button type="button" onclick="closeViewOrderItemsModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Received Stock Reports Modal -->
    <div id="receivedStockReportsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-white rounded-lg max-w-6xl w-full max-h-[90vh] overflow-y-auto">
                <div class="p-6">
                    <div class="flex justify-between items-center mb-4">
                        <h3 class="text-xl font-bold text-gray-900">Received Stock Reports</h3>
                        <button onclick="closeReceivedStockReportsModal()" class="text-gray-400 hover:text-gray-600">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <!-- Filter Section -->
                    <div class="mb-4 flex gap-4">
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date From</label>
                            <input type="date" id="filterDateFrom" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Date To</label>
                            <input type="date" id="filterDateTo" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                        <div class="flex-1">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Material</label>
                            <select id="filterMaterial" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                                <option value="">All Materials</option>
                            </select>
                        </div>
                        <div class="flex items-end">
                            <button onclick="filterReceivedStock()" class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition">
                                Filter
                            </button>
                        </div>
                    </div>

                    <!-- Reports Table -->
                    <div class="overflow-x-auto">
                        <table class="w-full border-collapse text-left text-sm">
                            <thead class="bg-gray-100 text-gray-700">
                                <tr>
                                    <th class="px-4 py-3 font-medium">Date</th>
                                    <th class="px-4 py-3 font-medium">PO Number</th>
                                    <th class="px-4 py-3 font-medium">Material</th>
                                    <th class="px-4 py-3 font-medium">Quantity</th>
                                    <th class="px-4 py-3 font-medium">Defect Qty</th>
                                    <th class="px-4 py-3 font-medium">Supplier</th>
                                    <th class="px-4 py-3 font-medium">Status</th>
                                    <th class="px-4 py-3 font-medium">Notes</th>
                                </tr>
                            </thead>
                            <tbody id="receivedStockTableBody" class="divide-y divide-gray-200">
                                <tr>
                                    <td colspan="8" class="py-8 px-4 text-center text-gray-400">Loading...</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary Section -->
                    <div class="mt-6 p-4 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-3 gap-4">
                            <div>
                                <p class="text-sm text-gray-600">Total Received</p>
                                <p id="totalReceived" class="text-xl font-bold text-gray-900">0</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Total Defects</p>
                                <p id="totalDefects" class="text-xl font-bold text-red-600">0</p>
                            </div>
                            <div>
                                <p class="text-sm text-gray-600">Net Quantity</p>
                                <p id="netQuantity" class="text-xl font-bold text-green-600">0</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Tab functions
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

        function openReceiveStockModal() {
            document.getElementById('receiveStockModal').classList.remove('hidden');
        }

        function closeReceiveStockModal() {
            document.getElementById('receiveStockModal').classList.add('hidden');
            document.getElementById('receiveStockForm').reset();
            document.getElementById('receiveStockItems').innerHTML = '<p class="text-gray-500 text-center py-8">Please select a purchase order to view items</p>';
        }

        function loadPurchaseOrderItems(orderId) {
            const container = document.getElementById('receiveStockItems');

            if (!orderId) {
                container.innerHTML = '<p class="text-gray-500 text-center py-8">Please select a purchase order to view items</p>';
                return;
            }

            container.innerHTML = '<p class="text-gray-500 text-center py-8">Loading items...</p>';

            fetch(`/procurement/purchase-orders/${orderId}/items`)
                .then(response => response.json())  
                .then(data => {
                    if (!data.success || !data.items || data.items.length === 0) {
                        container.innerHTML = '<p class="text-gray-500 text-center py-8">No remaining items to receive for this purchase order.</p>';
                        return;
                    }

                    // Filter out items that are fully received
                    const itemsToReceive = data.items.filter(item => Number(item.remaining_quantity || 0) > 0);
                    
                    if (itemsToReceive.length === 0) {
                        container.innerHTML = '<p class="text-gray-500 text-center py-8">All items have been fully received for this purchase order.</p>';
                        return;
                    }

                    const itemsHtml = itemsToReceive.map((item, index) => `
                        <div class="bg-gray-50 p-4 rounded-lg mb-3">
                            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Material</label>
                                    <p class="text-gray-900 font-medium">${item.material_name}</p>
                                    <p class="text-xs text-gray-500">${item.unit ? item.unit : ''}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Ordered Qty</label>
                                    <p class="text-gray-900 font-medium">${Number(item.ordered_quantity).toFixed(2)}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Already Received</label>
                                    <p class="text-gray-900 font-medium">${Number(item.already_received).toFixed(2)}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-1">Remaining</label>
                                    <p class="text-gray-900 font-medium">${Number(item.remaining_quantity).toFixed(2)}</p>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Defect Qty</label>
                                    <input
                                        type="number"
                                        name="items[${index}][defect_quantity]"
                                        step="0.01"
                                        min="0"
                                        max="${Number(item.remaining_quantity).toFixed(2)}"
                                        class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                        placeholder="0.00"
                                    >
                                    <input type="hidden" name="items[${index}][purchase_order_item_id]" value="${item.id}">
                                </div>
                            </div>
                        </div>
                    `).join('');

                    container.innerHTML = `<div class="space-y-4">${itemsHtml}</div>`;
                })
                .catch(() => {
                    container.innerHTML = '<p class="text-red-500 text-center py-8">Failed to load items for this purchase order.</p>';
                });
        }

        function openViewOrderModal(orderId) {
            document.getElementById('viewOrderItemsModal').classList.remove('hidden');

            const itemsTable = document.getElementById('viewOrderItemsTable');
            itemsTable.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">Loading items...</td></tr>';

            fetch(`/procurement/purchase-orders/${orderId}/items?include_received=1`)
                .then(response => response.json())
                .then(data => {
                    if (!data.success || !data.items || data.items.length === 0) {
                        itemsTable.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-gray-500">No items found for this order.</td></tr>';
                        return;
                    }

                    if (data.order) {
                        document.getElementById('viewOrderNumber').textContent = data.order.order_number || '-';
                        document.getElementById('viewSupplierName').textContent = data.order.supplier_name || '-';
                    } else {
                        const row = document.querySelector(`button[onclick="event.stopPropagation(); openViewOrderModal(${orderId})"]`)?.closest('tr');
                        if (row) {
                            const orderCell = row.querySelector('td:first-child');
                            const supplierCell = row.querySelector('td:nth-child(2)');
                            document.getElementById('viewOrderNumber').textContent = orderCell ? orderCell.textContent.trim() : '-';
                            document.getElementById('viewSupplierName').textContent = supplierCell ? supplierCell.textContent.trim() : '-';
                        }
                    }

                    itemsTable.innerHTML = data.items.map(item => `
                        <tr>
                            <td class="px-4 py-3 text-gray-900">${item.material_name || 'N/A'}</td>
                            <td class="px-4 py-3 text-right text-gray-900 font-medium">${Number(item.ordered_quantity || 0).toFixed(2)}</td>
                            <td class="px-4 py-3 text-right text-gray-900">${Number(item.already_received || 0).toFixed(2)}</td>
                            <td class="px-4 py-3 text-right text-gray-900">${Number(item.remaining_quantity || 0).toFixed(2)}</td>
                            <td class="px-4 py-3 text-right text-gray-900">₱${Number(item.unit_price || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                            <td class="px-4 py-3 text-right text-gray-900 font-bold">₱${Number(item.total_amount || (item.ordered_quantity || 0) * (item.unit_price || 0)).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</td>
                        </tr>
                    `).join('');
                })
                .catch(() => {
                    itemsTable.innerHTML = '<tr><td colspan="6" class="px-4 py-8 text-center text-red-500">Failed to load items for this order.</td></tr>';
                });
        }

        function closeViewOrderItemsModal() {
            document.getElementById('viewOrderItemsModal').classList.add('hidden');
        }

        // Received Stock Reports Modal Functions
        function openReceivedStockReportsModal() {
            document.getElementById('receivedStockReportsModal').classList.remove('hidden');
            loadReceivedStockReports();
        }

        function closeReceivedStockReportsModal() {
            document.getElementById('receivedStockReportsModal').classList.add('hidden');
        }

        async function loadReceivedStockReports() {
            const tbody = document.getElementById('receivedStockTableBody');
            tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">Loading...</td></tr>';

            try {
                const response = await fetch('/procurement/received-stock-reports');
                const data = await response.json();

                if (data.success && data.movements && data.movements.length > 0) {
                    let totalReceived = 0;
                    let totalDefects = 0;

                    tbody.innerHTML = data.movements.map(movement => {
                        const receivedQty = parseFloat(movement.quantity || 0);
                        const defectQty = parseFloat(movement.defect_quantity || 0);
                        totalReceived += receivedQty;
                        totalDefects += defectQty;

                        return `
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-700">${movement.date}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.po_number || 'N/A'}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.material_name}</td>
                                <td class="px-4 py-3 text-gray-700">${receivedQty.toFixed(2)}</td>
                                <td class="px-4 py-3 text-red-600">${defectQty.toFixed(2)}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.supplier_name || 'N/A'}</td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-semibold ${
                                        movement.status === 'completed' ? 'text-green-600' : 
                                        movement.status === 'pending' ? 'text-orange-600' : 'text-red-600'
                                    }">${movement.status || 'N/A'}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">${movement.notes || '-'}</td>
                            </tr>
                        `;
                    }).join('');

                    // Update summary
                    document.getElementById('totalReceived').textContent = totalReceived.toFixed(2);
                    document.getElementById('totalDefects').textContent = totalDefects.toFixed(2);
                    document.getElementById('netQuantity').textContent = (totalReceived - totalDefects).toFixed(2);

                    // Populate material filter
                    const materialSelect = document.getElementById('filterMaterial');
                    const uniqueMaterials = [...new Set(data.movements.map(m => m.material_name))];
                    materialSelect.innerHTML = '<option value="">All Materials</option>' + 
                        uniqueMaterials.map(material => `<option value="${material}">${material}</option>`).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">No received stock records found</td></tr>';
                    document.getElementById('totalReceived').textContent = '0';
                    document.getElementById('totalDefects').textContent = '0';
                    document.getElementById('netQuantity').textContent = '0';
                }
            } catch (error) {
                console.error('Error loading received stock reports:', error);
                tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-red-400">Error loading data</td></tr>';
            }
        }

        async function filterReceivedStock() {
            const dateFrom = document.getElementById('filterDateFrom').value;
            const dateTo = document.getElementById('filterDateTo').value;
            const material = document.getElementById('filterMaterial').value;

            const params = new URLSearchParams();
            if (dateFrom) params.append('date_from', dateFrom);
            if (dateTo) params.append('date_to', dateTo);
            if (material) params.append('material', material);

            const tbody = document.getElementById('receivedStockTableBody');
            tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">Loading...</td></tr>';

            try {
                const response = await fetch(`/procurement/received-stock-reports?${params.toString()}`);
                const data = await response.json();

                if (data.success && data.movements && data.movements.length > 0) {
                    let totalReceived = 0;
                    let totalDefects = 0;

                    tbody.innerHTML = data.movements.map(movement => {
                        const receivedQty = parseFloat(movement.quantity || 0);
                        const defectQty = parseFloat(movement.defect_quantity || 0);
                        totalReceived += receivedQty;
                        totalDefects += defectQty;

                        return `
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-700">${movement.date}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.po_number || 'N/A'}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.material_name}</td>
                                <td class="px-4 py-3 text-gray-700">${receivedQty.toFixed(2)}</td>
                                <td class="px-4 py-3 text-red-600">${defectQty.toFixed(2)}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.supplier_name || 'N/A'}</td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-semibold ${
                                        movement.status === 'completed' ? 'text-green-600' : 
                                        movement.status === 'pending' ? 'text-orange-600' : 'text-red-600'
                                    }">${movement.status || 'N/A'}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">${movement.notes || '-'}</td>
                            </tr>
                        `;
                    }).join('');

                    // Update summary
                    document.getElementById('totalReceived').textContent = totalReceived.toFixed(2);
                    document.getElementById('totalDefects').textContent = totalDefects.toFixed(2);
                    document.getElementById('netQuantity').textContent = (totalReceived - totalDefects).toFixed(2);
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">No records found matching the filters</td></tr>';
                    document.getElementById('totalReceived').textContent = '0';
                    document.getElementById('totalDefects').textContent = '0';
                    document.getElementById('netQuantity').textContent = '0';
                }
            } catch (error) {
                console.error('Error filtering received stock:', error);
                tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-red-400">Error loading data</td></tr>';
            }
        }

        // Function to populate unit price from material data
        function populateUnitPrice(selectElement) {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            const unitPrice = selectedOption.getAttribute('data-price');
            const unitPriceInput = selectElement.closest('.grid').querySelector('input[name*="[unit_price]"]');
            
            if (unitPrice && unitPriceInput) {
                unitPriceInput.value = unitPrice;
            }
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
                    <select name="items[${itemCount}][material_id]" class="material-select w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
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
                    <input type="number" name="items[${itemCount}][unit_price]" step="0.01" min="0" placeholder="0.00" class="unit-price-input w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                </div>
                
                <div class="flex items-end">
                    <button type="button" onclick="removeItem(this)" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Remove
                    </button>
                </div>
            `;
            container.appendChild(newItem);
            
            // Attach event listener to the newly added material select
            const materialSelect = newItem.querySelector('.material-select');
            materialSelect.addEventListener('change', function() {
                populateUnitPrice(this);
            });
            
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

        // Received Stock Reports Modal Functions
        function openReceivedStockReportsModal() {
            document.getElementById('receivedStockReportsModal').classList.remove('hidden');
            loadReceivedStockReports();
        }

        function closeReceivedStockReportsModal() {
            document.getElementById('receivedStockReportsModal').classList.add('hidden');
        }

        async function loadReceivedStockReports() {
            const tbody = document.getElementById('receivedStockTableBody');
            tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">Loading...</td></tr>';

            try {
                const response = await fetch('/procurement/received-stock-reports');
                const data = await response.json();

                if (data.success && data.movements && data.movements.length > 0) {
                    let totalReceived = 0;
                    let totalDefects = 0;

                    tbody.innerHTML = data.movements.map(movement => {
                        const receivedQty = parseFloat(movement.quantity || 0);
                        const defectQty = parseFloat(movement.defect_quantity || 0);
                        totalReceived += receivedQty;
                        totalDefects += defectQty;

                        return `
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-700">${movement.date}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.po_number || 'N/A'}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.material_name}</td>
                                <td class="px-4 py-3 text-gray-700">${receivedQty.toFixed(2)}</td>
                                <td class="px-4 py-3 text-red-600">${defectQty.toFixed(2)}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.supplier_name || 'N/A'}</td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-semibold ${
                                        movement.status === 'completed' ? 'text-green-600' : 
                                        movement.status === 'pending' ? 'text-orange-600' : 'text-red-600'
                                    }">${movement.status || 'N/A'}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">${movement.notes || '-'}</td>
                            </tr>
                        `;
                    }).join('');

                    // Update summary
                    document.getElementById('totalReceived').textContent = totalReceived.toFixed(2);
                    document.getElementById('totalDefects').textContent = totalDefects.toFixed(2);
                    document.getElementById('netQuantity').textContent = (totalReceived - totalDefects).toFixed(2);

                    // Populate material filter
                    const materialSelect = document.getElementById('filterMaterial');
                    const uniqueMaterials = [...new Set(data.movements.map(m => m.material_name))];
                    materialSelect.innerHTML = '<option value="">All Materials</option>' + 
                        uniqueMaterials.map(material => `<option value="${material}">${material}</option>`).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">No received stock records found</td></tr>';
                    document.getElementById('totalReceived').textContent = '0';
                    document.getElementById('totalDefects').textContent = '0';
                    document.getElementById('netQuantity').textContent = '0';
                }
            } catch (error) {
                console.error('Error loading received stock reports:', error);
                tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-red-400">Error loading data</td></tr>';
            }
        }

        async function filterReceivedStock() {
            const dateFrom = document.getElementById('filterDateFrom').value;
            const dateTo = document.getElementById('filterDateTo').value;
            const material = document.getElementById('filterMaterial').value;

            const params = new URLSearchParams();
            if (dateFrom) params.append('date_from', dateFrom);
            if (dateTo) params.append('date_to', dateTo);
            if (material) params.append('material', material);

            const tbody = document.getElementById('receivedStockTableBody');
            tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">Loading...</td></tr>';

            try {
                const response = await fetch(`/procurement/received-stock-reports?${params.toString()}`);
                const data = await response.json();

                if (data.success && data.movements && data.movements.length > 0) {
                    let totalReceived = 0;
                    let totalDefects = 0;

                    tbody.innerHTML = data.movements.map(movement => {
                        const receivedQty = parseFloat(movement.quantity || 0);
                        const defectQty = parseFloat(movement.defect_quantity || 0);
                        totalReceived += receivedQty;
                        totalDefects += defectQty;

                        return `
                            <tr class="hover:bg-gray-50">
                                <td class="px-4 py-3 text-gray-700">${movement.date}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.po_number || 'N/A'}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.material_name}</td>
                                <td class="px-4 py-3 text-gray-700">${receivedQty.toFixed(2)}</td>
                                <td class="px-4 py-3 text-red-600">${defectQty.toFixed(2)}</td>
                                <td class="px-4 py-3 text-gray-700">${movement.supplier_name || 'N/A'}</td>
                                <td class="px-4 py-3">
                                    <span class="text-xs font-semibold ${
                                        movement.status === 'completed' ? 'text-green-600' : 
                                        movement.status === 'pending' ? 'text-orange-600' : 'text-red-600'
                                    }">${movement.status || 'N/A'}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-700">${movement.notes || '-'}</td>
                            </tr>
                        `;
                    }).join('');

                    // Update summary
                    document.getElementById('totalReceived').textContent = totalReceived.toFixed(2);
                    document.getElementById('totalDefects').textContent = totalDefects.toFixed(2);
                    document.getElementById('netQuantity').textContent = (totalReceived - totalDefects).toFixed(2);
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">No records found matching the filters</td></tr>';
                    document.getElementById('totalReceived').textContent = '0';
                    document.getElementById('totalDefects').textContent = '0';
                    document.getElementById('netQuantity').textContent = '0';
                }
            } catch (error) {
                console.error('Error filtering received stock:', error);
                tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-red-400">Error loading data</td></tr>';
            }
        }

        // Initialize tab state on page load
        document.addEventListener('DOMContentLoaded', function() {
            showTab('purchase-orders');
            const purchaseOrdersTab = document.getElementById('purchase-orders-tab');
            purchaseOrdersTab.style.borderRadius = '10px';
            const suppliersTab = document.getElementById('suppliers-tab');
            suppliersTab.style.borderRadius = '10px';

            // Attach event listeners to all material select dropdowns
            const materialSelects = document.querySelectorAll('.material-select');
            materialSelects.forEach(select => {
                select.addEventListener('change', function() {
                    populateUnitPrice(this);
                });
            });

            // Procurement search & filter logic
            function applyProcurementFilters() {
                const searchInput = document.getElementById('searchInput');
                const query = searchInput ? searchInput.value.trim().toLowerCase() : '';
                const statusFilter = document.getElementById('statusFilter') ? document.getElementById('statusFilter').value : 'all';
                // Search and status filters handled client-side

                const purchaseOrdersTable = document.getElementById('purchase-orders-table');
                const suppliersTable = document.getElementById('suppliers-table');
                const activeContainer = purchaseOrdersTable && !purchaseOrdersTable.classList.contains('hidden') ? purchaseOrdersTable : suppliersTable;

                if (!activeContainer) return;

                const rows = Array.from(activeContainer.querySelectorAll('tbody tr'));
                let visibleCount = 0;

                rows.forEach(row => {
                    // Collect searchable text depending on active table
                    let text = (row.textContent || '').toLowerCase();

                    // For purchase orders, filter additionally by payment status if selected
                    if (activeContainer.id === 'purchase-orders-table' && statusFilter && statusFilter !== 'all') {
                        const statusCell = row.querySelector('td:nth-child(6)');
                        const statusText = statusCell ? (statusCell.textContent || '').toLowerCase() : '';
                        if (!statusText.includes(statusFilter)) {
                            row.style.display = 'none';
                            return;
                        }
                    }

                    // If query exists, match against row text
                    if (query.length > 0) {
                        if (text.includes(query)) {
                            row.style.display = '';
                            visibleCount++;
                        } else {
                            row.style.display = 'none';
                        }
                    } else {
                        // no query, row already passed status filter
                        row.style.display = '';
                        visibleCount++;
                    }
                });

                // Manage contextual no-results message inside active container
                let noResultsEl = activeContainer.querySelector('#procurementNoResultsMessage');
                if (!noResultsEl) {
                    noResultsEl = document.createElement('div');
                    noResultsEl.id = 'procurementNoResultsMessage';
                    noResultsEl.className = 'py-8 px-4 text-center text-slate-400';
                    noResultsEl.style.display = 'none';
                    activeContainer.appendChild(noResultsEl);
                }

                if (visibleCount === 0) {
                    noResultsEl.textContent = 'No items match your search/filter.';
                    noResultsEl.style.display = '';
                } else {
                    noResultsEl.style.display = 'none';
                }
            }

            // Attach listeners (guarded)
            const searchEl = document.getElementById('searchInput');
            if (searchEl) {
                searchEl.addEventListener('input', function() {
                    applyProcurementFilters();
                });
            }

            const statusEl = document.getElementById('statusFilter');
            if (statusEl) {
                statusEl.addEventListener('change', function() {
                    applyProcurementFilters();
                });
            }

            // payment filter removed; no-op

            // Handle Receive Stock form submission (AJAX)
            const receiveStockForm = document.getElementById('receiveStockForm');
            if (receiveStockForm) {
                receiveStockForm.addEventListener('submit', function (e) {
                    e.preventDefault();

                    const purchaseOrderSelect = document.getElementById('purchaseOrderSelect');
                    const purchaseOrderId = purchaseOrderSelect ? purchaseOrderSelect.value : null;

                    if (!purchaseOrderId) {
                        alert('Please select a purchase order first.');
                        return;
                    }

                    const formData = new FormData(receiveStockForm);
                    formData.append('_token', '{{ csrf_token() }}');

                    fetch(`/procurement/purchase-orders/${purchaseOrderId}/receive-stock`, {
                        method: 'POST',
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message || 'Stock received successfully.');
                                window.location.reload();
                            } else {
                                alert(data.message || 'Failed to receive stock.');
                            }
                        })
                        .catch(() => {
                            alert('An error occurred while receiving stock.');
                        });
                });
            }
        });
    </script>

@endsection
