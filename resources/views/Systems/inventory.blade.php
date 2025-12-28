@extends('layouts.system')

@section('main-content')
        <!-- Main Content -->
        <div class="flex-1 p-8 bg-amber-50">
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
                    <svg color="red" width="38" height="38" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
<!-- Total Items SVG--> <path d="M24.75 8.33336C24.7609 8.2608 24.7609 8.18718 24.75 8.11461V8.03128C24.7307 7.97314 24.7042 7.91722 24.6713 7.86461C24.6566 7.83461 24.6377 7.80658 24.615 7.78128L24.5025 7.64586L24.2775 7.48961L14.1525 2.28128C13.9815 2.18986 13.7875 2.14172 13.59 2.14172C13.3925 2.14172 13.1985 2.18986 13.0275 2.28128L2.9025 7.48961L2.80125 7.56253L2.6775 7.64586C2.64482 7.67992 2.61823 7.71861 2.59875 7.76045C2.56276 7.79034 2.53235 7.82554 2.50875 7.86461C2.47954 7.91032 2.45685 7.95934 2.44125 8.01045C2.43496 8.04492 2.43496 8.08014 2.44125 8.11461C2.3639 8.17637 2.29913 8.25046 2.25 8.33336V16.6667C2.25146 16.8523 2.30646 17.0342 2.40931 17.1935C2.51216 17.3529 2.65913 17.4839 2.835 17.5729L12.96 22.7813C13.0065 22.8064 13.0555 22.8273 13.1062 22.8438H13.2188C13.4036 22.8853 13.5964 22.8853 13.7812 22.8438H13.8938L14.0512 22.7813L24.1762 17.5729C24.35 17.4825 24.4947 17.3509 24.5955 17.1917C24.6964 17.0325 24.7497 16.8513 24.75 16.6667V8.33336ZM13.5 12.3646L5.6925 8.33336L8.7975 6.75003L16.4812 10.8125L13.5 12.3646ZM13.5 4.32295L21.3075 8.33336L18.7875 9.63545L11.1037 5.56253L13.5 4.32295ZM4.5 10.1042L12.375 14.1875V20.1042L4.5 16.0521V10.1042ZM14.625 20.1042V14.1875L18 12.4375V15.625L20.25 14.5834V11.2709L22.5 10.1146V16.0521L14.625 20.1042Z" fill="white"/>
                        </svg>
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
                 
                       <svg width="38" height="38" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24.5498 7.74063C24.4463 7.60216 24.3081 7.48899 24.147 7.41079C23.986 7.3326 23.8069 7.29173 23.625 7.29167H8.24963L6.95138 4.40625C6.78115 4.02628 6.4929 3.70166 6.12318 3.47356C5.75345 3.24546 5.3189 3.12414 4.87463 3.125H2.25V5.20834H4.87463L10.2116 17.0677C10.2971 17.2575 10.4413 17.4195 10.6261 17.5335C10.8109 17.6475 11.028 17.7084 11.25 17.7083H20.25C20.7191 17.7083 21.1388 17.4385 21.3041 17.0333L24.6791 8.7C24.7429 8.54232 24.7645 8.37266 24.7419 8.20558C24.7194 8.03849 24.6535 7.87895 24.5498 7.74063ZM19.4704 15.625H12.0004L9.18787 9.375H22.0016L19.4704 15.625Z" fill="white"/>
                            <path d="M11.8125 21.875C12.7445 21.875 13.5 21.1754 13.5 20.3125C13.5 19.4496 12.7445 18.75 11.8125 18.75C10.8805 18.75 10.125 19.4496 10.125 20.3125C10.125 21.1754 10.8805 21.875 11.8125 21.875Z" fill="white"/>
                            <path d="M19.6875 21.875C20.6195 21.875 21.375 21.1754 21.375 20.3125C21.375 19.4496 20.6195 18.75 19.6875 18.75C18.7555 18.75 18 19.4496 18 20.3125C18 21.1754 18.7555 21.875 19.6875 21.875Z" fill="white"/>
                        </svg>
                    </div>
                </div>

                <!-- Total Value Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">Total Value</p>
                            <p class="text-3xl  font-bold mt-2">₱{{ number_format($totalValue ?? 343711.41, 2) }}</p>
                            <p class="text-slate-400 text-xs mt-1">Raw materials inventory value</p>
                        </div>
                        <svg width="38" height="38" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24.5498 7.74063C24.4463 7.60216 24.3081 7.48899 24.147 7.41079C23.986 7.3326 23.8069 7.29173 23.625 7.29167H8.24963L6.95138 4.40625C6.78115 4.02628 6.4929 3.70166 6.12318 3.47356C5.75345 3.24546 5.3189 3.12414 4.87463 3.125H2.25V5.20834H4.87463L10.2116 17.0677C10.2971 17.2575 10.4413 17.4195 10.6261 17.5335C10.8109 17.6475 11.028 17.7084 11.25 17.7083H20.25C20.7191 17.7083 21.1388 17.4385 21.3041 17.0333L24.6791 8.7C24.7429 8.54232 24.7645 8.37266 24.7419 8.20558C24.7194 8.03849 24.6535 7.87895 24.5498 7.74063ZM19.4704 15.625H12.0004L9.18787 9.375H22.0016L19.4704 15.625Z" fill="white"/>
                            <path d="M11.8125 21.875C12.7445 21.875 13.5 21.1754 13.5 20.3125C13.5 19.4496 12.7445 18.75 11.8125 18.75C10.8805 18.75 10.125 19.4496 10.125 20.3125C10.125 21.1754 10.8805 21.875 11.8125 21.875Z" fill="white"/>
                            <path d="M19.6875 21.875C20.6195 21.875 21.375 21.1754 21.375 20.3125C21.375 19.4496 20.6195 18.75 19.6875 18.75C18.7555 18.75 18 19.4496 18 20.3125C18 21.1754 18.7555 21.875 19.6875 21.875Z" fill="white"/>
                        </svg>
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
                      <svg width="38" height="38" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24.5498 7.74063C24.4463 7.60216 24.3081 7.48899 24.147 7.41079C23.986 7.3326 23.8069 7.29173 23.625 7.29167H8.24963L6.95138 4.40625C6.78115 4.02628 6.4929 3.70166 6.12318 3.47356C5.75345 3.24546 5.3189 3.12414 4.87463 3.125H2.25V5.20834H4.87463L10.2116 17.0677C10.2971 17.2575 10.4413 17.4195 10.6261 17.5335C10.8109 17.6475 11.028 17.7084 11.25 17.7083H20.25C20.7191 17.7083 21.1388 17.4385 21.3041 17.0333L24.6791 8.7C24.7429 8.54232 24.7645 8.37266 24.7419 8.20558C24.7194 8.03849 24.6535 7.87895 24.5498 7.74063ZM19.4704 15.625H12.0004L9.18787 9.375H22.0016L19.4704 15.625Z" fill="white"/>
                            <path d="M11.8125 21.875C12.7445 21.875 13.5 21.1754 13.5 20.3125C13.5 19.4496 12.7445 18.75 11.8125 18.75C10.8805 18.75 10.125 19.4496 10.125 20.3125C10.125 21.1754 10.8805 21.875 11.8125 21.875Z" fill="white"/>
                            <path d="M19.6875 21.875C20.6195 21.875 21.375 21.1754 21.375 20.3125C21.375 19.4496 20.6195 18.75 19.6875 18.75C18.7555 18.75 18 19.4496 18 20.3125C18 21.1754 18.7555 21.875 19.6875 21.875Z" fill="white"/>
                        </svg>
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
                        <svg width="38" height="38" viewBox="0 0 27 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M24.5498 7.74063C24.4463 7.60216 24.3081 7.48899 24.147 7.41079C23.986 7.3326 23.8069 7.29173 23.625 7.29167H8.24963L6.95138 4.40625C6.78115 4.02628 6.4929 3.70166 6.12318 3.47356C5.75345 3.24546 5.3189 3.12414 4.87463 3.125H2.25V5.20834H4.87463L10.2116 17.0677C10.2971 17.2575 10.4413 17.4195 10.6261 17.5335C10.8109 17.6475 11.028 17.7084 11.25 17.7083H20.25C20.7191 17.7083 21.1388 17.4385 21.3041 17.0333L24.6791 8.7C24.7429 8.54232 24.7645 8.37266 24.7419 8.20558C24.7194 8.03849 24.6535 7.87895 24.5498 7.74063ZM19.4704 15.625H12.0004L9.18787 9.375H22.0016L19.4704 15.625Z" fill="white"/>
                            <path d="M11.8125 21.875C12.7445 21.875 13.5 21.1754 13.5 20.3125C13.5 19.4496 12.7445 18.75 11.8125 18.75C10.8805 18.75 10.125 19.4496 10.125 20.3125C10.125 21.1754 10.8805 21.875 11.8125 21.875Z" fill="white"/>
                            <path d="M19.6875 21.875C20.6195 21.875 21.375 21.1754 21.375 20.3125C21.375 19.4496 20.6195 18.75 19.6875 18.75C18.7555 18.75 18 19.4496 18 20.3125C18 21.1754 18.7555 21.875 19.6875 21.875Z" fill="white"/>
                        </svg>
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
                        <button onclick="openAddItemModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>Add Item</span>
                        </button>
                    </div>
                    <div id="productsButton" class="flex space-x-3 hidden">
                        <button onclick="openAddProductModal()" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition flex items-center space-x-2">
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
                    </table>x`
                </div>

                <!-- Products Table -->
                <div id="products-table" class="overflow-x-auto hidden">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-slate-600">
                                <th class="text-left py-3 px-4 font-medium">Name</th>
                                <th class="text-left py-3 px-4 font-medium">Category</th>
                                <th class="text-left py-3 px-4 font-medium">Production Cost</th>
                                <th class="text-left py-3 px-4 font-medium">Selling Price</th>
                                <th class="text-left py-3 px-4 font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-600">
                            @forelse($products ?? [] as $product)
                            <tr class="hover:bg-slate-600 cursor-pointer" onclick="openEditModal('product', {{ $product->id }})">
                                <td class="py-3 px-4">{{ $product->product_name }}</td>
                                <td class="py-3 px-4">{{ ucfirst($product->category) }}</td>
                                <td class="py-3 px-4">₱{{ number_format($product->production_cost, 2) }}</td>
                                <td class="py-3 px-4">₱{{ number_format($product->selling_price, 2) }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <button onclick="event.stopPropagation(); openEditModal('product', {{ $product->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        <button onclick="event.stopPropagation(); deleteItem('product', {{ $product->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="py-8 px-4 text-center text-slate-400">No products found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
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
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                    <select name="category" id="productCategorySelect" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        <option value="">Select Category</option>
                                        <option value="chairs" data-production-cost="3000" data-selling-price="8000">Chairs</option>
                                        <option value="tables" data-production-cost="4000" data-selling-price="9000">Tables</option>
                                        <option value="cabinets" data-production-cost="7000" data-selling-price="14000">Cabinets</option>
                                        <option value="storage" data-production-cost="2000" data-selling-price="7000">Storage</option>
                                    </select>
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

        <!-- Edit Item Modal -->
        <div id="editItemModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900">Edit Item</h3>
                            <button onclick="closeEditModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <form id="editItemForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Product Name *</label>
                                    <input type="text" name="product_name" id="editProductName" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Category *</label>
                                    <select name="category" id="editCategory" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        <option value="">Select Category</option>
                                        <option value="chairs">Chairs</option>
                                        <option value="tables">Tables</option>
                                        <option value="cabinets">Cabinets</option>
                                        <option value="storage">Storage</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Unit *</label>
                                    <input type="text" name="unit" id="editUnit" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Production Cost *</label>
                                    <input type="number" name="production_cost" id="editProductionCost" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Selling Price *</label>
                                    <input type="number" name="selling_price" id="editSellingPrice" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <textarea name="description" id="editDescription" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" onclick="closeEditModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Update Item
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stock Adjustment Modal -->
        <div id="stockModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-white rounded-lg max-w-md w-full">
                    <div class="p-6">
                        <div class="flex justify-between items-center mb-4">
                            <h3 class="text-xl font-bold text-gray-900">Adjust Stock</h3>
                            <button onclick="closeStockModal()" class="text-gray-400 hover:text-gray-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        
                        <form id="stockForm" method="POST">
                            @csrf
                            <input type="hidden" name="type" id="stockItemType">
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Movement Type *</label>
                                    <select name="movement_type" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                        <option value="">Select Movement Type</option>
                                        <option value="in">Stock In</option>
                                        <option value="out">Stock Out</option>
                                        <option value="adjustment">Adjustment</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Quantity *</label>
                                    <input type="number" name="quantity" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" required>
                                </div>
                                
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 mb-2">Notes</label>
                                    <textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent"></textarea>
                                </div>
                            </div>
                            
                            <div class="flex justify-end space-x-3 mt-6">
                                <button type="button" onclick="closeStockModal()" class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                                    Cancel
                                </button>
                                <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700">
                                    Adjust Stock
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

            function openEditModal(type, id) {
                // This would typically fetch item data via AJAX
                document.getElementById('editItemModal').classList.remove('hidden');
                document.getElementById('editItemForm').action = `/inventory/${id}`;
            }

            function closeEditModal() {
                document.getElementById('editItemModal').classList.add('hidden');
            }

            function openStockModal(type, id) {
                document.getElementById('stockModal').classList.remove('hidden');
                document.getElementById('stockForm').action = `/inventory/${id}/adjust-stock`;
                document.getElementById('stockItemType').value = type;
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
                    closeEditModal();
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
