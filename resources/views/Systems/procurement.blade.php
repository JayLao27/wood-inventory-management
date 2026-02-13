    <!-- Success Notification -->
    <div id="successNotification" class="fixed top-6 left-1/2 transform -translate-x-1/2 z-[999999] bg-green-500 text-white px-6 py-3 rounded-xl shadow-lg text-lg font-semibold flex items-center gap-2 hidden transition-all duration-300">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span id="successNotificationText">Success!</span>
    </div>
    <script>
    // Show success notification
    function showSuccessNotification(message = 'Success!') {
        const notif = document.getElementById('successNotification');
        const notifText = document.getElementById('successNotificationText');
        notifText.textContent = message;
        notif.classList.remove('hidden');
        setTimeout(() => {
            notif.classList.add('hidden');
        }, 2200);
    }

    // Attach to all procurement forms
    document.addEventListener('DOMContentLoaded', function() {
        // Add Supplier
        const addSupplierForm = document.getElementById('addSupplierForm');
        if (addSupplierForm) {
            addSupplierForm.addEventListener('submit', function(e) {
                setTimeout(() => showSuccessNotification('Supplier added successfully!'), 100);
            });
        }
        // Edit Supplier
        const editSupplierForm = document.getElementById('editSupplierForm');
        if (editSupplierForm) {
            editSupplierForm.addEventListener('submit', function(e) {
                setTimeout(() => showSuccessNotification('Supplier updated successfully!'), 100);
            });
        }
        // Add Purchase Order
        const addPurchaseOrderForm = document.getElementById('addPurchaseOrderForm');
        if (addPurchaseOrderForm) {
            addPurchaseOrderForm.addEventListener('submit', function(e) {
                setTimeout(() => showSuccessNotification('Purchase order created!'), 100);
            });
        }
        // Edit Purchase Order
        const editPurchaseOrderForm = document.getElementById('editPurchaseOrderForm');
        if (editPurchaseOrderForm) {
            editPurchaseOrderForm.addEventListener('submit', function(e) {
                setTimeout(() => showSuccessNotification('Purchase order updated!'), 100);
            });
        }
    });
    </script>
@extends('layouts.system')

@section('main-content')
    <!-- Main Content -->
    <div class="flex-1 p-5 bg-amber-50 overflow-y-auto">
        <!-- Header Section -->
        <div class="mb-5">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-900">Procurement Management</h1>
                    <p class="text-gray-600 mt-1.5">Manage suppliers, purchase orders, and material sourcing</p>
                </div>
                @php
                    $receiveCount = is_countable($openPurchaseOrders ?? $purchaseOrders ?? [])
                        ? count($openPurchaseOrders ?? $purchaseOrders ?? [])
                        : 0;
                @endphp
                <div class="flex space-x-3">
                    <button onclick="openReceivedStockReportsModal()" class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition flex items-center gap-2">
                        <svg class="h-6 w-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <rect x="3" y="13" width="4" height="8" rx="1" fill="currentColor" class="text-amber-300"/>
                            <rect x="9" y="9" width="4" height="12" rx="1" fill="currentColor" class="text-amber-400"/>
                            <rect x="15" y="5" width="4" height="16" rx="1" fill="currentColor" class="text-amber-500"/>
                            <path stroke="currentColor" stroke-width="2" d="M3 21h18"/>
                        </svg>
                        <span>Reports</span>
                    </button>
                </div>
            </div>
        </div>

        <!-- Metrics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-3 mb-5">
            <!-- Total Spent Card -->
            <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl p-3 text-white shadow-xl border border-slate-600 hover:shadow-2xl transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xs font-medium text-slate-300 font-semibold uppercase tracking-wide">Total Spent</h3>
                        @php
                            $totalSpentFormatted = number_format($totalSpent, 0);
                            $totalSpentLength = strlen($totalSpentFormatted);
                            $totalSpentSize = $totalSpentLength > 15 ? 'text-lg' : ($totalSpentLength > 12 ? 'text-xl' : 'text-2xl');
                        @endphp
                        <p class="{{ $totalSpentSize }} font-bold mt-2 bg-gradient-to-r from-amber-300 to-amber-100 bg-clip-text text-transparent">₱{{ $totalSpentFormatted }}</p>
                        <p class="text-slate-300 text-xs mt-1">All purchase orders</p>
                    </div>
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
                      @include('components.icons.dollar', ['class' => 'w-5 h-5 text-amber-400'])
                    </div>
                </div>
            </div>

            <!-- Payments Made Card -->
            <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl p-3 text-white shadow-xl border border-slate-600 hover:shadow-2xl transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xs font-medium text-slate-300 font-semibold uppercase tracking-wide">Payments Made</h3>
                        @php
                            $paymentsMadeFormatted = number_format($paymentsMade, 0);
                            $paymentsMadeLength = strlen($paymentsMadeFormatted);
                            $paymentsMadeSize = $paymentsMadeLength > 15 ? 'text-lg' : ($paymentsMadeLength > 12 ? 'text-xl' : 'text-2xl');
                        @endphp
                        <p class="{{ $paymentsMadeSize }} font-bold mt-2 bg-gradient-to-r from-green-300 to-green-100 bg-clip-text text-transparent">₱{{ $paymentsMadeFormatted }}</p>
                        <p class="text-slate-300 text-xs mt-1">Paid to suppliers</p>
                    </div>
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
                        @include('components.icons.dollar', ['class' => 'w-5 h-5 text-green-400'])
                    </div>
                </div>
            </div>

            <!-- Pending Payments Card -->
            <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl p-3 text-white shadow-xl border border-slate-600 hover:shadow-2xl transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xs font-medium text-slate-300 font-semibold uppercase tracking-wide">Pending Payments</h3>
                        @php
                            $pendingPaymentsFormatted = number_format($pendingPayments, 0);
                            $pendingPaymentsLength = strlen($pendingPaymentsFormatted);
                            $pendingPaymentsSize = $pendingPaymentsLength > 15 ? 'text-lg' : ($pendingPaymentsLength > 12 ? 'text-xl' : 'text-2xl');
                        @endphp
                        <p class="{{ $pendingPaymentsSize }} font-bold mt-2 bg-gradient-to-r from-yellow-300 to-yellow-100 bg-clip-text text-transparent">₱{{ $pendingPaymentsFormatted }}</p>
                        <p class="text-slate-300 text-xs mt-1">Outstanding amount</p>
                    </div>
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
                         @include('components.icons.dollar', ['class' => 'w-5 h-5 text-yellow-400'])
                    </div>
                </div>
            </div>

            <!-- Active Suppliers Card -->
            <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl p-3 text-white shadow-xl border border-slate-600 hover:shadow-2xl transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xs font-medium text-slate-300 font-semibold uppercase tracking-wide">Suppliers</h3>
                        <p class="text-2xl font-bold mt-2 bg-gradient-to-r from-blue-300 to-blue-100 bg-clip-text text-transparent">{{ $activeSuppliers }}</p>
                        <p class="text-slate-300 text-xs mt-1">Suppliers</p>
                    </div>
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
                      @include('components.icons.cart', ['class' => 'w-5 h-5 text-blue-400'])
                    </div>
                </div>
            </div>

            <!-- Low Stock Alerts Card -->
            <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl p-3 text-white shadow-xl border border-slate-600 hover:shadow-2xl transition-all duration-300">
                <div class="flex justify-between items-start">
                    <div>
                        <h3 class="text-xs font-medium text-slate-300 font-semibold uppercase tracking-wide">Low Stock Alerts</h3>
                        <p class="text-2xl font-bold mt-2 bg-gradient-to-r from-red-300 to-red-100 bg-clip-text text-transparent">{{ $lowStockAlerts }}</p>
                        <p class="text-slate-300 text-xs mt-1">Items requiring attention</p>
                    </div>
                    <div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
                        @include('components.icons.cart', ['class' => 'w-5 h-5 text-red-400'])
                    </div>
                </div>
            </div>
        </div>

        <!-- Procurement Management Section -->
        <div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl p-3 shadow-xl border border-slate-600">
            <div class="flex justify-between items-center mb-3">
                <div>
                    <h2 class="text-lg font-bold text-white">Procurement Management</h2>
                    <p class="text-slate-300 text-xs mt-1">Manage purchase orders and supplier relationships</p>
                </div>
                <div id="purchaseOrdersButton" class="flex space-x-2">
                    <button onclick="openAddPurchaseOrderModal()" class="px-3.5 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl hover:from-amber-600 hover:to-orange-700 transition-all shadow-lg hover:shadow-xl flex items-center space-x-1.5 font-medium text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>New Purchase Order</span>
                    </button>
                </div>
                <div id="suppliersButton" class="flex space-x-2 hidden">
                    <button onclick="openAddSupplierModal()" class="px-3.5 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl hover:from-amber-600 hover:to-orange-700 transition-all shadow-lg hover:shadow-xl flex items-center space-x-1.5 font-medium text-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                        </svg>
                        <span>New Supplier</span>
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
            <div class="flex space-x-2 w-full mb-6">
                <button onclick="showTab('purchase-orders')" id="purchase-orders-tab" class="flex-1 px-5.5 py-3 rounded-xl border-2 font-bold text-sm transition-all shadow-lg" style="background-color: #FFF1DA; border-color: #FDE68A; color: #111827;">Orders</button>
                <button onclick="showTab('suppliers')" id="suppliers-tab" class="flex-1 px-5.5 py-3 rounded-xl border-2 font-bold text-sm transition-all shadow-lg" style="background-color: #475569; border-color: #64748b; color: #FFFFFF;">Suppliers</button>
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
    <div id="addSupplierModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-3">
            <div class="bg-amber-50 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border-2 border-slate-700">
                <!-- Header -->
                <div class="sticky top-0 bg-gradient-to-r from-slate-700 to-slate-800 p-3 text-white rounded-t-2xl z-10">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold flex items-center gap-1.5">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                </svg>
                                Add New Supplier
                            </h3>
                            <p class="text-slate-300 text-xs mt-1">Register a new supplier to the system</p>
                        </div>
                        <button onclick="closeAddSupplierModal()" class="text-white hover:text-slate-300 hover:bg-white/10 rounded-xl p-2 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mx-6 mt-6 p-3 bg-red-50 border-2 border-red-400 rounded-xl shadow-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-red-800 font-bold text-base mb-2">Please fix the following errors:</h4>
                                <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form Content -->
                <div class="p-3">
                    <form id="addSupplierForm" method="POST" action="{{ route('procurement.supplier.store') }}">
                        @csrf
                        <div class="space-y-5">
                            <!-- Basic Information Section -->
                            <div>
                                <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-1.5">
                                    <span class="w-1 h-6 bg-amber-500 rounded"></span>
                                    Basic Information
                                </h4>

                                <div class="space-y-4">
                                    <!-- Supplier Name -->
                                    <div>
                                        <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                            </svg>
                                            Supplier Name <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="name" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('name') border-red-500 @enderror" value="{{ old('name') }}" required placeholder="Enter supplier company name">
                                        @error('name')
                                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Contact Person -->
                                    <div>
                                        <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
                                            </svg>
                                            Contact Person <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="contact_person" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('contact_person') border-red-500 @enderror" value="{{ old('contact_person') }}" required placeholder="Enter contact person name">
                                        @error('contact_person')
                                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Payment Terms -->
                                    <div>
                                        <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                            </svg>
                                            Payment Terms <span class="text-red-500">*</span>
                                        </label>
                                        <select name="payment_terms" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('payment_terms') border-red-500 @enderror" required>
                                            <option value="">-- Select Payment Terms --</option>
                                            <option value="Net 15" {{ old('payment_terms') == 'Net 15' ? 'selected' : '' }}>Net 15 Days</option>
                                            <option value="Net 30" {{ old('payment_terms') == 'Net 30' ? 'selected' : '' }}>Net 30 Days</option>
                                            <option value="Net 45" {{ old('payment_terms') == 'Net 45' ? 'selected' : '' }}>Net 45 Days</option>
                                            <option value="Net 60" {{ old('payment_terms') == 'Net 60' ? 'selected' : '' }}>Net 60 Days</option>
                                            <option value="Cash on Delivery" {{ old('payment_terms') == 'Cash on Delivery' ? 'selected' : '' }}>Cash on Delivery</option>
                                        </select>
                                        @error('payment_terms')
                                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Contact Information Section -->
                            <div class="pt-4 border-t-2 border-gray-300">
                                <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-1.5">
                                    <span class="w-1 h-6 bg-amber-500 rounded"></span>
                                    Contact Information
                                </h4>

                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                    <!-- Phone -->
                                    <div>
                                        <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
                                            </svg>
                                            Phone Number <span class="text-red-500">*</span>
                                        </label>
                                        <input type="text" name="phone" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('phone') border-red-500 @enderror" value="{{ old('phone') }}" required placeholder="09XXXXXXXXX">
                                        @error('phone')
                                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                            <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                            </svg>
                                            Email Address <span class="text-red-500">*</span>
                                        </label>
                                        <input type="email" name="email" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('email') border-red-500 @enderror" value="{{ old('email') }}" required placeholder="supplier@example.com">
                                        @error('email')
                                            <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                                </svg>
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Address Section -->
                            <div class="pt-4 border-t-2 border-gray-300">
                                <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                    </svg>
                                    Address <span class="text-red-500">*</span>
                                </label>
                                <textarea name="address" rows="3" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('address') border-red-500 @enderror" required placeholder="Enter supplier's complete address">{{ old('address') }}</textarea>
                                @error('address')
                                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center pt-4 border-t-2 border-gray-300">
                                <div class="text-xs text-gray-600">
                                    <span class="font-semibold">Required fields:</span> All fields are required
                                </div>
                                <div class="flex space-x-3">
                                    <button type="button" class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-bold text-base hover:bg-gray-100 transition-all shadow-sm" onclick="closeAddSupplierModal()">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold text-base rounded-xl hover:from-amber-600 hover:to-orange-700 shadow-lg hover:shadow-xl transition-all flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Add Supplier
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Purchase Order Modal -->
    <div id="addPurchaseOrderModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-3">
            <div class="bg-amber-50 rounded-xl max-w-3xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border-2 border-slate-700">
                <!-- Header -->
                <div class="sticky top-0 bg-gradient-to-r from-slate-700 to-slate-800 p-3 text-white rounded-t-2xl z-10">
                    <div class="flex justify-between items-center">
                        <div>
                            <h3 class="text-xl font-bold flex items-center gap-1.5">
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01" />
                                </svg>
                                Create Purchase Order
                            </h3>
                            <p class="text-slate-300 text-xs mt-1">Add a new purchase order from supplier</p>
                        </div>
                        <button onclick="closeAddPurchaseOrderModal()" class="text-white hover:text-slate-300 hover:bg-white/10 rounded-xl p-2 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Error Messages -->
                @if ($errors->any())
                    <div class="mx-6 mt-6 p-3 bg-red-50 border-2 border-red-400 rounded-xl shadow-lg">
                        <div class="flex items-start gap-3">
                            <svg class="w-6 h-6 text-red-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <div class="flex-1">
                                <h4 class="text-red-800 font-bold text-base mb-2">Please fix the following errors:</h4>
                                <ul class="list-disc list-inside text-xs text-red-700 space-y-1">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Form Content -->
                <div class="p-3">
                    <form id="addPurchaseOrderForm" method="POST" action="{{ route('procurement.purchase-order.store') }}">
                        @csrf
                        <div class="space-y-5">
                            <!-- Supplier Selection -->
                            <div>
                                <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z" />
                                    </svg>
                                    Supplier <span class="text-red-500">*</span>
                                </label>
                                <select name="supplier_id" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('supplier_id') border-red-500 @enderror" required>
                                    <option value="">-- Select Supplier --</option>
                                    @foreach($suppliers ?? [] as $supplier)
                                        <option value="{{ $supplier->id }}" {{ old('supplier_id') == $supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                    @endforeach
                                </select>
                                @error('supplier_id')
                                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Order Date -->
                            <div>
                                <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Order Date <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="order_date" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('order_date') border-red-500 @enderror" value="{{ old('order_date', date('Y-m-d')) }}" required>
                                @error('order_date')
                                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Expected Delivery -->
                            <div>
                                <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                                    </svg>
                                    Expected Delivery <span class="text-red-500">*</span>
                                </label>
                                <input type="date" name="expected_delivery" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('expected_delivery') border-red-500 @enderror" value="{{ old('expected_delivery') }}" required>
                                @error('expected_delivery')
                                    <p class="text-red-500 text-xs mt-2 flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                        </svg>
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <!-- Material Selection Section -->
                            <div class="pt-4 border-t-2 border-gray-300">
                                <h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-1.5">
                                    <span class="w-1 h-6 bg-amber-500 rounded"></span>
                                    Order Items
                                </h4>
                                
                                <div class="bg-white rounded-xl border-2 border-slate-300 p-5 shadow-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3">
                                        <!-- Material Selection -->
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-2 flex items-center gap-1">
                                                <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd" />
                                                </svg>
                                                Material <span class="text-red-500">*</span>
                                            </label>
                                            <select id="newItemMaterial" name="items[0][material_id]" class="w-full border-2 border-gray-300 rounded-lg px-3 py-1.5 text-base focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all @error('items.0.material_id') border-red-500 @enderror" required>
                                                <option value="">-- Select Material --</option>
                                                @foreach($materials ?? [] as $material)
                                                    <option value="{{ $material->id }}" data-price="{{ number_format($material->unit_cost,2,'.','') }}">{{ $material->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('items.0.material_id')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Quantity -->
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-2 flex items-center gap-1">
                                                <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                                </svg>
                                                Quantity <span class="text-red-500">*</span>
                                            </label>
                                            <input id="newItemQty" type="number" min="1" step="1" name="items[0][quantity]" class="w-full border-2 border-gray-300 rounded-lg px-3 py-1.5 text-base font-bold focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all @error('items.0.quantity') border-red-500 @enderror" placeholder="1" value="{{ old('items.0.quantity') }}" required>
                                            @error('items.0.quantity')
                                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                            @enderror
                                        </div>

                                        <!-- Unit Price -->
                                        <div>
                                            <label class="block text-xs font-bold text-slate-700 mb-2 flex items-center gap-1">
                                                <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z" />
                                                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd" />
                                                </svg>
                                                Unit Price
                                            </label>
                                            <input id="newItemUnitPrice" type="text" class="w-full border-2 border-gray-200 rounded-lg px-3 py-1.5 text-base font-bold bg-gray-100 text-gray-600" value="" placeholder="Auto-filled" disabled>
                                            <input id="newItemUnitPriceHidden" type="hidden" name="items[0][unit_price]" value="">
                                        </div>
                                    </div>

                                    <!-- Line Total Display -->
                                    <div class="mt-4 p-3 bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-300 rounded-lg">
                                        <div class="flex items-center justify-between">
                                            <span class="text-xs font-bold text-amber-800 flex items-center gap-1.5">
                                                <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd" d="M4 4a2 2 0 00-2 2v4a2 2 0 002 2V6h10a2 2 0 00-2-2H4zm2 6a2 2 0 012-2h8a2 2 0 012 2v4a2 2 0 01-2 2H8a2 2 0 01-2-2v-4zm6 4a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
                                                </svg>
                                                Line Total:
                                            </span>
                                            <span id="newItemLineTotal" class="text-xl font-bold text-amber-700">₱0.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes Section -->
                            <div>
                                <label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
                                    <svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Additional Notes (Optional)
                                </label>
                                <textarea name="note" rows="3" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm" placeholder="Add any special instructions or notes for this order..."></textarea>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex justify-between items-center pt-4 border-t-2 border-gray-300">
                                <div class="text-xs text-gray-600">
                                    <span class="font-semibold">Required fields:</span> Supplier, Order Date, Expected Delivery, Material
                                </div>
                                <div class="flex space-x-3">
                                    <button type="button" class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-bold text-base hover:bg-gray-100 transition-all shadow-sm" onclick="closeAddPurchaseOrderModal()">
                                        Cancel
                                    </button>
                                    <button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold text-base rounded-xl hover:from-amber-600 hover:to-orange-700 shadow-lg hover:shadow-xl transition-all flex items-center gap-1.5">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                        </svg>
                                        Create Purchase Order
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- View Order Items Modal -->
    <div id="viewOrderItemsModal" class="fixed inset-0 bg-black/70 hidden overflow-y-auto" style="z-index: 99999;">
        <div class="rounded-lg shadow-2xl max-w-4xl w-[95%] mx-auto my-8 p-8" style="background-color: #FFF1DA;">
            <!-- Header -->
            <div class="flex items-center justify-between mb-8 border-b-2 pb-6" style="border-color: #374151;">
                <div>
                    <h3 class="text-3xl font-bold" id="viewOrderHeaderNumber" style="color: #374151;">Order #-</h3>
                    <p class="mt-1" id="viewOrderHeaderSupplier" style="color: #666;">-</p>
                </div>
                <button class="text-2xl transition" style="color: #999;" onclick="closeViewOrderItemsModal()">✕</button>
            </div>

            <!-- Order Information Cards -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                <div class="p-4 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
                    <p class="text-sm font-semibold" style="color: #374151;">Order Number</p>
                    <p class="text-lg font-bold mt-2" id="viewOrderDetailNumber" style="color: #374151;">-</p>
                </div>
                <div class="p-4 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
                    <p class="text-sm font-semibold" style="color: #374151;">Supplier</p>
                    <p class="text-lg font-bold mt-2" id="viewOrderDetailSupplier" style="color: #374151;">-</p>
                </div>
                <div class="p-4 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
                    <p class="text-sm font-semibold" style="color: #374151;">Total Items</p>
                    <p class="text-lg font-bold mt-2" id="viewOrderTotalItems" style="color: #374151;">0</p>
                </div>
                <div class="p-4 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #388E3C;">
                    <p class="text-sm font-semibold" style="color: #374151;">Order Total</p>
                    <p class="text-lg font-bold mt-2" id="viewOrderTotalAmount" style="color: #388E3C;">₱0.00</p>
                </div>
            </div>

            <!-- Items Section -->
            <div class="mb-8">
                <h4 class="text-xl font-bold mb-4 flex items-center" style="color: #374151;">
                    <span class="w-1 h-6 rounded mr-3" style="background-color: #374151;"></span>
                    Materials & Items Ordered
                </h4>
                <div id="viewOrderItemsContainer" class="space-y-3">
                    <div class="p-6 rounded-lg border text-center" style="background-color: rgba(255,255,255,0.7); border-color: #374151; color: #999;">
                        Loading items...
                    </div>
                </div>
            </div>

            <!-- Close Button -->
            <div class="flex justify-end">
                <button class="px-6 py-3 rounded-lg font-semibold transition text-white" style="background-color: #374151;" onclick="closeViewOrderItemsModal()">Close</button>
            </div>
        </div>
    </div>

    <!-- Edit Purchase Order Modal -->
    <div id="editPurchaseOrderModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-amber-50 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border-2 border-slate-700">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b-2 border-slate-700">
                        <h3 class="text-xl font-bold text-gray-900">Edit Purchase Order</h3>
                        <button onclick="closeEditPurchaseOrderModal()" class="text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-xl p-2 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="editPurchaseOrderForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="grid gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Order Number</label>
                                <input type="text" id="editPOOrderNumber" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 bg-gray-100 text-sm transition-all" readonly>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Supplier</label>
                                <input type="text" id="editPOSupplierName" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 bg-gray-100 text-sm transition-all" readonly>
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-bold text-gray-900 mb-3">Payment Status *</label>
                                    <select name="payment_status" id="editPOPaymentStatus" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm transition-all" required>
                                        <option value="Pending">Pending</option>
                                        <option value="Partial">Partial</option>
                                        <option value="Paid">Paid</option>
                                    </select>
                                </div>
                            </div>
                            <div class="flex justify-end space-x-2 mt-6">
                                <button type="button" class="px-6 py-1.5 border-2 border-gray-300 rounded-xl text-gray-700 font-bold text-sm hover:bg-gray-100 transition-all" onclick="closeEditPurchaseOrderModal()">Cancel</button>
                                <button type="submit" class="px-6 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold text-sm rounded-xl hover:from-amber-600 hover:to-orange-700 shadow-lg hover:shadow-xl transition-all">Update Order</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Supplier Modal -->
    <div id="editSupplierModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-amber-50 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border-2 border-slate-700">
                <div class="p-4">
                    <div class="flex justify-between items-center mb-6 pb-4 border-b-2 border-slate-700">
                        <h3 class="text-xl font-bold text-gray-900">Edit Supplier</h3>
                        <button onclick="closeEditSupplierModal()" class="text-gray-500 hover:text-gray-700 hover:bg-gray-200 rounded-xl p-2 transition-all">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                    
                    <form id="editSupplierForm" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Name *</label>
                                <input type="text" id="editSupplierName" name="name" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm transition-all" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Contact Person *</label>
                                <input type="text" id="editSupplierContactPerson" name="contact_person" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm transition-all" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Phone *</label>
                                <input type="text" id="editSupplierPhone" name="phone" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm transition-all" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Email *</label>
                                <input type="email" id="editSupplierEmail" name="email" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm transition-all" required>
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-bold text-gray-900 mb-3">Address *</label>
                                <textarea id="editSupplierAddress" name="address" rows="2" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm transition-all" required></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Payment Terms *</label>
                                <input type="text" id="editSupplierPaymentTerms" name="payment_terms" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm transition-all" required>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-3">Status *</label>
                                <select id="editSupplierStatus" name="status" class="w-full border-2 border-gray-300 rounded-xl px-3 py-1.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 text-sm transition-all" required>
                                    <option value="active">Active</option>
                                    <option value="inactive">Inactive</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex justify-end space-x-2 mt-6">
                            <button type="button" class="px-6 py-1.5 border-2 border-gray-300 rounded-xl text-gray-700 font-bold text-sm hover:bg-gray-100 transition-all" onclick="closeEditSupplierModal()">Cancel</button>
                            <button type="submit" class="px-6 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold text-sm rounded-xl hover:from-amber-600 hover:to-orange-700 shadow-lg hover:shadow-xl transition-all">Update Supplier</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal for Cancelling Sales Order -->
    <div id="confirmCancelSalesOrderModal" class="modal-overlay fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="if(event.target === this) closeCancelSalesOrderModal()">
        <div class="modal-content bg-amber-50 rounded-lg max-w-xs w-full shadow-2xl transform transition-all animate-fadeIn" onclick="event.stopPropagation()">
            <div class="p-4">
                <!-- Icon -->
                <div class="flex justify-center mb-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-full">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Message -->
                <h3 class="text-center font-bold text-sm mb-1" style="color: #374151;">Cancel Sales Order?</h3>
                <p class="text-center text-xs mb-4" style="color: #666;">
                    Cancel sales order <span id="cancelSalesOrderNumber" class="font-semibold">-</span>? This action cannot be undone.
                </p>

                <!-- Actions -->
                <div class="flex justify-center gap-2">
                    <button type="button" onclick="closeCancelSalesOrderModal()" class="px-4 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all text-xs font-medium text-gray-700">
                        No, Keep It
                    </button>
                    <button type="button" onclick="submitCancelSalesOrder()" class="px-4 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all text-xs font-medium shadow-md hover:shadow-lg">
                        Yes, Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Confirmation Modal for Customer -->
    <div id="confirmCustomerModal" class="modal-overlay fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="if(event.target === this) closeConfirmCustomer()">
        <div class="modal-content bg-amber-50 rounded-lg max-w-xs w-full shadow-2xl transform transition-all animate-fadeIn" onclick="event.stopPropagation()">
            <div class="p-4">
                <!-- Icon -->
                <div class="flex justify-center mb-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-blue-100 rounded-full">
                        <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/>
                        </svg>
                    </div>
                </div>

                <!-- Message -->
                <h3 class="text-center font-bold text-sm mb-1" style="color: #374151;">Add New Customer?</h3>
                <p class="text-center text-xs mb-4" style="color: #666;">
                    Register this new customer to the system? Their information will be saved for future orders.
                </p>

                <!-- Actions -->
                <div class="flex justify-center gap-2">
                    <button type="button" onclick="closeConfirmCustomer()" class="px-4 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all text-xs font-medium text-gray-700">
                        No, Cancel
                    </button>
                    <button type="button" onclick="submitCustomer()" class="px-4 py-1.5 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all text-xs font-medium shadow-md hover:shadow-lg">
                        Yes, Add
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Delete Customer Confirmation Modal -->
    <div id="deleteCustomerModal" class="modal-overlay fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50 p-4" onclick="if(event.target === this) closeDeleteCustomerModal()">
        <div class="modal-content bg-amber-50 rounded-lg max-w-xs w-full shadow-2xl transform transition-all animate-fadeIn" onclick="event.stopPropagation()">
            <div class="p-4">
                <!-- Icon -->
                <div class="flex justify-center mb-3">
                    <div class="flex items-center justify-center w-10 h-10 bg-red-100 rounded-full">
                        <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4v.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                </div>

                <!-- Message -->
                <h3 class="text-center font-bold text-sm mb-1" style="color: #374151;">Delete Customer?</h3>
                <p class="text-center text-xs mb-4" style="color: #666;">
                    Delete <span id="deleteCustomerName" class="font-semibold">-</span>? This action cannot be undone.
                </p>

                <!-- Actions -->
                <div class="flex justify-center gap-2">
                    <button type="button" onclick="closeDeleteCustomerModal()" class="px-4 py-1.5 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all text-xs font-medium text-gray-700">
                        No, Keep
                    </button>
                    <button type="button" onclick="submitDeleteCustomer()" class="px-4 py-1.5 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-all text-xs font-medium shadow-md hover:shadow-lg">
                        Yes, Delete
                    </button>
                </div>
            </div>
        </div>
    </div

    <!-- Improved Received Stock Reports Modal -->
    <div id="receivedStockReportsModal" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 backdrop-blur-sm transition-opacity duration-300">
        <div class="flex items-center justify-center min-h-screen p-4">
            <div class="bg-amber-50 rounded-2xl w-full max-h-[95vh] shadow-2xl transform transition-all duration-300 scale-95 opacity-0 modal-content overflow-y-auto border-2 border-slate-700">
                
                <!-- Header -->
                <div class="bg-gradient-to-r from-slate-700 to-slate-800 text-white px-8 py-6 rounded-t-2xl sticky top-0 z-10">
                    <div class="flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <div>
                                <h3 class="text-2xl font-bold flex items-center gap-3">
                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Received Stock Reports
                                </h3>
                                <p class="text-slate-300 text-sm mt-1">Track and manage incoming inventory</p>
                            </div>
                        </div>
                        <button onclick="closeReceivedStockReportsModal()" 
                                class="text-white hover:bg-white hover:bg-opacity-20 rounded-full p-2 transition-all duration-200">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <div class="p-8">
                    <!-- Enhanced Filter Section -->
                    <div class="bg-gradient-to-br from-slate-50 to-gray-50 rounded-xl p-6 mb-6 border border-slate-200 shadow-sm">
                        <div class="flex items-center gap-2 mb-4">
                            <svg class="w-5 h-5 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/>
                            </svg>
                            <h4 class="text-lg font-semibold text-slate-800">Filters</h4>
                        </div>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                            <!-- Date From -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Date From
                                </label>
                                <input type="date" id="filterDateFrom" 
                                       class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white">
                            </div>

                            <!-- Date To -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                    </svg>
                                    Date To
                                </label>
                                <input type="date" id="filterDateTo" 
                                       class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white">
                            </div>

                            <!-- Material Filter -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                    </svg>
                                    Material
                                </label>
                                <select id="filterMaterial" 
                                        class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white">
                                    <option value="">All Materials</option>
                                </select>
                            </div>

                            <!-- Status Filter -->
                            <div>
                                <label class="block text-sm font-medium text-slate-700 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Status
                                </label>
                                <select id="filterStatus" 
                                        class="w-full border border-slate-300 rounded-lg px-4 py-2.5 focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all duration-200 bg-white">
                                    <option value="">All Status</option>
                                    <option value="received">Received</option>
                                    <option value="partial">Partial</option>
                                    <option value="defective">Defective</option>
                                </select>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex gap-3 mt-6">
                            <button onclick="filterReceivedStock()" 
                                    class="px-6 py-2.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-lg hover:from-amber-600 hover:to-orange-700 transition-all duration-200 shadow-md hover:shadow-lg flex items-center gap-2 font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Apply Filters
                            </button>
                            <button onclick="resetFilters()" 
                                    class="px-6 py-2.5 bg-white border-2 border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-all duration-200 flex items-center gap-2 font-medium">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                                Reset
                            </button>
                            <div class="ml-auto flex gap-2">
                                <button onclick="exportToExcel()" 
                                        class="px-6 py-2.5 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all duration-200 flex items-center gap-2 font-medium shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Export Excel
                                </button>
                                <button onclick="printReport()" 
                                        class="px-6 py-2.5 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition-all duration-200 flex items-center gap-2 font-medium shadow-md hover:shadow-lg">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                                    </svg>
                                    Print
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Enhanced Summary Cards -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div class="bg-gradient-to-br from-amber-50 to-orange-50 rounded-xl p-5 border border-amber-300 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-amber-700 mb-1">Total Received</p>
                                    <p id="totalReceived" class="text-3xl font-bold text-amber-900">0</p>
                                </div>
                                <div class="bg-amber-500 bg-opacity-20 rounded-full p-3">
                                    <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
                        

                        <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-5 border border-red-200 shadow-sm hover:shadow-md transition-shadow duration-200">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm font-medium text-red-700 mb-1">Total Defects</p>
                                    <p id="totalDefects" class="text-3xl font-bold text-red-900">0</p>
                                </div>
                                <div class="bg-red-500 bg-opacity-20 rounded-full p-3">
                                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                </div>
                            </div>
                        </div>
 </div>
                    <!-- Enhanced Reports Table -->
                    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden w-100%">
                        <div class="overflow-x-auto">
                            <table class="w-full">
                                <thead>
                                    <tr class="bg-gradient-to-r from-slate-100 to-slate-200 border-b-2 border-slate-300">
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                                </svg>
                                                Date
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                                </svg>
                                                PO Number
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                                                </svg>
                                                Material
                                            </div>
                                        </th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Quantity</th>
                                        <th class="px-6 py-4 text-right text-xs font-bold text-slate-700 uppercase tracking-wider">Defect Qty</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Supplier</th>
                                        <th class="px-6 py-4 text-center text-xs font-bold text-slate-700 uppercase tracking-wider">Status</th>
                                        <th class="px-6 py-4 text-left text-xs font-bold text-slate-700 uppercase tracking-wider">Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="receivedStockTableBody" class="divide-y divide-slate-200">
                                    <tr>
                                        <td colspan="8" class="py-12 px-4">
                                            <div class="flex flex-col items-center justify-center text-slate-400">
                                                <svg class="w-16 h-16 mb-4 animate-spin" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                                </svg>
                                                <p class="text-lg font-medium">Loading data...</p>
                                            </div>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>

                        <!-- Pagination -->
                        <div class="bg-slate-50 px-6 py-4 border-t border-slate-200">
                            <div class="flex items-center justify-between">
                                <div class="text-sm text-slate-600">
                                    Showing <span class="font-medium" id="showingFrom">0</span> to 
                                    <span class="font-medium" id="showingTo">0</span> of 
                                    <span class="font-medium" id="totalRecords">0</span> results
                                </div>
                                <div class="flex gap-2">
                                    <button onclick="previousPage()" 
                                            class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Previous
                                    </button>
                                    <button onclick="nextPage()" 
                                            class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 transition-colors duration-200 disabled:opacity-50 disabled:cursor-not-allowed">
                                        Next
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Enhanced Modal Animation Styles -->
    <style>
    /* Modal entrance animation */
    #receivedStockReportsModal:not(.hidden) .modal-content {
        animation: modalSlideIn 0.3s ease-out forwards;
    }

    @keyframes modalSlideIn {
        from {
            transform: scale(0.95) translateY(-20px);
            opacity: 0;
        }
        to {
            transform: scale(1) translateY(0);
            opacity: 1;
        }
    }

    /* Table row hover effect */
    #receivedStockTableBody tr:hover {
        background-color: #f8fafc;
        transition: background-color 0.2s ease;
    }

    /* Smooth transitions for all interactive elements */
    button, input, select {
        transition: all 0.2s ease;
    }

    /* Custom scrollbar for the modal */
    .overflow-y-auto::-webkit-scrollbar {
        width: 8px;
    }

    .overflow-y-auto::-webkit-scrollbar-track {
        background: #f1f5f9;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 10px;
    }

    .overflow-y-auto::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }
    </style>

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
                purchaseOrdersTab.style.borderColor = '#FDE68A';
                suppliersTab.style.backgroundColor = '#475569';
                suppliersTab.style.color = '#FFFFFF';
                suppliersTab.style.borderColor = '#64748b';
                purchaseOrdersTable.classList.remove('hidden');
                suppliersTable.classList.add('hidden');
                purchaseOrdersButton.classList.remove('hidden');
                suppliersButton.classList.add('hidden');
            } else {
                suppliersTab.style.backgroundColor = '#FFF1DA';
                suppliersTab.style.color = '#111827';
                suppliersTab.style.borderColor = '#FDE68A';
                purchaseOrdersTab.style.backgroundColor = '#475569';
                purchaseOrdersTab.style.color = '#FFFFFF';
                purchaseOrdersTab.style.borderColor = '#64748b';
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
            // Reset pricing fields
            const newItemUnitPrice = document.getElementById('newItemUnitPrice');
            const newItemUnitPriceHidden = document.getElementById('newItemUnitPriceHidden');
            const newItemLineTotal = document.getElementById('newItemLineTotal');
            if (newItemUnitPrice) newItemUnitPrice.value = '';
            if (newItemUnitPriceHidden) newItemUnitPriceHidden.value = '';
            if (newItemLineTotal) newItemLineTotal.textContent = '₱0.00';
        }

        // Real-time unit price + line total for New Purchase Order modal
        (function() {
            const newItemMaterial = document.getElementById('newItemMaterial');
            const newItemQty = document.getElementById('newItemQty');
            const newItemUnitPrice = document.getElementById('newItemUnitPrice');
            const newItemUnitPriceHidden = document.getElementById('newItemUnitPriceHidden');
            const newItemLineTotal = document.getElementById('newItemLineTotal');

            function toNumber(value) {
                const n = parseFloat(value);
                return Number.isFinite(n) ? n : 0;
            }

            function formatCurrency(num) {
                return '₱' + num.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            }

            function getSelectedUnitPrice() {
                if (!newItemMaterial) return 0;
                const opt = newItemMaterial.options[newItemMaterial.selectedIndex];
                const priceAttr = opt ? opt.getAttribute('data-price') : null;
                return toNumber(priceAttr);
            }

            function updatePricingFields() {
                const unit = getSelectedUnitPrice();
                const qty = toNumber(newItemQty?.value || '0');
                if (newItemUnitPrice) newItemUnitPrice.value = unit ? formatCurrency(unit) : '';
                if (newItemUnitPriceHidden) newItemUnitPriceHidden.value = unit ? unit.toFixed(2) : '';
                const total = unit * (qty || 0);
                if (newItemLineTotal) newItemLineTotal.textContent = formatCurrency(total);
            }

            if (newItemMaterial) {
                newItemMaterial.addEventListener('change', () => {
                    // If quantity empty or <1, default to 1 on first select
                    if (newItemQty && (!newItemQty.value || toNumber(newItemQty.value) < 1)) {
                        newItemQty.value = '1';
                    }
                    updatePricingFields();
                });
            }
            if (newItemQty) {
                ['input','change','blur'].forEach(evt => newItemQty.addEventListener(evt, () => {
                    if (toNumber(newItemQty.value) < 1) newItemQty.value = '1';
                    updatePricingFields();
                }));
            }

            // Initialize pricing display
            updatePricingFields();
        })();

        function openViewOrderModal(orderId) {
            document.getElementById('viewOrderItemsModal').classList.remove('hidden');

            const itemsContainer = document.getElementById('viewOrderItemsContainer');
            itemsContainer.innerHTML = '<div class="p-6 rounded-lg border text-center" style="background-color: rgba(255,255,255,0.7); border-color: #374151; color: #999;">Loading items...</div>';

            fetch(`/procurement/purchase-orders/${orderId}/items?include_received=1`)
                .then(response => response.json())
                .then(data => {
                    if (!data.success || !data.items || data.items.length === 0) {
                        itemsContainer.innerHTML = '<div class="p-6 rounded-lg border text-center" style="background-color: rgba(255,255,255,0.7); border-color: #374151; color: #999;">No items found for this order.</div>';
                        return;
                    }

                    if (data.order) {
                        const orderNumber = data.order.order_number || '-';
                        const supplierName = data.order.supplier_name || '-';
                        document.getElementById('viewOrderHeaderNumber').textContent = `Order #${orderNumber}`;
                        document.getElementById('viewOrderHeaderSupplier').textContent = supplierName;
                        document.getElementById('viewOrderDetailNumber').textContent = orderNumber;
                        document.getElementById('viewOrderDetailSupplier').textContent = supplierName;
                    } else {
                        const row = document.querySelector(`button[onclick="event.stopPropagation(); openViewOrderModal(${orderId})"]`)?.closest('tr');
                        if (row) {
                            const orderCell = row.querySelector('td:first-child');
                            const supplierCell = row.querySelector('td:nth-child(2)');
                            const orderNumber = orderCell ? orderCell.textContent.trim() : '-';
                            const supplierName = supplierCell ? supplierCell.textContent.trim() : '-';
                            document.getElementById('viewOrderHeaderNumber').textContent = `Order #${orderNumber}`;
                            document.getElementById('viewOrderHeaderSupplier').textContent = supplierName;
                            document.getElementById('viewOrderDetailNumber').textContent = orderNumber;
                            document.getElementById('viewOrderDetailSupplier').textContent = supplierName;
                        }
                    }

                    // Calculate totals
                    let totalAmount = 0;
                    const itemsHTML = data.items.map(item => {
                        const lineTotal = (item.ordered_quantity || 0) * (item.unit_price || 0);
                        totalAmount += lineTotal;
                        const received = Number(item.already_received || 0);
                        const ordered = Number(item.ordered_quantity || 0);
                        
                        return `
                            <div class="p-5 rounded-lg border-l-4 hover:shadow-md transition" style="background-color: rgba(255,255,255,0.85); border-left-color: #374151;">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h5 class="font-bold text-lg" style="color: #374151;">${item.material_name || 'Unknown Material'}</h5>
                                        <p class="text-sm mt-1" style="color: #666;">Unit Price: <span class="font-semibold" style="color: #374151;">₱${Number(item.unit_price || 0).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</span></p>
                                    </div>
                                    <div class="text-right">
                                        <div class="inline-block px-4 py-2 rounded-full font-bold text-lg" style="background-color: #F57C00; color: white;">
                                            ${Number(ordered).toFixed(2)} <span class="text-sm">units</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-3 pt-3 grid grid-cols-3 gap-4" style="border-top: 1px solid #E8D5BF;">
                                    <div>
                                        <p class="text-xs font-semibold" style="color: #666;">Received</p>
                                        <p class="text-sm font-bold" style="color: #374151;">${Number(received).toFixed(2)}</p>
                                    </div>
                                    <div>
                                        <p class="text-xs font-semibold" style="color: #666;">Remaining</p>
                                        <p class="text-sm font-bold" style="color: #374151;">${Number(ordered - received).toFixed(2)}</p>
                                    </div>
                                    <div class="text-right">
                                        <p class="text-xs font-semibold" style="color: #666;">Line Total</p>
                                        <p class="text-sm font-bold" style="color: #388E3C;">₱${Number(lineTotal).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}</p>
                                    </div>
                                </div>
                            </div>
                        `;
                    }).join('');

                    document.getElementById('viewOrderTotalItems').textContent = data.items.length;
                    document.getElementById('viewOrderTotalAmount').textContent = `₱${Number(totalAmount).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 })}`;
                    itemsContainer.innerHTML = itemsHTML;
                })
                .catch(() => {
                    itemsContainer.innerHTML = '<div class="p-6 rounded-lg border text-center" style="background-color: rgba(255,255,255,0.7); border-color: #374151; color: #e74c3c;">Failed to load items for this order.</div>';
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

                    // Update summary - with null checks
                    const totalReceivedEl = document.getElementById('totalReceived');
                    const totalDefectsEl = document.getElementById('totalDefects');
                    
                    if (totalReceivedEl) totalReceivedEl.textContent = totalReceived.toFixed(2);
                    if (totalDefectsEl) totalDefectsEl.textContent = totalDefects.toFixed(2);

                    // Populate material filter
                    const materialSelect = document.getElementById('filterMaterial');
                    const uniqueMaterials = [...new Set(data.movements.map(m => m.material_name))];
                    materialSelect.innerHTML = '<option value="">All Materials</option>' + 
                        uniqueMaterials.map(material => `<option value="${material}">${material}</option>`).join('');
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">No received stock records found</td></tr>';
                    const totalReceivedEl = document.getElementById('totalReceived');
                    const totalDefectsEl = document.getElementById('totalDefects');
                    if (totalReceivedEl) totalReceivedEl.textContent = '0';
                    if (totalDefectsEl) totalDefectsEl.textContent = '0';
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

                    // Update summary - with null checks
                    const totalReceivedEl = document.getElementById('totalReceived');
                    const totalDefectsEl = document.getElementById('totalDefects');
                    
                    if (totalReceivedEl) totalReceivedEl.textContent = totalReceived.toFixed(2);
                    if (totalDefectsEl) totalDefectsEl.textContent = totalDefects.toFixed(2);
                } else {
                    tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-gray-400">No records found matching the filters</td></tr>';
                    const totalReceivedEl = document.getElementById('totalReceived');
                    const totalDefectsEl = document.getElementById('totalDefects');
                    if (totalReceivedEl) totalReceivedEl.textContent = '0';
                    if (totalDefectsEl) totalDefectsEl.textContent = '0';
                }
            } catch (error) {
                console.error('Error filtering received stock:', error);
                tbody.innerHTML = '<tr><td colspan="8" class="py-8 px-4 text-center text-red-400">Error loading data</td></tr>';
            }
        }

        // Reset Filters
        function resetFilters() {
            document.getElementById('filterDateFrom').value = '';
            document.getElementById('filterDateTo').value = '';
            document.getElementById('filterMaterial').value = '';
            if (document.getElementById('filterStatus')) {
                document.getElementById('filterStatus').value = '';
            }
            loadReceivedStockReports();
        }

        // Export to Excel (placeholder - requires backend implementation)
        function exportToExcel() {
            alert('Export to Excel functionality will be implemented with backend support.');
            // Future implementation: window.location.href = '/procurement/received-stock-reports/export';
        }

        // Print Report
        function printReport() {
            window.print();
        }

        // Pagination placeholders (for future implementation with backend)
        function previousPage() {
            console.log('Previous page clicked');
            // Future implementation with pagination parameters
        }

        function nextPage() {
            console.log('Next page clicked');
            // Future implementation with pagination parameters
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

        // Purchase Orders and Suppliers data for edit modals
        const purchaseOrdersData = @json($purchaseOrders ?? []);
        const suppliersData = @json($suppliers ?? []);

        function editOrder(id) {
            const order = purchaseOrdersData.data ? purchaseOrdersData.data.find(o => o.id === id) : purchaseOrdersData.find(o => o.id === id);
            if (!order) {
                console.error('Order not found:', id);
                return;
            }
            
            document.getElementById('editPOOrderNumber').value = order.order_number || 'PO-' + String(order.id).padStart(6, '0');
            document.getElementById('editPOSupplierName').value = order.supplier ? order.supplier.name : 'N/A';
            document.getElementById('editPOStatus').value = order.status || 'Pending';
            document.getElementById('editPOPaymentStatus').value = order.payment_status || 'Pending';
            document.getElementById('editPurchaseOrderForm').action = `/procurement/purchase-orders/${id}`;
            
            document.getElementById('editPurchaseOrderModal').classList.remove('hidden');
        }

        function closeEditPurchaseOrderModal() {
            document.getElementById('editPurchaseOrderModal').classList.add('hidden');
            document.getElementById('editPurchaseOrderForm').reset();
        }

        function deleteOrder(id) {
            if (confirm('Are you sure you want to cancel this purchase order?')) {
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
            const supplier = suppliersData.find(s => s.id === id);
            if (!supplier) {
                console.error('Supplier not found:', id);
                return;
            }
            
            document.getElementById('editSupplierName').value = supplier.name || '';
            document.getElementById('editSupplierContactPerson').value = supplier.contact_person || '';
            document.getElementById('editSupplierPhone').value = supplier.phone || '';
            document.getElementById('editSupplierEmail').value = supplier.email || '';
            document.getElementById('editSupplierAddress').value = supplier.address || '';
            document.getElementById('editSupplierPaymentTerms').value = supplier.payment_terms || '';
            document.getElementById('editSupplierStatus').value = supplier.status || 'active';
            document.getElementById('editSupplierForm').action = `/procurement/suppliers/${id}`;
            
            document.getElementById('editSupplierModal').classList.remove('hidden');
        }

        function closeEditSupplierModal() {
            document.getElementById('editSupplierModal').classList.add('hidden');
            document.getElementById('editSupplierForm').reset();
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
        });
    </script>

@endsection
