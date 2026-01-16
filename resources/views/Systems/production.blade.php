@extends('layouts.system')

@section('main-content')
        <!-- Main Content -->
        <div class="flex-1 p-8 bg-amber-50">
            <!-- Header Section -->
            <div class="mb-8">
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
                                <th class="text-left py-3 px-4 font-medium">Completion Quantity</th>
                                <th class="text-left py-3 px-4 font-medium">Status</th>
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
                                <td class="py-3 px-4">{{ $workOrder->completion_quantity }}</td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full {{ $workOrder->status_color }}">
                                        {{ ucfirst(str_replace('_', ' ', $workOrder->status)) }}
                                    </span>
                                </td>
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
        <div id="workOrderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-amber-50 rounded-lg max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-xl">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-xl font-bold text-gray-800 mb-2">New Work Orders</h3>
                                <p class="text-gray-600 text-lg">New work order for a new production work order for furniture manufacturing.</p>
                            </div>
                            <button onclick="closeWorkOrderModal()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">
                                ×
                            </button>
                        </div>
                        
                        <form id="workOrderForm" method="POST" action="{{ route('production.store') }}">
                            @csrf
                            <div class="space-y-6">
                                <div>z
                                    <label class="block text-gray-700 text-lg font-medium mb-3">Pending Orders</label>
                                    <select name="product_name" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg" required>
                                        <option value="">Select Orders</option>
                                        <option value="Classic Oak Dining Chair">Classic Oak Dining Chair</option>
                                        <option value="Pine Coffee Table">Pine Coffee Table</option>
                                        <option value="Oak Kitchen Cabinet">Oak Kitchen Cabinet</option>
                                        <option value="Pine Bookshelf">Pine Bookshelf</option>
                                        <option value="Oak Dining Table">Oak Dining Table</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-lg font-medium mb-3">Assign To</label>
                                    <select name="assigned_to" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg" required>
                                        <option value="">Select Team</option>
                                        <option value="Workshop Team A">Workshop Team A</option>
                                        <option value="Workshop Team B">Workshop Team B</option>
                                        <option value="Finishing Team">Finishing Team</option>
                                        <option value="Assembly Team">Assembly Team</option>
                                    </select>
                                </div>
                                
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label class="block text-gray-700 text-lg font-medium mb-3">Quantity</label>
                                        <input type="number" name="quantity" min="1" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg" required>
                                    </div>
                                    
                                    <div>
                                        <label class="block text-gray-700 text-lg font-medium mb-3">Due Date</label>
                                        <input type="date" name="due_date" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg" required>
                                    </div>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-lg font-medium mb-3">Priority</label>
                                    <select name="priority" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg" required>
                                        <option value="">Select Priority</option>
                                        <option value="low">Low</option>
                                        <option value="medium">Medium</option>
                                        <option value="high">High</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-lg font-medium mb-3">Notes</label>
                                    <textarea name="notes" rows="3" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg"></textarea>
                                </div>
                            </div>
                            
                            <div class="flex justify-end mt-8">
                                <button type="submit" class="px-8 py-3 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition text-lg font-medium shadow-lg">
                                    Assign
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit Work Order Modal -->
        <div id="editWorkOrderModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50">
            <div class="flex items-center justify-center min-h-screen p-4">
                <div class="bg-amber-50 rounded-lg max-w-md w-full shadow-xl">
                    <div class="p-8">
                        <div class="flex justify-between items-center mb-6">
                            <div>
                                <h3 class="text-3xl font-bold text-gray-800 mb-2">Update Work Order</h3>
                                <p class="text-gray-600 text-lg">Update the status and completion details for this work order.</p>
                            </div>
                            <button onclick="closeEditWorkOrderModal()" class="text-gray-400 hover:text-gray-600 text-2xl font-bold">
                                ×
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
                                        <option value="completed">Completed</option>
                                        <option value="overdue">Overdue</option>
                                    </select>
                                </div>
                                
                                <div>
                                    <label class="block text-gray-700 text-lg font-medium mb-3">Completion Quantity</label>
                                    <input type="number" name="completion_quantity" id="editCompletionQuantity" min="0" class="w-full bg-white border border-gray-300 rounded-lg px-4 py-3 text-gray-700 focus:ring-2 focus:ring-blue-500 focus:border-transparent text-lg" required>
                                </div>
                            </div>
                            
                            <div class="flex justify-end mt-8">
                                <button type="submit" class="px-8 py-3 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition text-lg font-medium shadow-lg">
                                    Update
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <script>
            // Modal functions
            function openWorkOrderModal() {
                document.getElementById('workOrderModal').classList.remove('hidden');
            }

            function closeWorkOrderModal() {
                document.getElementById('workOrderModal').classList.add('hidden');
                document.getElementById('workOrderForm').reset();
            }

            function editWorkOrder(id) {
                // This would typically fetch work order data via AJAX
                document.getElementById('editWorkOrderModal').classList.remove('hidden');
                document.getElementById('editWorkOrderForm').action = `/production/${id}`;
            }

            function closeEditWorkOrderModal() {
                document.getElementById('editWorkOrderModal').classList.add('hidden');
            }

            function viewWorkOrder(id) {
                // Implementation for viewing work order details
                console.log('View work order:', id);
            }

            function startWorkOrder(id) {
                if (confirm('Start this work order?')) {
                    // Implementation for starting work order
                    console.log('Start work order:', id);
                }
            }

            function pauseWorkOrder(id) {
                if (confirm('Pause this work order?')) {
                    // Implementation for pausing work order
                    console.log('Pause work order:', id);
                }
            }

            function completeWorkOrder(id) {
                if (confirm('Mark this work order as completed?')) {
                    // Implementation for completing work order
                    console.log('Complete work order:', id);
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
