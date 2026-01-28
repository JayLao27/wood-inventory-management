@extends('layouts.system')

@section('main-content')
        <!-- Main Content -->
        <div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Inventory Management</h1>
                        <p class="text-gray-600 mt-2">Track and manage raw materials and finished products</p>
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
                        @include('components.icons.package', ['class' => 'icon-package'])
                    </div>
                </div>

                <!-- Low Stock Alerts Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                    <div>
                    <p class="text-slate-300 text-sm">Low Stock Alerts</p>
    <!--changing red when lowstocks--><p class="text-3xl font-bold text-white mt-2 {{ ($lowStockAlerts ?? 3) > 4 ? 'text-red-500' : '' }}">{{ $lowStockAlerts ?? 3 }}</p>
                    <p class="text-slate-400 text-xs mt-1 {{ ($lowStockAlerts ?? 3) > 4 ? 'text-red-500' : '' }}">{{ $lowStockAlerts ?? 3 }} Items</p>
                        </div>
                        @include('components.icons.cart', ['class' => ($lowStockAlerts ?? 3) > 4 ? 'icon-cart text-red-500' : 'icon-cart'])
                    </div>
                </div>

                <!-- Total Value Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">Total Value</p>
                            <p class="text-2xl  font-bold mt-2">₱{{ number_format($totalValue ?? 343711.41, 2) }}</p>
                            <p class="text-slate-400 text-xs mt-1">Raw materials inventory value</p>
                        </div>
                      @include('components.icons.cart', ['class' => 'icon-cart']) 
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
                    @include('components.icons.cart', ['class' => 'icon-cart'])
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
                         @include('components.icons.cart', ['class' => 'icon-cart'])
                    </div>
                </div>
            </div>

            <!-- Inventory Items Section -->
            <div class="bg-slate-700 rounded-lg p-6 ">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-white">Inventory Items</h2>
                        <p class="text-slate-300 text-sm mt-1">Manage raw materials from suppliers and finished products from production</p>
                    </div>
                    <div id="materialsButton" class="flex space-x-3">
                        <button onclick="openAddItemModal()" class="px-4 py-2 bg-white text-[#374151] rounded-lg hover:bg-[#DEE4EF] flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>Add Item</span>
                        </button>
                    </div>
                    <div id="productsButton" class="flex space-x-3 hidden">
                        <button onclick="openAddProductModal()" class="px-4 py-2 bg-white text-[#374151] rounded-lg hover:bg-[#DEE4EF] transition flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            <span> Add Product</span>
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
                <div class="flex space-x-1 w-full mb-6">
                    <button onclick="showTab('materials')" id="materials-tab" class="flex-auto px-[255px] py-2 rounded-lg" style="background-color: #FFF1DA; color: #111827;">Materials</button>
                    <button onclick="showTab('products')" id="products-tab" class="flex-auto px-[255px] py-2 rounded-lg border" style="background-color: #374151; border: 1px solid #FFFFFF; color: #FFFFFF;">Products</button>
                </div>

                <!-- Materials Table -->
                <div id="materials-table" class="space-y-3 overflow-y-auto" style="max-height:60vh;">
                    @forelse($materials ?? [] as $material)
                    <div class="p-4 border border-slate-600 rounded-lg hover:bg-slate-600 hover:border-slate-500 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-white">{{ $material->name }}</h3>
                                <p class="text-sm text-slate-300">{{ $material->supplier->name ?? 'N/A' }} • {{ $material->unit }}</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                @if($material->isLowStock())
                                    <span class="px-2 py-1 bg-red-500 text-white text-xs rounded-full">Low Stock</span>
                                @else
                                    <span class="px-2 py-1 bg-green-500 text-white text-xs rounded-full">In Stock</span>
                                @endif
                                <span class="text-white font-semibold">₱{{ number_format($material->unit_cost, 2) }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mt-3 text-sm">
                            <div>
                                <span class="text-slate-400">Current Stock</span>
                                <p class="text-white font-medium">{{ $material->current_stock }} {{ $material->unit }}</p>
                            </div>
                            <div>
                                <span class="text-slate-400">Min Stock</span>
                                <p class="text-white font-medium">{{ $material->minimum_stock }} {{ $material->unit }}</p>
                            </div>
                            <div class="flex items-center space-x-2 justify-end">
                                <button onclick="event.stopPropagation(); openStockModal('material', {{ $material->id }})" class="p-1 hover:bg-slate-500 rounded flex items-center space-x-1" title="View Items">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-xs">View</span>
                                </button>
                                <button onclick="event.stopPropagation(); deleteItem('material', {{ $material->id }}, '{{ $material->name }}')" class="p-1 hover:bg-slate-500 rounded" title="Delete">
                                    <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 px-4 text-center text-slate-400">
                        <p>No materials found</p>
                    </div>
                    @endforelse
                </div>

                <!-- Products Table -->
                <div id="products-table" class="space-y-3 overflow-y-auto hidden" style="max-height:60vh;">
                    @forelse($products ?? [] as $product)
                    <div class="p-4 border border-slate-600 rounded-lg hover:bg-slate-600 hover:border-slate-500 transition">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-semibold text-white">{{ $product->product_name }}</h3>
                                <p class="text-sm text-slate-300">Finished Product</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="text-white font-semibold">₱{{ number_format($product->selling_price, 2) }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-3 text-sm">
                            <div>
                                <span class="text-slate-400">Production Cost</span>
                                <p class="text-white font-medium">₱{{ number_format($product->production_cost, 2) }}</p>
                            </div>
                            <div>
                                <span class="text-slate-400">Selling Price</span>
                                <p class="text-white font-medium">₱{{ number_format($product->selling_price, 2) }}</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 mt-3 justify-end">
                            <button onclick="event.stopPropagation(); deleteItem('product', {{ $product->id }}, '{{ $product->product_name }}')" class="p-1 hover:bg-slate-500 rounded" title="Delete">
                                <svg class="w-4 h-4 text-white" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 px-4 text-center text-slate-400">
                        <p>No products found</p>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Add Item Modal (for Materials) -->
        <div id="addItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900">Add New Material</h3>
                            <button onclick="closeAddItemModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <form id="addItemForm" method="POST" action="{{ route('inventory.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="material">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Material Name *</label>
                                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                    <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        <option value="">Select Category</option>
                                        <option value="lumber">Lumber</option>
                                        <option value="hardware">Hardware</option>
                                        <option value="finishing">Finishing</option>
                                        <option value="tools">Tools</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                                    <input type="text" name="unit" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Current Stock *</label>
                                    <input type="number" name="current_stock" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Minimum Stock *</label>
                                    <input type="number" name="minimum_stock" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit Cost *</label>
                                    <input type="number" name="unit_cost" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Supplier *</label>
                                    <select name="supplier_id" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers ?? [] as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" onclick="closeAddItemModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Add Item
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Add Product Modal -->
        <div id="addProductModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900">Add New Product</h3>
                            <button onclick="closeAddProductModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <form id="addProductForm" method="POST" action="{{ route('inventory.store') }}">
                            @csrf
                            <input type="hidden" name="type" value="product">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                                    <input type="text" name="product_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                                    <input type="text" name="unit" value="pieces" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Production Cost *</label>
                                    <input type="number" name="production_cost" id="productProductionCost" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Selling Price *</label>
                                    <input type="number" name="selling_price" id="productSellingPrice" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" onclick="closeAddProductModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Add Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock View Modal -->
        <div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-4xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-900">Item Details & Movement History</h3>
                                <p id="itemName" class="text-sm text-gray-600 mt-1"></p>
                            </div>
                            <button onclick="closeStockModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>

                        <!-- Item Info Cards -->
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-blue-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-600">Current Stock</p>
                                <p id="currentStock" class="text-2xl font-bold text-blue-600 mt-1">-</p>
                            </div>
                            <div class="bg-yellow-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-600">Minimum Stock</p>
                                <p id="minimumStock" class="text-2xl font-bold text-yellow-600 mt-1">-</p>
                            </div>
                            <div class="bg-green-50 p-4 rounded-lg">
                                <p class="text-sm text-gray-600">Unit Cost</p>
                                <p id="unitCost" class="text-2xl font-bold text-green-600 mt-1">-</p>
                            </div>
                        </div>

                        <!-- Inventory Movements Table -->
                        <div class="mb-6">
                            <h4 class="text-lg font-semibold text-gray-900 mb-4">Movement History</h4>
                            <div class="overflow-x-auto border border-gray-200 rounded-lg">
                                <table class="w-full text-sm">
                                    <thead class="bg-gray-100 border-b border-gray-200">
                                        <tr>
                                            <th class="px-4 py-3 text-left font-medium text-gray-700">Date</th>
                                            <th class="px-4 py-3 text-left font-medium text-gray-700">Type</th>
                                            <th class="px-4 py-3 text-right font-medium text-gray-700">Quantity</th>
                                            <th class="px-4 py-3 text-left font-medium text-gray-700">Notes</th>
                                        </tr>
                                    </thead>
                                    <tbody id="movementTableBody" class="divide-y divide-gray-200">
                                        <tr>
                                            <td colspan="4" class="px-4 py-8 text-center text-gray-500">
                                                Loading movements...
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        <div class="flex justify-end mt-6">
                            <button onclick="closeStockModal()" class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteConfirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
            <div class="bg-white rounded-lg shadow-lg p-6 max-w-md w-full mx-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <svg class="h-6 w-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4v2m0-6a9 9 0 110-18 9 9 0 010 18zm0-4v2m0-6V7m0 4v2"/>
                        </svg>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-medium text-gray-900">Delete Item</h3>
                        <p class="mt-2 text-sm text-gray-600">Are you sure you want to delete <span id="deleteItemName" class="font-semibold"></span>? This action cannot be undone.</p>
                    </div>
                </div>
                
                <div class="mt-6 flex justify-end space-x-3">
                    <button onclick="closeDeleteModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 font-medium">
                        Cancel
                    </button>
                    <button onclick="confirmDelete()" class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 font-medium">
                        Delete
                    </button>
                </div>
            </div>
        </div>
        

        <script>
            let deleteItemData = { type: null, id: null, name: null };

            // Tab functionality
            function showTab(tab) {
                const materialsTab = document.getElementById('materials-tab');
                const productsTab = document.getElementById('products-tab');
                const materialsTable = document.getElementById('materials-table');
                const productsTable = document.getElementById('products-table');
                const materialsButton = document.getElementById('materialsButton');
                const productsButton = document.getElementById('productsButton');
                
                if (tab === 'materials') {
                    materialsTab.style.backgroundColor = '#FFF1DA';
                    materialsTab.style.color = '#111827';
                    materialsTab.style.border = 'none';
                    productsTab.style.backgroundColor = '#374151';
                    productsTab.style.color = '#FFFFFF';
                    productsTab.style.border = '1px solid #FFFFFF';
                    materialsTable.classList.remove('hidden');
                    productsTable.classList.add('hidden');
                    materialsButton.classList.remove('hidden');
                    productsButton.classList.add('hidden');
                } else {
                    productsTab.style.backgroundColor = '#FFF1DA';
                    productsTab.style.color = '#111827';
                    productsTab.style.border = 'none';
                    materialsTab.style.backgroundColor = '#374151';
                    materialsTab.style.color = '#FFFFFF';
                    materialsTab.style.border = '1px solid #FFFFFF';
                    productsTable.classList.remove('hidden');
                    materialsTable.classList.add('hidden');
                    materialsButton.classList.add('hidden');
                    productsButton.classList.remove('hidden');
                }
            }

            // Modal functions
            function openAddItemModal() {
                document.getElementById('addItemModal').classList.remove('hidden');
            }

            function closeAddItemModal() {
                document.getElementById('addItemModal').classList.add('hidden');
                document.getElementById('addItemForm').reset();
            }

            function openAddProductModal() {
                document.getElementById('addProductModal').classList.remove('hidden');
            }

            function closeAddProductModal() {
                document.getElementById('addProductModal').classList.add('hidden');
                document.getElementById('addProductForm').reset();
            }

            function openStockModal(type, id) {
                console.log('Opening modal for', type, 'with ID', id);
                document.getElementById('stockModal').classList.remove('hidden');
                document.getElementById('stockItemType').value = type;
                
                // Fetch item details and movements
                const url = `/inventory/${id}/details?type=${type}`;
                console.log('Fetching from URL:', url);
                
                fetch(url)
                    .then(response => {
                        console.log('Response status:', response.status);
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        console.log('Full data received:', data);
                        
                        // Populate item info
                        if (data.item) {
                            console.log('Setting item name:', data.item.name);
                            console.log('Setting current stock:', data.item.current_stock, data.item.unit);
                            console.log('Setting minimum stock:', data.item.minimum_stock);
                            console.log('Setting unit cost:', data.item.unit_cost);
                            
                            document.getElementById('itemName').textContent = data.item.name || 'Item Details';
                            document.getElementById('currentStock').textContent = (data.item.current_stock !== undefined ? data.item.current_stock : 0) + ' ' + (data.item.unit || '');
                            document.getElementById('minimumStock').textContent = (data.item.minimum_stock !== undefined ? data.item.minimum_stock : 0);
                            document.getElementById('unitCost').textContent = data.item.unit_cost ? '₱' + parseFloat(data.item.unit_cost).toFixed(2) : 'N/A';
                        } else {
                            console.error('No item data in response');
                        }
                        
                        // Populate movements table
                        const tbody = document.getElementById('movementTableBody');
                        console.log('Movements data:', data.movements);
                        
                        if (data.movements && data.movements.length > 0) {
                            tbody.innerHTML = data.movements.map(movement => `
                                <tr class="hover:bg-gray-50">
                                    <td class="px-4 py-3 text-gray-900">${new Date(movement.created_at).toLocaleDateString()}</td>
                                    <td class="px-4 py-3">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${
                                            movement.movement_type === 'in' ? 'bg-green-100 text-green-800' :
                                            movement.movement_type === 'out' ? 'bg-red-100 text-red-800' :
                                            'bg-blue-100 text-blue-800'
                                        }">
                                            ${movement.movement_type.charAt(0).toUpperCase() + movement.movement_type.slice(1)}
                                        </span>
                                    </td>
                                    <td class="px-4 py-3 text-right font-medium text-gray-900">${movement.quantity}</td>
                                    <td class="px-4 py-3 text-gray-600">${movement.notes || '-'}</td>
                                </tr>
                            `).join('');
                        } else {
                            tbody.innerHTML = '<tr><td colspan="4" class="px-4 py-8 text-center text-gray-500">No movements recorded yet</td></tr>';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching item details:', error);
                        document.getElementById('movementTableBody').innerHTML = '<tr><td colspan="4" class="px-4 py-8 text-center text-red-500">Error loading data: ' + error.message + '</td></tr>';
                    });
            }

            function closeStockModal() {
                document.getElementById('stockModal').classList.add('hidden');
            }

            function deleteItem(type, id, name) {
                deleteItemData.type = type;
                deleteItemData.id = id;
                deleteItemData.name = name || (type === 'product' ? 'this product' : 'this material');
                
                document.getElementById('deleteItemName').textContent = deleteItemData.name;
                document.getElementById('deleteConfirmModal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('deleteConfirmModal').classList.add('hidden');
                deleteItemData = { type: null, id: null, name: null };
            }

            function confirmDelete() {
                if (deleteItemData.id && deleteItemData.type) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/inventory/${deleteItemData.id}/${deleteItemData.type}`;
                    
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';
                    
                    const tokenInput = document.createElement('input');
                    tokenInput.type = 'hidden';
                    tokenInput.name = '_token';
                    tokenInput.value = '{{ csrf_token() }}';
                    
                    form.appendChild(methodInput);
                    form.appendChild(tokenInput);
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            // Handle product category selection and auto-fill pricing
            document.getElementById('productCategorySelect').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const productionCost = selectedOption.getAttribute('data-production-cost');
                const sellingPrice = selectedOption.getAttribute('data-selling-price');
                
                if (productionCost) {
                    document.getElementById('productProductionCost').value = productionCost;
                }
                if (sellingPrice) {
                    document.getElementById('productSellingPrice').value = sellingPrice;
                }
            });


            // Close modals when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('fixed')) {
                    closeAddItemModal();
                    closeAddProductModal();
                    closeStockModal();
                }
            });

            // Initialize tab state on page load
            document.addEventListener('DOMContentLoaded', function() {
                showTab('materials');
                const materialsTab = document.getElementById('materials-tab');
                materialsTab.style.borderRadius = '10px';
                const productsTab = document.getElementById('products-tab');
                productsTab.style.borderRadius = '10px';
            });

        </script>
@endsection
