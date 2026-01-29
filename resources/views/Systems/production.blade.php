@extends('layouts.system')

@section('main-content')
        <!-- Main Content -->
        <div class="flex-1 p-8 bg-amber-50">
            <!-- Header Section -->
            <div class="mb-8">
                @if(session('success'))
                    <div class="mb-4 p-4 bg-green-100 border border-green-400 text-green-800 rounded-lg">{{ session('success') }}</div>
                @endif
                @if(session('error'))
                    <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-800 rounded-lg">{{ session('error') }}</div>
                @endif
                <div class="flex justify-between items-start">
                    <div>
                        <h1 class="text-3xl font-bold text-gray-900">Production Management</h1>
                        <p class="text-gray-600 mt-2">Plan, track, and manage furniture production workflow</p>
                    </div>
                </div>
            </div>

            <!-- Status Overview Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Pending Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">Pending</p>
                            <p class="text-3xl font-bold mt-2">{{ $statusCounts['pending'] ?? 0 }}</p>
                            <p class="text-slate-400 text-xs mt-1">Awaiting start</p>
                        </div>
                        <div >
                                @include('components.icons.time', ['class' => 'icon-time'])  
                        </div>
                    </div>
                </div>

                <!-- In Progress Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">In Progress</p>
                            <p class="text-3xl font-bold mt-2">{{ $statusCounts['in_progress'] ?? 0 }}</p>
                            <p class="text-slate-400 text-xs mt-1">Currently working</p>
                        </div>
                        <div>
                            @include('components.icons.tool', ['class' => 'icon-time'])
                           
                    </div>
                    </div>
                </div>


                <!-- Completed Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">Completed</p>
                            <p class="text-3xl font-bold mt-2">{{ $statusCounts['completed'] ?? 0 }}</p>
                            <p class="text-slate-400 text-xs mt-1">This month</p>
                        </div>
                        <div >
                            @include('components.icons.checkmark', ['class' => 'icon-time'])
                        </div>
                    </div>
                </div>

                <!-- Overdue Card -->
                <div class="bg-slate-700 rounded-lg p-6 text-white">
                    <div class="flex justify-between items-start">
                        <div>
                            <p class="text-slate-300 text-sm">Overdue</p>
                            <p class="text-3xl font-bold mt-2">{{ $statusCounts['overdue'] ?? 0 }}</p>
                            <p class="text-slate-400 text-xs mt-1">Requires attention</p>
                        </div>
                        <div >
                           @include('components.icons.alert', ['class' => 'icon-alert'])
                        </div>
                    </div>
                </div>
            </div>

            
            <!-- Production Workflow Section -->
            <div class="bg-slate-700 rounded-lg p-6">
                <div class="flex justify-between items-center mb-6">
                    <div>
                        <h2 class="text-xl font-bold text-white">Production Workflow</h2>
                        <p class="text-slate-300 text-sm mt-1">Manage your raw materials and finished products</p>
                    </div>
                    <div class="flex space-x-3">
                        <button onclick="openWorkOrderModal()" class="px-4 py-2 bg-white text-[#374151] rounded-lg hover:bg-[#DEE4EF] flex items-center space-x-2">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
                            </svg>
                            <span>Work Orders</span>
                        </button>
                    </div>
                </div>

                <!-- Search and Filter Bar -->
                <div class="flex justify-between items-center mb-12">
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                            </div>
                            <input type="text" placeholder="Search work orders..." class="w-[850px] pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                        </div>
                    </div>
                    <div class="flex space-x-3">
                        <button class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3a1 1 0 000 2h11.586l-1.293 1.293a1 1 0 101.414 1.414L16.414 6H19a1 1 0 100-2H3zM3 11a1 1 0 100 2h11.586l-1.293-1.293a1 1 0 111.414-1.414L16.414 14H19a1 1 0 100-2H3z"/>
                            </svg>
                            <span>All Status</span>
                        </button>
                        <button class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path d="M3 3a1 1 0 000 2h11.586l-1.293 1.293a1 1 0 101.414 1.414L16.414 6H19a1 1 0 100-2H3zM3 11a1 1 0 100 2h11.586l-1.293-1.293a1 1 0 111.414-1.414L16.414 14H19a1 1 0 100-2H3z"/>
                            </svg>
                            <span>All Priority</span>
                        </button>
                    </div>
                </div>

                <!-- Work Orders Table -->
                <div class="overflow-x-auto">
                    <table class="w-full text-white">
                        <thead>
                            <tr class="border-b border-slate-600">
                                <th class="text-left py-3 px-4 font-medium">Order #</th>
                                <th class="text-left py-3 px-4 font-medium">Product</th>
                                <th class="text-left py-3 px-4 font-medium">Quantity</th>
                                <th class="text-left py-3 px-4 font-medium">Due Date</th>
                                <th class="text-left py-3 px-4 font-medium">Assigned To</th>
                                <th class="text-left py-3 px-4 font-medium">Action</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-600">
                            @forelse($workOrders ?? [] as $workOrder)
                            <tr class="hover:bg-slate-600 cursor-pointer">
                                <td class="py-3 px-4">{{ $workOrder->order_number }}</td>
                                <td class="py-3 px-4">{{ $workOrder->product_name }}</td>
                                <td class="py-3 px-4">{{ $workOrder->quantity }} pcs</td>
                                <td class="py-3 px-4">{{ $workOrder->due_date->format('m/d/Y') }}</td>
                                <td class="py-3 px-4">{{ $workOrder->assigned_to }}</td>
                                <td class="py-3 px-4">
                                    <div class="flex space-x-2">
                                        <button onclick="viewWorkOrder({{ $workOrder->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
                                                <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        <button onclick="editWorkOrder({{ $workOrder->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
                                            </svg>
                                        </button>
                                        @if($workOrder->status === 'pending')
                                        <button onclick="startWorkOrder({{ $workOrder->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM9.555 7.168A1 1 0 008 8v4a1 1 0 001.555.832l3-2a1 1 0 000-1.664l-3-2z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        @elseif($workOrder->status === 'in_progress')
                                        <button onclick="pauseWorkOrder({{ $workOrder->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zM7 8a1 1 0 012 0v4a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v4a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                        @endif
                                        <button onclick="completeWorkOrder({{ $workOrder->id }})" class="p-1 hover:bg-slate-500 rounded">
                                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="8" class="py-8 px-4 text-center text-slate-400">No work orders found</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <!-- Add Work Order Modal -->
        <div id="workOrderModal" class="modal-overlay fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50" onclick="if(event.target === this) closeWorkOrderModal()">
            <div class="modal-content bg-amber-50 rounded-2xl max-w-2xl w-[92%] shadow-2xl transform transition-all" onclick="event.stopPropagation()">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6 pb-4 border-b border-gray-300">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Create Work Order</h3>
                            <p class="text-gray-600 text-base">Select a sales order to assign to a team.</p>
                        </div>
                        <button onclick="closeWorkOrderModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-full p-2 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>

                    <!-- Sales Orders List -->
                    <div id="salesOrdersListSection" class="space-y-3 max-h-64 overflow-y-auto mb-6">
                        @forelse($pendingSalesOrders ?? [] as $salesOrder)
                            @php
                                $itemsData = $salesOrder->items->map(fn($item) => ['id' => $item->product_id, 'name' => addslashes($item->product->product_name ?? 'Product'), 'quantity' => $item->quantity]);
                            @endphp
                            <div onclick="selectSalesOrder({{ $salesOrder->id }}, '{{ addslashes($salesOrder->order_number) }}', '{{ addslashes($salesOrder->customer->name ?? '') }}', '{{ $salesOrder->delivery_date }}', {{ json_encode($itemsData) }})" class="p-4 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-400 cursor-pointer transition">
                                <div class="flex justify-between items-start">
                                    <div class="flex-1">
                                        <h3 class="font-semibold text-gray-800">{{ $salesOrder->order_number }} - {{ $salesOrder->customer->name }}</h3>
                                        <p class="text-sm text-gray-600 mt-1">Items: 
                                            @foreach($salesOrder->items as $item)
                                                {{ $item->product->product_name ?? 'Product' }} ({{ $item->quantity }}), 
                                            @endforeach
                                        </p>
                                    </div>
                                    <span class="bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-semibold">{{ $salesOrder->items->count() }} items</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-2">Delivery: {{ \Carbon\Carbon::parse($salesOrder->delivery_date)->format('M d, Y') }}</p>
                            </div>
                        @empty
                            <p class="text-center text-gray-500 py-4">No pending sales orders available</p>
                        @endforelse
                    </div>

                    <!-- Team Assignment Form (Hidden by default) -->
                    <form id="workOrderForm" method="POST" action="{{ route('production.store') }}" class="hidden">
                        @csrf
                        <input type="hidden" name="sales_order_id" id="formSalesOrderId">
                        <input type="hidden" name="product_id" id="formProductId">
                        <input type="hidden" name="quantity" id="formQuantity">
                        <input type="hidden" name="due_date" id="formDueDate">
                        <input type="hidden" name="priority" value="medium">
                        
                        <div class="space-y-6">
                            <!-- Product line selector (when SO has multiple items) -->
                            <div id="productLineSelector" class="hidden">
                                <label class="block text-gray-700 text-lg font-medium mb-3">Select product line from this sales order <span class="text-red-500">*</span></label>
                                <select id="productLineSelect" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg">
                                    <option value="">Choose product...</option>
                                </select>
                            </div>

                            <!-- Order Summary -->
                            <div class="p-4 bg-blue-50 rounded-lg border border-blue-200">
                                <h3 class="font-semibold text-gray-800 mb-3">Order Summary</h3>
                                <div class="space-y-2 text-sm">
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Order #:</span>
                                        <span id="summaryOrderNumber" class="font-semibold text-gray-800">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Customer:</span>
                                        <span id="summaryCustomer" class="font-semibold text-gray-800">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Product:</span>
                                        <span id="summaryProduct" class="font-semibold text-gray-800">-</span>
                                    </div>
                                    <div class="flex justify-between">
                                        <span class="text-gray-600">Quantity:</span>
                                        <span id="summaryQuantity" class="font-semibold text-gray-800">-</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Team Assignment -->
                            <div>
                                <label class="block text-gray-700 text-lg font-medium mb-3">Assign To Team <span class="text-red-500">*</span></label>
                                <select name="assigned_to" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg" required>
                                    <option value="">Select Team</option>
                                    <option value="Team A">🔨 Team A</option>
                                    <option value="Team B">🔨 Team B</option>
                                    <option value="Team C">🔨 Team C</option>
                                </select>
                            </div>
                        </div>

                        <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-300">
                            <button type="button" onclick="resetWorkOrderForm()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all duration-200 text-base font-medium">
                                Back
                            </button>
                            <button type="submit" class="px-8 py-3 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition-all duration-200 text-base font-medium shadow-md hover:shadow-lg">
                                Create Work Order
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Work Order Modal -->
        <div id="editWorkOrderModal" class="modal-overlay fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-50" onclick="if(event.target === this) closeEditWorkOrderModal()">
            <div class="modal-content bg-amber-50 rounded-2xl max-w-lg w-[92%] shadow-2xl transform transition-all" onclick="event.stopPropagation()">
                <div class="p-8">
                    <div class="flex justify-between items-start mb-6 pb-4 border-b border-gray-300">
                        <div>
                            <h3 class="text-2xl font-bold text-gray-800 mb-2">Update Work Order</h3>
                            <p class="text-gray-600 text-base">Update the status and completion details.</p>
                        </div>
                        <button onclick="closeEditWorkOrderModal()" class="text-gray-400 hover:text-gray-600 hover:bg-gray-200 rounded-full p-2 transition-all duration-200">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                        </button>
                    </div>
                        
                        <form id="editWorkOrderForm" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="space-y-6">
                                <div>
                                    <label class="block text-gray-700 text-lg font-medium mb-3">Status</label>
                                    <select name="status" id="editStatus" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg" required>
                                        <option value="pending">Pending</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="quality_check">Quality Check</option>
                                        <option value="completed">Completed</option>
                                        <option value="overdue">Overdue</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-lg font-medium mb-3">Completion Quantity</label>
                                    <input type="number" name="completion_quantity" id="editCompletionQuantity" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg" required>
                                </div>
                            </div>
                            
                            <div class="flex justify-end gap-3 mt-8 pt-4 border-t border-gray-300">
                                <button type="button" onclick="closeEditWorkOrderModal()" class="px-6 py-3 border border-gray-300 rounded-lg hover:bg-gray-100 transition-all duration-200 text-base font-medium">
                                    Cancel
                                </button>
                                <button type="submit" class="px-8 py-3 bg-slate-700 text-white rounded-lg hover:bg-slate-600 transition-all duration-200 text-base font-medium shadow-md hover:shadow-lg">
                                    Update Work Order
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Modal functions with animations
            function openWorkOrderModal() {
                const modal = document.getElementById('workOrderModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                setTimeout(() => {
                    const content = modal.querySelector('.modal-content');
                    if (content) {
                        content.style.opacity = '0';
                        content.style.transform = 'scale(0.95) translateY(10px)';
                        setTimeout(() => {
                            content.style.transition = 'all 0.2s ease-out';
                            content.style.opacity = '1';
                            content.style.transform = 'scale(1) translateY(0)';
                        }, 10);
                    }
                }, 10);
            }

            function closeWorkOrderModal() {
                const modal = document.getElementById('workOrderModal');
                const content = modal.querySelector('.modal-content');
                if (content) {
                    content.style.transition = 'all 0.15s ease-in';
                    content.style.opacity = '0';
                    content.style.transform = 'scale(0.95) translateY(10px)';
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                        document.getElementById('workOrderForm').reset();
                        document.getElementById('salesOrdersListSection').classList.remove('hidden');
                        document.getElementById('productLineSelector').classList.add('hidden');
                    }, 150);
                } else {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                    document.getElementById('workOrderForm').reset();
                }
            }

            const workOrdersData = @json($workOrders ?? []);
            function editWorkOrder(id) {
                const wo = workOrdersData.find(w => w.id === id);
                if (wo) {
                    document.getElementById('editStatus').value = wo.status;
                    document.getElementById('editCompletionQuantity').value = wo.completion_quantity ?? 0;
                }
                const modal = document.getElementById('editWorkOrderModal');
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.getElementById('editWorkOrderForm').action = `/production/${id}`;
                setTimeout(() => {
                    const content = modal.querySelector('.modal-content');
                    if (content) {
                        content.style.opacity = '0';
                        content.style.transform = 'scale(0.95) translateY(10px)';
                        setTimeout(() => {
                            content.style.transition = 'all 0.2s ease-out';
                            content.style.opacity = '1';
                            content.style.transform = 'scale(1) translateY(0)';
                        }, 10);
                    }
                }, 10);
            }

            function closeEditWorkOrderModal() {
                const modal = document.getElementById('editWorkOrderModal');
                const content = modal.querySelector('.modal-content');
                if (content) {
                    content.style.transition = 'all 0.15s ease-in';
                    content.style.opacity = '0';
                    content.style.transform = 'scale(0.95) translateY(10px)';
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        modal.classList.remove('flex');
                    }, 150);
                } else {
                    modal.classList.add('hidden');
                    modal.classList.remove('flex');
                }
            }

            // Store current items when sales order is selected (for product line dropdown)
            let currentOrderItems = [];

            function selectSalesOrder(salesOrderId, orderNumber, customerName, deliveryDate, items) {
                const listSection = document.getElementById('salesOrdersListSection');
                const formSection = document.getElementById('workOrderForm');
                const productLineSelector = document.getElementById('productLineSelector');
                const productLineSelect = document.getElementById('productLineSelect');

                currentOrderItems = Array.isArray(items) ? items : JSON.parse(items);
                document.getElementById('formSalesOrderId').value = salesOrderId;
                document.getElementById('formDueDate').value = deliveryDate;
                document.getElementById('summaryOrderNumber').textContent = orderNumber;
                document.getElementById('summaryCustomer').textContent = customerName;

                productLineSelect.innerHTML = '<option value="">Choose product...</option>';
                currentOrderItems.forEach((item, idx) => {
                    const opt = document.createElement('option');
                    opt.value = idx;
                    opt.textContent = `${item.name} (Qty: ${item.quantity})`;
                    productLineSelect.appendChild(opt);
                });

                if (currentOrderItems.length > 1) {
                    productLineSelector.classList.remove('hidden');
                    productLineSelect.required = true;
                    document.getElementById('formProductId').value = '';
                    document.getElementById('formQuantity').value = '';
                    document.getElementById('summaryProduct').textContent = '-';
                    document.getElementById('summaryQuantity').textContent = '-';
                } else {
                    productLineSelector.classList.add('hidden');
                    productLineSelect.required = false;
                    const first = currentOrderItems[0];
                    document.getElementById('formProductId').value = first.id;
                    document.getElementById('formQuantity').value = first.quantity;
                    document.getElementById('summaryProduct').textContent = first.name;
                    document.getElementById('summaryQuantity').textContent = first.quantity;
                }

                listSection.classList.add('hidden');
                formSection.classList.remove('hidden');
            }

            document.getElementById('productLineSelect')?.addEventListener('change', function() {
                const idx = this.value;
                if (idx === '' || !currentOrderItems.length) return;
                const item = currentOrderItems[parseInt(idx, 10)];
                if (item) {
                    document.getElementById('formProductId').value = item.id;
                    document.getElementById('formQuantity').value = item.quantity;
                    document.getElementById('summaryProduct').textContent = item.name;
                    document.getElementById('summaryQuantity').textContent = item.quantity;
                }
            });
            
            function resetWorkOrderForm() {
                const listSection = document.getElementById('salesOrdersListSection');
                const formSection = document.getElementById('workOrderForm');
                document.getElementById('workOrderForm').reset();
                document.getElementById('productLineSelector').classList.add('hidden');
                listSection.classList.remove('hidden');
                formSection.classList.add('hidden');
            }

            function viewWorkOrder(id) {
                // Implementation for viewing work order details
                console.log('View work order:', id);
            }

            function startWorkOrder(id) {
                if (confirm('Start this work order?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/production/' + id + '/start';
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            function pauseWorkOrder(id) {
                if (confirm('Pause this work order?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/production/' + id;
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
                    const method = document.createElement('input');
                    method.type = 'hidden'; method.name = '_method'; method.value = 'PUT';
                    const status = document.createElement('input');
                    status.type = 'hidden'; status.name = 'status'; status.value = 'in_progress';
                    form.appendChild(csrf); form.appendChild(method); form.appendChild(status);
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            function completeWorkOrder(id) {
                if (confirm('Mark this work order as completed?')) {
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = '/production/' + id + '/complete';
                    const csrf = document.createElement('input');
                    csrf.type = 'hidden'; csrf.name = '_token'; csrf.value = '{{ csrf_token() }}';
                    form.appendChild(csrf);
                    document.body.appendChild(form);
                    form.submit();
                }
            }

            // Close modals when clicking outside
            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('fixed')) {
                    closeWorkOrderModal();
                    closeEditWorkOrderModal();
                }
            });

            // Set minimum date to today
            document.addEventListener('DOMContentLoaded', function() {
                const today = new Date().toISOString().split('T')[0];
                document.querySelector('input[name="due_date"]').setAttribute('min', today);
            });
        </script>
@endsection
