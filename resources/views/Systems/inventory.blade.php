@extends('layouts.system')

@section('main-content')
        <!-- Main Content -->
        <div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-4xl font-bold text-gray-900">Inventory Management</h1>
                        <p class="text-base text-gray-700 mt-2 font-medium">Track and manage raw materials and finished products</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="openStockLogsModal()" class="px-4 py-2 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition">
                            📋 Stock Logs
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
                            <p class="text-slate-100 text-sm font-semibold">Total Items</p>
                            <p class="text-3xl xl:text-4xl font-bold mt-3">{{ $totalItems ?? 10 }}</p>
                            <p class="text-slate-300 text-sm font-medium mt-2">{{ $totalItems ?? 10 }} Items</p>
                        </div>
                        @include('components.icons.package', ['class' => 'icon-package'])
                    </div>
                </div>

                <!-- Low Stock Alerts Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                    <div>
                    <p class="text-slate-100 text-sm font-semibold">Low Stock Alerts</p>
    <!--changing red when lowstocks--><p class="text-3xl xl:text-4xl font-bold text-white mt-3 {{ ($lowStockAlerts ?? 3) > 4 ? 'text-red-400' : '' }}">{{ $lowStockAlerts ?? 3 }}</p>
                    <p class="text-slate-300 text-sm font-medium mt-2 {{ ($lowStockAlerts ?? 3) > 4 ? 'text-red-300' : '' }}">{{ $lowStockAlerts ?? 3 }} Items</p>
                        </div>
                        @include('components.icons.cart', ['class' => ($lowStockAlerts ?? 3) > 4 ? 'icon-cart text-red-500' : 'icon-cart'])
                    </div>
                </div>

                <!-- Total Value Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-100 text-sm font-semibold">Total Value</p>
                            <p class="text-2xl font-bold mt-3">₱{{ number_format($totalValue ?? 343711.41, 2) }}</p>
                            <p class="text-slate-300 text-sm font-medium mt-2">Raw materials inventory value</p>
                        </div>
                      @include('components.icons.cart', ['class' => 'icon-cart']) 
                    </div>
                </div>
                

                <!-- New Order Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-100 text-sm font-semibold">New Order</p>
                            <p class="text-3xl xl:text-4xl font-bold mt-3">{{ $newOrders ?? 2 }}</p>
                            <p class="text-slate-300 text-sm font-medium mt-2">Finished products inventory value</p>
                        </div>
                    @include('components.icons.cart', ['class' => 'icon-cart'])
                    </div>
                </div>

                <!-- Pending Deliveries Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-100 text-sm font-semibold">Pending Deliveries</p>
                            <p class="text-3xl xl:text-4xl font-bold mt-3">{{ $pendingDeliveries ?? 3 }}</p>
                            <p class="text-slate-300 text-sm font-medium mt-2">Purchase orders awaiting delivery</p>
                            <p class="text-slate-300 text-sm font-medium">View auto-requests</p>
                        </div>
                         @include('components.icons.cart', ['class' => 'icon-cart'])
                    </div>
                </div>
            </div>

            <!-- Inventory Items Section -->
            <div class="bg-slate-700 rounded-lg p-6 ">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-white">Inventory Items</h2>
                        <p class="text-slate-200 text-sm font-medium mt-2">Manage raw materials from suppliers and finished products from production</p>
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

                <!-- Search + Filters -->
                @php
                    $inventoryCategories = collect($materials ?? [])->pluck('category')->filter()->unique()->values();
                @endphp
                <div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
                    <input type="search" id="searchInput" placeholder="Search items..." class="bg-white w-full md:w-3/4 rounded-full px-4 py-3 text-gray-900 text-base font-medium focus:outline-none">
                    <div class="flex gap-2">
                        <select id="categoryFilter" class="flex items-center space-x-2 px-4 py-3 bg-slate-600 text-white text-base font-medium rounded-lg hover:bg-slate-500 transition">
                            <option value="">All Categories</option>
                            @foreach($inventoryCategories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
                            <option value="Products">Products</option>
                        </select>
                    </div>
                </div>

                <!-- Tabs -->
                <div class="flex space-x-1 w-full mb-6">
                    <button onclick="showTab('materials')" id="materials-tab" class="flex-auto px-[255px] py-3 rounded-lg font-bold text-base" style="background-color: #FFF1DA; color: #111827;">Materials</button>
                    <button onclick="showTab('products')" id="products-tab" class="flex-auto px-[255px] py-3 rounded-lg border font-bold text-base" style="background-color: #374151; border: 1px solid #FFFFFF; color: #FFFFFF;">Products</button>
                </div>

                <!-- Materials Table -->
                <div id="materials-table" class="space-y-3 overflow-y-auto" style="max-height:60vh;">
                    @forelse($materials ?? [] as $material)
                    <div class="p-4 border border-slate-600 rounded-lg hover:bg-slate-600 hover:border-slate-500 transition" data-name="{{ $material->name }}" data-category="{{ $material->category }}">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-bold text-white text-base">{{ $material->name }}</h3>
                                <p class="text-base text-slate-300 font-medium">{{ $material->supplier->name ?? 'N/A' }} • {{ $material->unit }}</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                @if($material->isLowStock())
                                    <span class="px-3 py-2 bg-red-500 text-white text-sm font-bold rounded-full">Low Stock</span>
                                @else
                                    <span class="px-3 py-2 bg-green-500 text-white text-sm font-bold rounded-full">In Stock</span>
                                @endif
                                <span class="text-white font-bold text-base">₱{{ number_format($material->unit_cost, 2) }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-3 gap-4 mt-3 text-base">
                            <div>
                                <span class="text-slate-300 font-medium">Current Stock</span>
                                <p class="text-white font-bold text-base">{{ $material->current_stock }} {{ $material->unit }}</p>
                            </div>
                            <div>
                                <span class="text-slate-300 font-medium">Min Stock</span>
                                <p class="text-white font-bold text-base">{{ $material->minimum_stock }} {{ $material->unit }}</p>
                            </div>
                            <div class="flex items-center space-x-2 justify-end">
                                <button onclick="event.stopPropagation(); openStockModal('material', {{ $material->id }})" class="p-2 hover:bg-slate-500 rounded flex items-center space-x-2" title="View Items">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                        <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                    </svg>
                                    <span class="text-sm font-bold text-white">View</span>
                                </button>
                                <button onclick="event.stopPropagation(); deleteItem('material', {{ $material->id }})" class="p-2 hover:bg-slate-500 rounded" title="Delete">
                                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="py-8 px-4 text-center text-slate-300 text-base font-medium">
                        <p>No materials found</p>
                    </div>
                    @endforelse
                </div>

                <!-- Products Table -->
                <div id="products-table" class="space-y-3 overflow-y-auto hidden" style="max-height:60vh;">
                    @forelse($products ?? [] as $product)
                    <div class="p-4 border border-slate-600 rounded-lg hover:bg-slate-600 hover:border-slate-500 transition" data-name="{{ $product->product_name }}" data-category="Products">
                        <div class="flex justify-between items-start">
                            <div class="flex-1">
                                <h3 class="font-bold text-white text-base">{{ $product->product_name }}</h3>
                                <p class="text-base text-slate-300 font-medium">Finished Product</p>
                            </div>
                            <div class="flex items-center space-x-3">
                                <span class="text-white font-bold text-base">₱{{ number_format($product->selling_price, 2) }}</span>
                            </div>
                        </div>
                        <div class="grid grid-cols-2 gap-4 mt-3 text-base">
                            <div>
                                <span class="text-slate-300 font-medium">Production Cost</span>
                                <p class="text-white font-bold text-base">₱{{ number_format($product->production_cost, 2) }}</p>
                            </div>
                            <div>
                                <span class="text-slate-300 font-medium">Selling Price</span>
                                <p class="text-white font-bold text-base">₱{{ number_format($product->selling_price, 2) }}</p>
                            </div>
                        </div>

                        <!-- Materials Needed Section -->
                        @if($product->materials->count() > 0)
                        <div class="mt-3 pt-3 border-t border-slate-500">
                            <span class="text-slate-400 text-xs font-semibold uppercase">Materials Needed:</span>
                            <div class="mt-2 space-y-1">
                                @foreach($product->materials as $material)
                                <div class="text-sm text-slate-300 flex justify-between">
                                    <span>• {{ $material->name }}</span>
                                    <span class="font-medium text-white">{{ $material->pivot->quantity_needed }} {{ $material->unit }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        <div class="flex items-center space-x-2 mt-3 justify-end">
                            <button onclick="event.stopPropagation(); openEditProductModal({{ $product->id }})" class="p-1 hover:bg-slate-500 rounded" title="Edit">
                                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </button>
                            <button onclick="event.stopPropagation(); deleteItem('product', {{ $product->id }})" class="p-1 hover:bg-slate-500 rounded" title="Delete">
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
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-3xl font-bold text-gray-900">Add New Material</h3>
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
                                    <label class="block text-base font-bold text-gray-900 mb-3">Material Name *</label>
                                    <input type="text" name="name" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                </div>
                                
                                <div>
                                    <label class="block text-base font-bold text-gray-900 mb-3">Category *</label>
                                    <select name="category" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                        <option value="">Select Category</option>
                                        <option value="lumber">Lumber</option>
                                        <option value="hardware">Hardware</option>
                                        <option value="finishing">Finishing</option>
                                        <option value="tools">Tools</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-base font-bold text-gray-900 mb-3">Unit *</label>
                                    <input type="text" name="unit" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                </div>
                                
                                <div>
                                    <label class="block text-base font-bold text-gray-900 mb-3">Current Stock *</label>
                                    <input type="number" name="current_stock" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                </div>
                                
                                <div>
                                    <label class="block text-base font-bold text-gray-900 mb-3">Minimum Stock *</label>
                                    <input type="number" name="minimum_stock" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                </div>
                                
                                <div>
                                    <label class="block text-base font-bold text-gray-900 mb-3">Unit Cost *</label>
                                    <input type="number" name="unit_cost" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                </div>
                                
                                <div>
                                    <label class="block text-base font-bold text-gray-900 mb-3">Supplier *</label>
                                    <select name="supplier_id" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                        <option value="">Select Supplier</option>
                                        @foreach($suppliers ?? [] as $supplier)
                                            <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-base font-bold text-gray-900 mb-3">Description</label>
                                    <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base"></textarea>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" onclick="closeAddItemModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-bold text-base hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold text-base rounded-lg hover:bg-blue-700">
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
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-3xl font-bold text-gray-900">Add New Product</h3>
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
                                    <label class="block text-base font-bold text-gray-900 mb-3">Product Name *</label>
                                    <input type="text" name="product_name" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                </div>
                                <div>
                                    <label class="block text-base font-bold text-gray-900 mb-3">Unit *</label>
                                    <input type="text" name="unit" value="pieces" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                    <input type="text" name="category" value="Products" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-base font-bold text-gray-900 mb-3">Production Cost *</label>
                                    <input type="number" name="production_cost" id="productProductionCost" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                </div>
                                
                                <div>
                                    <label class="block text-base font-bold text-gray-900 mb-3">Selling Price *</label>
                                    <input type="number" name="selling_price" id="productSellingPrice" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-4 py-3 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-base" required>
                                </div>
                            </div>

                            <!-- Materials Section -->
                            <div class="mt-6 pt-6 border-t border-gray-300">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-lg font-bold text-gray-900">Materials Needed</h4>
                                    <button type="button" onclick="addMaterialRow()" class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700 font-bold">
                                        + Add Material
                                    </button>
                                </div>
                                
                                <div id="materialsContainer" class="space-y-3">
                                    <!-- Material rows will be added here -->
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" onclick="closeAddProductModal()" class="px-6 py-3 border border-gray-300 rounded-lg text-gray-700 font-bold text-base hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" class="px-6 py-3 bg-blue-600 text-white font-bold text-base rounded-lg hover:bg-blue-700">
                                    Add Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Product Modal -->
        <div id="editProductModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900">Edit Product</h3>
                            <button onclick="closeEditProductModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <form id="editProductForm" method="POST" action="">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="type" value="product">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                                    <input type="text" id="editProductName" name="product_name" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                                    <input type="text" id="editProductUnit" name="unit" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                    <input type="text" id="editProductCategory" name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Production Cost *</label>
                                    <input type="number" id="editProductProductionCost" name="production_cost" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Selling Price *</label>
                                    <input type="number" id="editProductSellingPrice" name="selling_price" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                            </div>

                            <!-- Materials Section -->
                            <div class="mt-6 pt-6 border-t border-gray-200">
                                <div class="flex justify-between items-center mb-4">
                                    <h4 class="text-lg font-semibold text-gray-900">Materials Needed</h4>
                                    <button type="button" onclick="addEditMaterialRow()" class="px-3 py-1 bg-green-600 text-white text-sm rounded-lg hover:bg-green-700">
                                        + Add Material
                                    </button>
                                </div>
                                
                                <div id="editMaterialsContainer" class="space-y-3">
                                    <!-- Material rows will be added here -->
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" onclick="closeEditProductModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Update Product
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock View Modal -->
        <!-- Stock View Modal -->
        <div id="stockModal" class="modal-overlay fixed inset-0 bg-black/60 backdrop-blur-sm hidden overflow-y-auto flex items-center justify-center z-50" onclick="if(event.target === this) closeStockModal()">
            <div class="modal-content bg-amber-50 rounded-2xl max-w-4xl w-[92%] my-8 shadow-2xl transform transition-all" onclick="event.stopPropagation()">
                <div class="p-8">
                    <!-- Header -->
                    <div class="flex justify-between items-start mb-8 border-b-2 pb-6" style="border-color: #374151;">
                        <div>
                            <h3 class="text-3xl font-bold" style="color: #374151;">Item Details & Movement History</h3>
                            <p id="itemName" class="text-base mt-2 font-medium" style="color: #666;"></p>
                        </div>
                        <button onclick="closeStockModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-full p-2 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Item Info Cards -->
                    <div class="grid grid-cols-3 gap-4 mb-8">
                        <div class="p-6 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
                            <p class="text-base font-semibold" style="color: #374151;">Current Stock</p>
                            <p id="currentStock" class="text-3xl font-bold mt-3" style="color: #374151;">-</p>
                        </div>
                        <div class="p-6 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #F57C00;">
                            <p class="text-base font-semibold" style="color: #E65100;">Minimum Stock</p>
                            <p id="minimumStock" class="text-3xl font-bold mt-3" style="color: #E65100;">-</p>
                        </div>
                        <div class="p-6 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #388E3C;">
                            <p class="text-base font-semibold" style="color: #2E7D32;">Unit Cost</p>
                            <p id="unitCost" class="text-3xl font-bold mt-3" style="color: #2E7D32;">-</p>
                        </div>
                    </div>

                    <!-- Inventory Movements Table -->
                    <div class="mb-8">
                        <h4 class="text-2xl font-bold mb-4 flex items-center" style="color: #374151;">
                            <span class="w-1 h-6 rounded mr-3" style="background-color: #374151;"></span>
                            Movement History
                        </h4>
                        <div class="overflow-x-auto rounded-lg" style="border: 1px solid #374151;">
                            <table class="w-full text-base">
                                <thead style="background-color: #374151;" class="text-white">
                                    <tr>
                                        <th class="px-6 py-4 text-left font-bold">Date</th>
                                        <th class="px-6 py-4 text-left font-bold">Type</th>
                                        <th class="px-6 py-4 text-right font-bold">Quantity</th>
                                        <th class="px-6 py-4 text-left font-bold">Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="movementTableBody" class="divide-y" style="border-color: #374151;">
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center font-medium" style="color: #666;">
                                            Loading movements...
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Close Button -->
                    <div class="flex justify-end pt-4">
                        <button type="button" onclick="closeStockModal()" class="px-6 py-3 rounded-lg hover:shadow-lg transition-all duration-200 text-base font-medium text-white" style="background-color: #374151;">
                            Close
                        </button>
                    </div>
                </div>
            </div>
        </div>
        </div>
        

        <script>
            // Initialize search and filter listeners on page load
            document.addEventListener('DOMContentLoaded', function() {
                const searchInput = document.getElementById('searchInput');
                const categoryFilter = document.getElementById('categoryFilter');
                
                if (searchInput) {
                    searchInput.addEventListener('keyup', applyInventoryFilters);
                    searchInput.addEventListener('change', applyInventoryFilters);
                }
                
                if (categoryFilter) {
                    categoryFilter.addEventListener('change', applyInventoryFilters);
                }
            });

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

                // Save active tab to localStorage
                localStorage.setItem('activeInventoryTab', tab);
                applyInventoryFilters();
            }

            // Restore active tab on page load
            window.addEventListener('DOMContentLoaded', function() {
                const activeTab = localStorage.getItem('activeInventoryTab') || 'products';
                showTab(activeTab);
            });

            function applyInventoryFilters() {
                const searchValue = (document.getElementById('searchInput')?.value || '').toLowerCase();
                const categoryValue = document.getElementById('categoryFilter')?.value || '';

                const materialsTable = document.getElementById('materials-table');
                const productsTable = document.getElementById('products-table');

                const cards = [];
                if (materialsTable && !materialsTable.classList.contains('hidden')) {
                    cards.push(...materialsTable.querySelectorAll('[data-name]'));
                }
                if (productsTable && !productsTable.classList.contains('hidden')) {
                    cards.push(...productsTable.querySelectorAll('[data-name]'));
                }

                cards.forEach(card => {
                    const name = (card.getAttribute('data-name') || '').toLowerCase();
                    const category = card.getAttribute('data-category') || '';

                    const matchesSearch = !searchValue || name.includes(searchValue);
                    const matchesCategory = !categoryValue || category === categoryValue;

                    card.style.display = (matchesSearch && matchesCategory) ? '' : 'none';
                });
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
                document.getElementById('materialsContainer').innerHTML = ''; // Clear materials on modal open
            }

            function closeAddProductModal() {
                document.getElementById('addProductModal').classList.add('hidden');
                document.getElementById('addProductForm').reset();
                document.getElementById('materialsContainer').innerHTML = '';
            }

            // Material row counter
            let materialRowCount = 0;

            function addMaterialRow() {
                const materialsContainer = document.getElementById('materialsContainer');
                const rowId = 'material-row-' + materialRowCount++;
                
                const row = document.createElement('div');
                row.id = rowId;
                row.className = 'flex gap-3 items-end bg-gray-50 p-3 rounded-lg';
                
                row.innerHTML = `
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Material *</label>
                        <select name="materials[${materialRowCount-1}][material_id]" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Select a material...</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}">{{ $material->name }} ({{ $material->unit }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity Needed *</label>
                        <input type="number" name="materials[${materialRowCount-1}][quantity_needed]" step="0.01" min="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                    <button type="button" onclick="removeMaterialRow('${rowId}')" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Remove
                    </button>
                `;
                
                materialsContainer.appendChild(row);
            }

            function removeMaterialRow(rowId) {
                const row = document.getElementById(rowId);
                if (row) {
                    row.remove();
                }
            }

            // Edit material row counter
            let editMaterialRowCount = 0;

            function openEditProductModal(productId) {
                fetch(`/inventory/${productId}/edit-product`)
                    .then(response => response.json())
                    .then(data => {
                        document.getElementById('editProductName').value = data.product_name;
                        document.getElementById('editProductUnit').value = data.unit;
                        document.getElementById('editProductCategory').value = data.category;
                        document.getElementById('editProductProductionCost').value = data.production_cost;
                        document.getElementById('editProductSellingPrice').value = data.selling_price;
                        
                        // Set form action
                        document.getElementById('editProductForm').action = `/inventory/${productId}`;
                        
                        // Clear and populate materials
                        document.getElementById('editMaterialsContainer').innerHTML = '';
                        editMaterialRowCount = 0;
                        
                        if (data.materials && data.materials.length > 0) {
                            data.materials.forEach(material => {
                                addEditMaterialRow(material.id, material.name, material.unit, material.pivot.quantity_needed);
                            });
                        }
                        
                        document.getElementById('editProductModal').classList.remove('hidden');
                    })
                    .catch(error => {
                        console.error('Error loading product:', error);
                        alert('Error loading product details');
                    });
            }

            function closeEditProductModal() {
                document.getElementById('editProductModal').classList.add('hidden');
                document.getElementById('editProductForm').reset();
                document.getElementById('editMaterialsContainer').innerHTML = '';
            }

            function addEditMaterialRow(materialId = null, materialName = null, materialUnit = null, quantityNeeded = null) {
                const materialsContainer = document.getElementById('editMaterialsContainer');
                const rowId = 'edit-material-row-' + editMaterialRowCount++;
                
                const row = document.createElement('div');
                row.id = rowId;
                row.className = 'flex gap-3 items-end bg-gray-50 p-3 rounded-lg';
                
                row.innerHTML = `
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Material *</label>
                        <select name="materials[${editMaterialRowCount-1}][material_id]" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                            <option value="">Select a material...</option>
                            @foreach($materials as $material)
                                <option value="{{ $material->id }}" ${materialId == {{ $material->id }} ? 'selected' : ''}>{{ $material->name }} ({{ $material->unit }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex-1">
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity Needed *</label>
                        <input type="number" name="materials[${editMaterialRowCount-1}][quantity_needed]" step="0.01" min="0.01" value="${quantityNeeded || ''}" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                    </div>
                    <button type="button" onclick="removeEditMaterialRow('${rowId}')" class="px-3 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Remove
                    </button>
                `;
                
                materialsContainer.appendChild(row);
            }

            function removeEditMaterialRow(rowId) {
                const row = document.getElementById(rowId);
                if (row) {
                    row.remove();
                }
            }

            // Ensure products tab stays active after adding product
            document.getElementById('addProductForm')?.addEventListener('submit', function() {
                localStorage.setItem('activeInventoryTab', 'products');
            });

            // Ensure products tab stays active after editing product
            document.getElementById('editProductForm')?.addEventListener('submit', function() {
                localStorage.setItem('activeInventoryTab', 'products');
            });

            function openStockModal(type, id) {
                document.getElementById('stockModal').classList.remove('hidden');
                
                // Fetch item details and movements
                fetch(`/inventory/${id}/details?type=${type}`)
                    .then(response => response.json())
                    .then(data => {
                        // Populate item info
                        document.getElementById('itemName').textContent = data.item.name || data.item.product_name || 'Item';
                        document.getElementById('currentStock').textContent = data.item.current_stock + ' ' + (data.item.unit || '');
                        document.getElementById('minimumStock').textContent = data.item.minimum_stock || '-';
                        document.getElementById('unitCost').textContent = data.item.unit_cost ? '₱' + parseFloat(data.item.unit_cost).toFixed(2) : 'N/A';
                        
                        // Populate movements table
                        const tbody = document.getElementById('movementTableBody');
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
                        document.getElementById('movementTableBody').innerHTML = '<tr><td colspan="4" class="px-4 py-8 text-center text-red-500">Error loading data</td></tr>';
                    });
            }

            function closeStockModal() {
                document.getElementById('stockModal').classList.add('hidden');
            }

            function deleteItem(type, id) {
                if (confirm('Are you sure you want to delete this item?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/inventory/${id}/${type}`;
                    
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

                const searchInput = document.getElementById('searchInput');
                const categoryFilter = document.getElementById('categoryFilter');
                if (searchInput) {
                    searchInput.addEventListener('input', applyInventoryFilters);
                }
                if (categoryFilter) {
                    categoryFilter.addEventListener('change', applyInventoryFilters);
                }
            });

            // Stock Logs Modal Functions
            function openStockLogsModal() {
                document.getElementById('stockLogsModal').classList.remove('hidden');
                loadStockLogs();
            }

            function closeStockLogsModal() {
                document.getElementById('stockLogsModal').classList.add('hidden');
            }

            function loadStockLogs() {
                const movementType = document.getElementById('logMovementTypeFilter')?.value || '';
                const dateFrom = document.getElementById('logDateFromFilter')?.value || '';
                const dateTo = document.getElementById('logDateToFilter')?.value || '';

                const params = new URLSearchParams();
                if (movementType) params.append('movement_type', movementType);
                if (dateFrom) params.append('date_from', dateFrom);
                if (dateTo) params.append('date_to', dateTo);

                fetch(`{{ route('inventory.stock-movements-report') }}?${params.toString()}`)
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            displayStockLogs(data.movements, data.summary);
                        }
                    })
                    .catch(err => console.error('Error loading logs:', err));
            }

            function displayStockLogs(movements, summary) {
                const tableBody = document.getElementById('stockLogsTable');

                if (movements.length === 0) {
                    tableBody.innerHTML = '<tr><td colspan="6" class="px-4 py-6 text-center text-gray-500">No stock movements found</td></tr>';
                    return;
                }

                let htmlRows = '';
                movements.forEach((movement) => {
                    const typeColor = movement.movement_type === 'in' ? 'text-green-600 bg-green-50' : 
                                     movement.movement_type === 'out' ? 'text-red-600 bg-red-50' : 'text-yellow-600 bg-yellow-50';

                    const row = `
                        <tr class="${typeColor}">
                            <td class="px-4 py-3">${movement.date} ${movement.time}</td>
                            <td class="px-4 py-3 font-bold">${movement.movement_label}</td>
                            <td class="px-4 py-3">${movement.item_name}</td>
                            <td class="px-4 py-3 text-center font-bold">${movement.movement_type === 'out' ? '-' : '+'}${movement.quantity.toFixed(2)} ${movement.unit}</td>
                            <td class="px-4 py-3">${movement.reference_info}</td>
                            <td class="px-4 py-3 text-xs max-w-xs truncate" title="${movement.notes || '-'}">${movement.notes || '-'}</td>
                        </tr>
                    `;
                    htmlRows += row;
                });

                tableBody.innerHTML = htmlRows;

                // Update summary
                document.getElementById('logTotalIn').textContent = summary.total_in.toFixed(2);
                document.getElementById('logTotalOut').textContent = summary.total_out.toFixed(2);
                document.getElementById('logTotalMovements').textContent = summary.total_movements;
            }
        </script>

        <!-- Stock Logs Modal -->
        <div id="stockLogsModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-6xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="sticky top-0 bg-gradient-to-r from-slate-700 to-slate-800 p-6 text-white">
                        <div class="flex justify-between items-center">
                            <div>
                                <h3 class="text-2xl font-bold">📋 Stock Logs</h3>
                                <p class="text-slate-300 text-sm mt-1">Complete audit trail of all inventory movements</p>
                            </div>
                            <button onclick="closeStockLogsModal()" class="text-white hover:text-slate-300">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </div>

                    <div class="p-6">
                        <!-- Filters -->
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">Type</label>
                                <select id="logMovementTypeFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-slate-500" onchange="loadStockLogs()">
                                    <option value="">All</option>
                                    <option value="in">📦 Stock In</option>
                                    <option value="out">📤 Stock Out</option>
                                    <option value="adjustment">⚙️ Adjustment</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">From Date</label>
                                <input type="date" id="logDateFromFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-slate-500" onchange="loadStockLogs()">
                            </div>
                            <div>
                                <label class="block text-sm font-bold text-gray-900 mb-2">To Date</label>
                                <input type="date" id="logDateToFilter" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-slate-500" onchange="loadStockLogs()">
                            </div>
                        </div>

                        <!-- Summary -->
                        <div class="grid grid-cols-3 gap-4 mb-6">
                            <div class="bg-green-50 border border-green-200 rounded-lg p-4">
                                <p class="text-green-600 text-sm font-medium">Total In</p>
                                <p id="logTotalIn" class="text-2xl font-bold text-green-700">0</p>
                            </div>
                            <div class="bg-red-50 border border-red-200 rounded-lg p-4">
                                <p class="text-red-600 text-sm font-medium">Total Out</p>
                                <p id="logTotalOut" class="text-2xl font-bold text-red-700">0</p>
                            </div>
                            <div class="bg-slate-50 border border-slate-200 rounded-lg p-4">
                                <p class="text-slate-600 text-sm font-medium">Total Logs</p>
                                <p id="logTotalMovements" class="text-2xl font-bold text-slate-700">0</p>
                            </div>
                        </div>

                        <!-- Table -->
                        <div class="overflow-x-auto">
                            <table class="w-full text-sm">
                                <thead class="bg-gray-100">
                                    <tr>
                                        <th class="px-4 py-3 text-left font-bold text-gray-900">Date & Time</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-900">Type</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-900">Item</th>
                                        <th class="px-4 py-3 text-center font-bold text-gray-900">Quantity</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-900">Reference</th>
                                        <th class="px-4 py-3 text-left font-bold text-gray-900">Notes</th>
                                    </tr>
                                </thead>
                                <tbody id="stockLogsTable" class="divide-y divide-gray-200">
                                    <tr>
                                        <td colspan="6" class="px-4 py-6 text-center text-gray-500">Loading logs...</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
