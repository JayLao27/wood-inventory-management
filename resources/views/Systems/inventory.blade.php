@extends('layouts.system')

@section('main-content')
        <!-- Main Content -->
        <div class="flex-1 p-8">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Inventory Management</h1>
                        <p class="text-gray-600 mt-2">Track and manage raw materials and finished products</p>
                    </div>
                    <div class="flex space-x-3">
                        <button class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition">
                            Reports
                        </button>
                        <button class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition">
                            Receive Stock
                        </button>
                        <button onclick="openAddItemModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                            + Add Item
                        </button>
                    </div>
                </div>
            </div>

            <!-- Metrics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-6 mb-8">
                <!-- Total Items Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">Total Items</p>
                            <p class="text-3xl font-bold mt-2">{{ $totalItems ?? 10 }}</p>
                            <p class="text-slate-400 text-xs mt-1">{{ $totalItems ?? 10 }} Items</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Low Stock Alerts Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">Low Stock Alerts</p>
                            <p class="text-3xl font-bold mt-2">{{ $lowStockAlerts ?? 3 }}</p>
                            <p class="text-slate-400 text-xs mt-1">Items requiring attention</p>
                        </div>
                        <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Total Value Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">Total Value</p>
                            <p class="text-3xl font-bold mt-2">₱{{ number_format($totalValue ?? 343711.41, 2) }}</p>
                            <p class="text-slate-400 text-xs mt-1">Raw materials inventory value</p>
                        </div>
                        <div class="w-12 h-12 bg-purple-500 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- New Order Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">New Order</p>
                            <p class="text-3xl font-bold mt-2">{{ $newOrders ?? 2 }}</p>
                            <p class="text-slate-400 text-xs mt-1">Finished products inventory value</p>
                        </div>
                        <div class="w-12 h-12 bg-blue-400 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Pending Deliveries Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">Pending Deliveries</p>
                            <p class="text-3xl font-bold mt-2">{{ $pendingDeliveries ?? 3 }}</p>
                            <p class="text-slate-400 text-xs mt-1">Purchase orders awaiting delivery</p>
                            <p class="text-slate-400 text-xs">View auto-requests</p>
                        </div>
                        <div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Inventory Items Section -->
            <div class="bg-slate-700 rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-white">Inventory Items</h2>
                        <p class="text-slate-300 text-sm mt-1">Manage your raw materials and finished products</p>
                    </div>
                    <button onclick="openAddItemModal()" class="px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
                        + Add Product
                    </button>
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
                            <input type="text" placeholder="Search items....." class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <button class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 3a1 1 0 000 2h11.586l-1.293 1.293a1 1 0 101.414 1.414L16.414 6H19a1 1 0 100-2H3zM3 11a1 1 0 100 2h11.586l-1.293-1.293a1 1 0 111.414-1.414L16.414 14H19a1 1 0 100-2H3z"/>
                        </svg>
                        <span>All Categories</span>
                    </button>
                </div>

                <!-- Tabs -->
                <div class="flex space-x-1 mb-6">
                    <button onclick="showTab('materials')" id="materials-tab" class="px-4 py-2 bg-slate-600 text-white rounded-lg">Materials</button>
                    <button onclick="showTab('products')" id="products-tab" class="px-4 py-2 bg-slate-800 text-slate-300 rounded-lg hover:bg-slate-600">Products</button>
                </div>

                <!-- Materials Table -->
                <div id="materials-table" class="overflow-x-auto">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-slate-600">
                                <th class="text-left py-3 px-4 font-medium">Name</th>
                                <th class="text-left py-3 px-4 font-medium">Category</th>
                                <th class="text-left py-3 px-4 font-medium">Current Stock</th>
                                <th class="text-left py-3 px-4 font-medium">Min Stock</th>
                                <th class="text-left py-3 px-4 font-medium">Unit Cost</th>
                                <th class="text-left py-3 px-4 font-medium">Supplier</th>
                                <th class="text-left py-3 px-4 font-medium">Status</th>
                                <th class="text-left py-3 px-4 font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-600">
                            @forelse($materials ?? [] as $material)
                            <tr class="hover:bg-slate-600 cursor-pointer" onclick="openEditModal('material', {{ $material->id }})">
                                <td class="py-3 px-4">{{ $material->name }}</td>
                                <td class="py-3 px-4">{{ $material->category }}</td>
                                <td class="py-3 px-4">{{ $material->current_stock }} {{ $material->unit }}</td>
                                <td class="py-3 px-4">{{ $material->minimum_stock }} {{ $material->unit }}</td>
                                <td class="py-3 px-4">₱{{ number_format($material->unit_cost, 2) }}</td>
                                <td class="py-3 px-4">{{ $material->supplier->name ?? 'N/A' }}</td>
                                <td class="py-3 px-4">
                                    @if($material->isLowStock())
                                        <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full">Low Stock</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">In Stock</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <button onclick="event.stopPropagation(); openEditModal('material', {{ $material->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button onclick="event.stopPropagation(); openStockModal('material', {{ $material->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button onclick="event.stopPropagation(); deleteItem('material', {{ $material->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-8 px-4 text-center text-slate-400">No materials found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <!-- Products Table -->
                <div id="products-table" class="overflow-x-auto hidden">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-slate-600">
                                <th class="text-left py-3 px-4 font-medium">Name</th>
                                <th class="text-left py-3 px-4 font-medium">Category</th>
                                <th class="text-left py-3 px-4 font-medium">Current Stock</th>
                                <th class="text-left py-3 px-4 font-medium">Min Stock</th>
                                <th class="text-left py-3 px-4 font-medium">Production Cost</th>
                                <th class="text-left py-3 px-4 font-medium">Selling Price</th>
                                <th class="text-left py-3 px-4 font-medium">Status</th>
                                <th class="text-left py-3 px-4 font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-600">
                            @forelse($products ?? [] as $product)
                            <tr class="hover:bg-slate-600 cursor-pointer" onclick="openEditModal('product', {{ $product->id }})">
                                <td class="py-3 px-4">{{ $product->product_name }}</td>
                                <td class="py-3 px-4">{{ $product->category }}</td>
                                <td class="py-3 px-4">{{ $product->current_stock }} {{ $product->unit }}</td>
                                <td class="py-3 px-4">{{ $product->minimum_stock }} {{ $product->unit }}</td>
                                <td class="py-3 px-4">₱{{ number_format($product->production_cost, 2) }}</td>
                                <td class="py-3 px-4">₱{{ number_format($product->selling_price, 2) }}</td>
                                <td class="py-3 px-4">
                                    @if($product->isLowStock())
                                        <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full">Low Stock</span>
                                    @else
                                        <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">In Stock</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <button onclick="event.stopPropagation(); openEditModal('product', {{ $product->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button onclick="event.stopPropagation(); openStockModal('product', {{ $product->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button onclick="event.stopPropagation(); deleteItem('product', {{ $product->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 000 2h2a1 1 0 100-2H9z" clip-rule="evenodd"/>
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-8 px-4 text-center text-slate-400">No products found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
@endsection
