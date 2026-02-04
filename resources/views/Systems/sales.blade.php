@extends('layouts.system')

@section('main-content')
	<style>
		.selected-row {
			background-color: #4B5563 !important;
			border-left: 4px solid #F59E0B !important;
			box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
		}
		.selected-row:hover {
			background-color: #4B5563 !important;
		}
		.custom-scrollbar::-webkit-scrollbar {
			width: 8px;
		}
		.custom-scrollbar::-webkit-scrollbar-track {
			background: #475569;
			border-radius: 4px;
		}
		.custom-scrollbar::-webkit-scrollbar-thumb {
			background: #f59e0b;
			border-radius: 4px;
		}
		.custom-scrollbar::-webkit-scrollbar-thumb:hover {
			background: #d97706;
		}
	</style>
	@php
		$customerTypeBg = [
			'Wholesale' => '#64B5F6',
			'Retail' => '#6366F1',
			'Contractor' => '#BA68C8',
		];
		$statusBg = [
			'In production' => '#FFB74D',
			'Pending' => '#64B5F6',
			'Delivered' => '#81C784',
			'Ready' => '#BA68C8',
		];
		$paymentBg = [
			'Pending' => '#ffffff',
			'Partial' => '#FFB74D',
			'Paid' => '#81C784',
		];
	@endphp
	<style>
		.selected-row {
			background-color: #4B5563 !important;
			border-left: 4px solid #F59E0B !important;
		}
		.selected-row:hover {
			background-color: #4B5563 !important;
		}
	</style>
	@php
		$customerTypeBg = [
			'Wholesale' => '#64B5F6',
			'Retail' => '#6366F1',
			'Contractor' => '#BA68C8',
		];
		$statusBg = [
			'In production' => '#FFB74D',
			'Pending' => '#64B5F6',
			'Delivered' => '#81C784',
			'Ready' => '#BA68C8',
		];
		$paymentBg = [
			'Pending' => '#ffffff',
			'Partial' => '#FFB74D',
			'Paid' => '#81C784',
		];
	@endphp
		<!-- Main Content -->
		<div class="flex-1 flex flex-col overflow-hidden">
			<!-- Header -->
			<div class="bg-amber-50 p-8">
				<div class="flex justify-between items-center">
					<div>
						<h1 class="text-4xl font-bold text-gray-800">Sales & Orders</h1>
						<p class="text-lg text-gray-600 mt-2">Manage customer orders, sales, and deliveries</p>
					</div>
					<div class="relative">
						<button id="exportButton" class="flex items-center gap-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm text-white transition">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
							</svg>
							<span>Export</span>
							<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
							</svg>
						</button>
						<!-- Export Dropdown -->
						<div id="exportDropdown" class="hidden fixed w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-[9999]">
							<div class="py-1">
								<a href="#" onclick="exportReceipt(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
									<div class="flex items-center gap-2">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
										</svg>
										<span>Receipt</span>
									</div>
								</a>	
								<a href="#" onclick="exportSalesReport(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
									<div class="flex items-center gap-2">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
										</svg>
										<span>Sales Report</span>
									</div>
								</a>
								<a href="#" onclick="exportCustomerList(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
									<div class="flex items-center gap-2">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
										</svg>
										<span>Customer List</span>
									</div>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!-- Dashboard Content -->
			<div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
				<!-- Summary Cards Row -->
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
					<!-- Total Revenue Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex justify-between items-start">
							<div>
								<h3 class="text-sm font-medium text-slate-300">Total Revenue</h3>
							<p class="text-3xl font-bold mt-2">₱{{ number_format($salesOrders->sum('total_amount'), 0) }}</p>
								<p class="text-slate-300 text-sm mt-1">All time sales</p>
							</div>
							<div>
							@include('components.icons.package', ['class' => 'icon-package'])
							</div>
						</div>
					</div>

					<!-- Payments Received Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex justify-between items-start">
							<div>
								<h3 class="text-sm font-medium text-slate-300">Payments Received</h3>
							<p class="text-3xl font-bold mt-2">₱{{ number_format($salesOrders->where('payment_status', 'Paid')->sum('total_amount'), 0) }}</p>
								<p class="text-slate-300 text-sm mt-1">Paid orders</p>
							</div>
							<div >
							@include('components.icons.dollar', ['class' => 'icon-dollar'])
							</div>
						</div>
					</div>

					<!-- Pending Payments Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex justify-between items-start">
							<div>
								<h3 class="text-sm font-medium text-slate-300">Pending Payments</h3>
							<p class="text-3xl font-bold mt-2">₱{{ number_format($salesOrders->whereIn('payment_status', ['Pending', 'Partial'])->sum('total_amount'), 0) }}</p>
								<p class="text-slate-300 text-sm mt-1">Outstanding amount</p>
							</div>
							<div ">
							@include('components.icons.dollar', ['class' => 'icon-dollar'])
							</div>
						</div>
					</div>

					<!-- Active Orders Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex justify-between items-start">
							<div>
								<h3 class="text-sm font-medium text-slate-300">Active Orders</h3>
								<p class="text-3xl font-bold mt-2">{{ $salesOrders->whereIn('status', ['Pending', 'In production', 'Ready'])->count() }}</p>
								<p class="text-slate-300 text-sm mt-1">Orders in progress</p>
							</div>
							<div>
								@include('components.icons.cart', ['class' => 'icon-cart'])
							</div>
						</div>
					</div>
				</div>

				<!-- Sales Management Card -->
			<section class="bg-slate-700 text-white p-6 rounded-2xl overflow-visible">
					<header class="flex justify-between items-center mb-4">
						<div>
							<h2 class="text-xl font-semibold">Sales Management</h2>
							<p class="text-gray-300">Manage customer orders and track sales performance</p>
						</div>
						<button id="headerBtn" class="px-4 py-2  bg-white text-[#374151] rounded-lg hover:bg-[#DEE4EF]" onclick="openModal('newOrderModal')">+ New Order</button>
					</header>

					<!-- Search + Filters -->
					<div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
						<input type="search" id="searchInput" placeholder="Search order or customers..." class="bg-white w-full md:w-3/4 rounded-full px-4 py-2 text-gray-900 focus:outline-none">
						<div class="flex gap-2">
							<select id="statusFilter" class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
								<option value="">All Status</option>
								<option value="Pending">Pending</option>
								<option value="In production">In Production</option>
								<option value="Ready">Ready</option>
								<option value="Delivered">Delivered</option>
							</select>
							<select id="paymentFilter" class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
								<option value="">All Payment</option>
								<option value="Pending">Unpaid</option>
								<option value="Partial">Partial</option>
								<option value="Paid">Paid</option>
							</select>
						</div>
					</div>

					<!-- Tabs -->
					<div class="flex justify-center gap-2 mb-6">
						<button id="salesTab" class="flex-auto px-[240px] py-2 rounded-lg" style="background-color: #FFF1DA; color: #111827;">Orders</button>
						<button id="customersTab" class="flex-auto px-[240px] py-2 rounded-lg border" style="background-color: #374151; border: 1px solid #FFFFFF; color: #FFFFFF;">Customers</button>
					</div>

					<!-- Sales Orders Table -->
					<div id="salesTable" class="overflow-y-auto overflow-x-visible" style="max-height: 60vh;">
						<table class="w-full border-collapse text-left text-sm text-white">
							<thead class="bg-slate-800 text-slate-300 sticky top-0">
								<tr>
									<th class="px-4 py-3 font-medium">Order #</th>
									<th class="px-4 py-3 font-medium">Customer</th>
									<th class="px-4 py-3 font-medium">Order Date</th>
									<th class="px-4 py-3 font-medium">Delivery Date</th>
									<th class="px-4 py-3 font-medium">Total Amount</th>
									<th class="px-4 py-3 font-medium">Payment Status</th>
									<th class="px-4 py-3 font-medium">Action</th>
								</tr>
							</thead>
							<tbody id="salesTbody" class="divide-y divide-slate-600">
								@forelse($salesOrders as $order)
									<tr class="hover:bg-slate-600 transition cursor-pointer data-row" data-status="{{ $order->status }}" data-payment="{{ $order->payment_status }}">
										<td class="px-4 py-3 font-mono text-slate-300">{{ $order->order_number }}</td>
										<td class="px-4 py-3">
											<div class="font-medium text-slate-300">{{ $order->customer?->name }}</div>
											@php $ct = $order->customer?->customer_type; $ctBg = $customerTypeBg[$ct] ?? '#e5e7eb'; @endphp
											<span class="mt-1 inline-block text-xs font-semibold text-white px-2 py-0.5 rounded" style="background: {{ $ctBg }};">{{ $ct }}</span>
										</td>
										<td class="px-4 py-3 text-slate-300">{{ \Illuminate\Support\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
										<td class="px-4 py-3 text-slate-300">{{ \Illuminate\Support\Carbon::parse($order->delivery_date)->format('M d, Y') }}</td>
										@php
											$sb = $order->status === 'Pending' ? '#ffffff' : ($statusBg[$order->status] ?? '#e5e7eb');
											$stText = $order->status === 'Pending' ? 'text-gray-900' : 'text-white';
										@endphp
										<td class="px-4 py-3 font-bold text-slate-300">₱{{ number_format($order->total_amount, 2) }}</td>
										@php
											$pb = $paymentBg[$order->payment_status] ?? '#ffffff';
											$ptText = $order->payment_status === 'Pending' ? 'text-gray-900' : 'text-white';
											$pendingBorder = $order->payment_status==='Pending' ? 'border border-gray-300' : '';
										@endphp
										<td class="px-4 py-3">
											@if($order->payment_status === 'Paid')
												<span class="text-xs font-semibold text-green-400">{{ $order->payment_status }}</span>
											@elseif($order->payment_status === 'Partial')
												<span class="text-xs font-semibold text-yellow-400">{{ $order->payment_status }}</span>
											@else
												<span class="text-xs font-semibold text-slate-400">{{ $order->payment_status }}</span>
											@endif
										</td>
										<td class="px-4 py-3">
											<div class="flex space-x-2">
												<button onclick="openModal('viewOrderModal-{{ $order->id }}')" class="p-1 hover:bg-slate-500 rounded" title="View">
													<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
														<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
														<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
													</svg>
												</button>
												<button onclick="openModal('editOrderModal-{{ $order->id }}')" class="p-1 hover:bg-slate-500 rounded" title="Edit">
													<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
														<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
													</svg>
												</button>
												<form action="{{ route('sales-orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Cancel this order?')" class="inline">
													@csrf
													@method('DELETE')
													<button type="submit" class="p-1 hover:bg-slate-500 rounded" title="Delete">
														<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
															<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
														</svg>
													</button>
												</form>
											</div>
										</td>
									</tr>

									<!-- View Order Modal -->
										<div id="viewOrderModal-{{ $order->id }}" class="fixed inset-0 bg-black/70 hidden overflow-y-auto" style="z-index: 99999;">
										<div class="rounded-lg shadow-2xl max-w-4xl w-[95%] mx-auto my-8 p-8" style="background-color: #FFF1DA;">
											<!-- Header -->
											<div class="flex items-center justify-between mb-8 border-b-2 pb-6" style="border-color: #374151;">
												<div>
													<h3 class="text-3xl font-bold" style="color: #374151;">Order #{{ $order->order_number }}</h3>
													<p class="mt-1" style="color: #666;">{{ $order->customer?->name }}</p>
												</div>
												<button class="text-2xl transition" style="color: #999;" onclick="closeModal('viewOrderModal-{{ $order->id }}')">✕</button>
											</div>

											<!-- Order Information Cards -->
											<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
												<div class="p-4 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
													<p class="text-sm font-semibold" style="color: #374151;">Customer Type</p>
													<p class="text-lg font-bold mt-2" style="color: {{ $customerTypeBg[$order->customer?->customer_type] ?? '#374151' }};">{{ $order->customer?->customer_type }}</p>
												</div>
												<div class="p-4 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
													<p class="text-sm font-semibold" style="color: #374151;">Order Date</p>
													<p class="text-lg font-bold mt-2" style="color: #374151;">{{ \Illuminate\Support\Carbon::parse($order->order_date)->format('M d, Y') }}</p>
												</div>
												<div class="p-4 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
													<p class="text-sm font-semibold" style="color: #374151;">Delivery Date</p>
													<p class="text-lg font-bold mt-2" style="color: #374151;">{{ \Illuminate\Support\Carbon::parse($order->delivery_date)->format('M d, Y') }}</p>
												</div>
												<div class="p-4 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
													<p class="text-sm font-semibold" style="color: #374151;">Status</p>
													<p class="text-lg font-bold mt-2 px-2 py-1 rounded text-white text-center" style="background: {{ $statusBg[$order->status] ?? '#e5e7eb' }};">{{ $order->status }}</p>
												</div>
											</div>

											<!-- Payment Information -->
											<div class="grid grid-cols-2 md:grid-cols-3 gap-4 mb-8">
												<div class="p-4 rounded-lg border" style="background-color: rgba(255,255,255,0.7); border-color: #374151;">
													<p class="text-sm font-semibold" style="color: #374151;">Payment Status</p>
													<p class="text-lg font-bold mt-2 
														@if($order->payment_status === 'Paid') text-green-600
														@elseif($order->payment_status === 'Partial') text-orange-600
														@else
														@endif" style="@if($order->payment_status !== 'Paid' && $order->payment_status !== 'Partial')color: #374151;@endif">
														{{ $order->payment_status }}
													</p>
												</div>
												<div class="p-4 rounded-lg border md:col-span-2" style="background-color: rgba(255,255,255,0.7); border-color: #374151;">
													<p class="text-sm font-semibold" style="color: #374151;">Total Amount</p>
													<p class="text-2xl font-bold mt-2" style="color: #374151;">₱{{ number_format($order->total_amount, 2) }}</p>
												</div>
											</div>

											<!-- Products Ordered -->
											<div class="mb-8">
												<h4 class="text-xl font-bold mb-4 flex items-center" style="color: #374151;">
													<span class="w-1 h-6 rounded mr-3" style="background-color: #374151;"></span>
													Products & Materials Ordered
												</h4>
												@if($order->items && $order->items->count() > 0)
													<div class="space-y-3">
														@foreach($order->items as $item)
															<div class="p-5 rounded-lg border-l-4 hover:shadow-md transition" style="background-color: rgba(255,255,255,0.85); border-left-color: #374151;">
																<div class="flex justify-between items-start">
																	<div class="flex-1">
																		<h5 class="font-bold text-lg" style="color: #374151;">{{ $item->product?->product_name ?? 'Unknown Product' }}</h5>
																		<p class="text-sm mt-1" style="color: #666;">Unit Price: <span class="font-semibold" style="color: #374151;">₱{{ number_format($item->unit_price, 2) }}</span></p>
																	</div>
																	<div class="text-right">
																		<div class="inline-block px-4 py-2 rounded-full font-bold text-lg" style="background-color: #374151; color: #FFF1DA;">
																			{{ $item->quantity }} <span class="text-sm">pcs</span>
																		</div>
																	</div>
																</div>
																<div class="mt-3 pt-3 flex justify-between items-center" style="border-top: 1px solid #E8D5BF; color: #666;">
																	<span class="text-sm">Line Total:</span>
																	<span class="font-bold text-lg" style="color: #374151;">₱{{ number_format($item->quantity * $item->unit_price, 2) }}</span>
																</div>
															</div>
														@endforeach
													</div>
													<!-- Order Summary -->
													<div class="mt-6 p-5 rounded-lg border-2 flex justify-between items-center" style="background-color: rgba(55,65,81,0.1); border-color: #374151;">
														<span class="text-lg font-bold" style="color: #374151;">Order Total:</span>
														<span class="text-2xl font-bold" style="color: #374151;">₱{{ number_format($order->total_amount, 2) }}</span>
													</div>
												@else
													<div class="p-6 rounded-lg border text-center" style="background-color: rgba(255,255,255,0.7); border-color: #374151; color: #999;">
														No products in this order
													</div>
												@endif
											</div>

											<!-- Notes Section -->
											@if($order->note)
												<div class="p-6 rounded-lg border-l-4 mb-8" style="background-color: rgba(255,255,255,0.85); border-left-color: #374151;">
													<p class="font-semibold mb-2" style="color: #374151;">Notes</p>
													<p class="whitespace-pre-wrap" style="color: #666;">{{ $order->note }}</p>
												</div>
											@endif

											<!-- Close Button -->
											<div class="flex justify-end">
												<button class="px-6 py-3 rounded-lg font-semibold transition text-white" style="background-color: #374151;" onclick="closeModal('viewOrderModal-{{ $order->id }}')">Close</button>
											</div>
										</div>
									</div>

									<!-- Edit Order Modal -->
										<div id="editOrderModal-{{ $order->id }}" class="fixed inset-0 bg-black/50 hidden" style="z-index: 99999;">
										<div class="bg-white text-gray-900 rounded shadow max-w-lg w-full mx-auto mt-24 p-6">
											<div class="flex items-center justify-between mb-4">
												<h3 class="font-semibold">Edit Order {{ $order->order_number }}</h3>
												<button onclick="closeModal('editOrderModal-{{ $order->id }}')">✕</button>
											</div>
											<form method="POST" action="{{ route('sales-orders.update', $order) }}">
												@csrf
												@method('PUT')
												<div class="grid gap-4">
													<div>
														<label class="text-sm">Customer</label>
														<select name="customer_id" class="w-full border rounded px-2 py-1">
															@foreach($customers as $c)
																<option value="{{ $c->id }}" @selected($order->customer_id==$c->id)>{{ $c->name }} ({{ $c->customer_type }})</option>
															@endforeach
														</select>
													</div>
													<div>
														<label class="text-sm">Delivery Date</label>
														<input type="date" name="delivery_date" value="{{ $order->delivery_date }}" class="w-full border rounded px-2 py-1">
													</div>
													<div class="grid grid-cols-2 gap-3">
														

													</div>
													<div>
														<label class="text-sm">Notes</label>
														<textarea name="note" class="w-full border rounded px-2 py-1" rows="3">{{ $order->note }}</textarea>
													</div>
													<div class="flex justify-end gap-2">
														<button type="button" class="px-3 py-2 border rounded" onclick="closeModal('editOrderModal-{{ $order->id }}')">Cancel</button>
														<button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Save</button>
													</div>
												</form>
											</div>
									</div>

								@empty
									<tr><td colspan="8" class="text-center py-4">No orders yet. Click "New Order" to create one.</td></tr>
								@endforelse
								<tr id="salesNoMatch" class="hidden"><td colspan="8" class="text-center py-4">No matches</td></tr>
							</tbody>
						</table>
					</div>

					<!-- Customers Table -->
					<div id="customerTable" class="hidden overflow-y-auto overflow-x-visible" style="max-height: 60vh;">
						<table class="w-full border-collapse text-left text-sm text-white">
							<thead class="bg-slate-800 text-slate-300 sticky top-0">
								<tr>
									<th class="px-4 py-3 font-medium">Name</th>
									<th class="px-4 py-3 font-medium">Type</th>
									<th class="px-4 py-3 font-medium">Contact</th>
									<th class="px-4 py-3 font-medium">Email</th>
									<th class="px-4 py-3 font-medium">Total Orders</th>
									<th class="px-4 py-3 font-medium">Total Spent</th>
									<th class="px-4 py-3 font-medium">Action</th>
								</tr>
							</thead>
							<tbody id="customersTbody" class="divide-y divide-slate-600">
								@forelse($customers as $customer)
									<tr class="hover:bg-slate-600 transition cursor-pointer data-row">
										<td class="px-4 py-3 font-medium text-slate-300">{{ $customer->name }}</td>
										@php $ctBg = $customerTypeBg[$customer->customer_type] ?? '#e5e7eb'; @endphp
										<td class="px-4 py-3"><span class="inline-block text-xs font-semibold text-white px-2 py-0.5 rounded" style="background: {{ $ctBg }};">{{ $customer->customer_type }}</span></td>
										<td class="px-4 py-3 text-slate-300">{{ $customer->phone }}</td>
										<td class="px-4 py-3 text-slate-300">{{ $customer->email }}</td>
										<td class="px-4 py-3 text-slate-300">{{ $customer->totalOrders() }}</td>
										<td class="px-4 py-3 font-bold text-slate-300">₱{{ number_format($customer->totalSpent(), 2) }}</td>
									<td class="px-4 py-3">
										<div class="flex space-x-2">
											<button onclick="openModal('viewCustomerModal-{{ $customer->id }}')" class="p-1 hover:bg-slate-500 rounded" title="View">
												<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
													<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
													<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
												</svg>
											</button>
											<button onclick="openModal('editCustomerModal-{{ $customer->id }}')" class="p-1 hover:bg-slate-500 rounded" title="Edit">
												<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
													<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
												</svg>
											</button>
											<form action="{{ route('customers.delete', $customer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?')" class="inline">
												@csrf
												@method('DELETE')
												<button type="submit" class="p-1 hover:bg-slate-500 rounded" title="Delete">
													<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
														<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
													</svg>
												</button>
											</form>
										</div>
									<!-- View Customer Modal -->
								<div id="viewCustomerModal-{{ $customer->id }}" class="fixed inset-0 bg-black/70 hidden" style="z-index: 99999;">
										<div class="bg-white text-gray-900 rounded-lg shadow-xl max-w-4xl w-[92%] mx-auto mt-16 p-6 max-h-[90vh] overflow-y-auto">
											<div class="flex items-center justify-between mb-4">
												<h3 class="text-2xl font-bold">Customer Details</h3>
												<button class="text-xl" onclick="closeModal('viewCustomerModal-{{ $customer->id }}')">✕</button>
											</div>
											<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg leading-relaxed mb-6">
												<div><span class="font-semibold">Name:</span> {{ $customer->name }}</div>
												<div><span class="font-semibold">Type:</span> <span class="px-2 py-0.5 rounded text-white" style="background: {{ $customerTypeBg[$customer->customer_type] ?? '#e5e7eb' }};">{{ $customer->customer_type }}</span></div>
												<div><span class="font-semibold">Contact #:</span> {{ $customer->phone ?: '—' }}</div>
												<div><span class="font-semibold">Email:</span> {{ $customer->email ?: '—' }}</div>
												<div><span class="font-semibold">Total Orders:</span> {{ $customer->totalOrders() }}</div>
												<div><span class="font-semibold">Total Spent:</span> ₱{{ number_format($customer->totalSpent(), 2) }}</div>
											</div>

											<!-- Products Purchased Section -->
											<div class="border-t pt-6">
												<h4 class="text-xl font-semibold mb-4">Products Purchased</h4>
												@php
													$productsSummary = [];
													foreach($customer->salesOrders as $order) {
														foreach($order->items as $item) {
															$productName = $item->product->product_name ?? 'Unknown Product';
															if (!isset($productsSummary[$productName])) {
																$productsSummary[$productName] = 0;
															}
															$productsSummary[$productName] += $item->quantity;
														}
													}
												@endphp
												@if(count($productsSummary) > 0)
													<div class="overflow-x-auto">
														<table class="w-full text-sm border-collapse">
															<thead>
																<tr class="bg-slate-100 border-b">
																	<th class="px-4 py-2 text-left font-semibold">Product Name</th>
																	<th class="px-4 py-2 text-right font-semibold">Total Quantity</th>
																</tr>
															</thead>
															<tbody>
																@foreach($productsSummary as $productName => $totalQty)
																	<tr class="border-b hover:bg-slate-50">
																		<td class="px-4 py-2">{{ $productName }}</td>
																		<td class="px-4 py-2 text-right font-medium">{{ $totalQty }} pcs</td>
																	</tr>
																@endforeach
															</tbody>
														</table>
													</div>
												@else
													<p class="text-slate-500 text-sm">No products purchased yet</p>
												@endif
											</div>

											<div class="flex justify-end mt-6">
												<button class="px-4 py-2 bg-gray-900 text-white rounded" onclick="closeModal('viewCustomerModal-{{ $customer->id }}')">Close</button>
											</div>
										</div>
									</div>

									<!-- Edit Customer Modal -->
								<div id="editCustomerModal-{{ $customer->id }}" class="fixed inset-0 bg-black/50 hidden" style="z-index: 99999;">
										<div class="bg-white text-gray-900 rounded shadow max-w-lg w-full mx-auto mt-24 p-6 max-h-[90vh] overflow-y-auto">
											<div class="flex items-center justify-between mb-4">
												<h3 class="font-semibold">Edit Customer</h3>
												<button onclick="closeModal('editCustomerModal-{{ $customer->id }}')">✕</button>
											</div>
											@if ($errors->any())
												<div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
													<ul class="list-disc list-inside text-sm">
														@foreach ($errors->all() as $error)
															<li>{{ $error }}</li>
														@endforeach
													</ul>
												</div>
											@endif
											<form method="POST" action="{{ route('customers.update', $customer) }}" class="editCustomerForm">
												@csrf
												@method('PUT')
												<div class="grid gap-4">
													<div>
														<label class="text-sm">Name <span class="text-red-500">*</span></label>
														<input type="text" name="name" value="{{ old('name', $customer->name) }}" class="w-full border rounded px-2 py-1 @error('name') border-red-500 @enderror" required minlength="2" maxlength="255" pattern="[a-zA-Z\s'-]+" title="Name must contain only letters, spaces, hyphens, and apostrophes">
														@error('name')
															<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
														@else
															<p class="text-gray-400 text-xs mt-1">This field is required. Enter customer name.</p>
														@enderror
													</div>
													<div class="grid grid-cols-2 gap-3">
														<div>
															<label class="text-sm">Type <span class="text-red-500">*</span></label>
															<select name="customer_type" class="w-full border rounded px-2 py-1 @error('customer_type') border-red-500 @enderror" required>
																@foreach(['Retail','Contractor','Wholesale'] as $t)
																	<option value="{{ $t }}" {{ old('customer_type', $customer->customer_type) === $t ? 'selected' : '' }}>{{ $t }}</option>
																@endforeach
															</select>
															@error('customer_type')
																<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
															@else
																<p class="text-gray-400 text-xs mt-1">This field is required. Select a customer type.</p>
															@enderror
														</div>
														<div>
															<label class="text-sm">Phone <span class="text-orange-500">**</span></label>
															<input type="tel" name="phone" class="editCustomerPhone w-full border rounded px-2 py-1 @error('phone') border-red-500 @enderror @error('contact') border-red-500 @enderror" value="{{ old('phone', $customer->phone) }}" placeholder="09XXXXXXXXX" maxlength="12" pattern="[0-9]{0,12}" title="Phone must be up to 12 digits">
															@error('phone')
																<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
															@else
																<p class="text-gray-400 text-xs mt-1">Enter a phone number (up to 12 digits) or email below.</p>
															@enderror
														</div>
													</div>
													<div>
														<label class="text-sm">Email <span class="text-orange-500">**</span></label>
														<input type="email" name="email" class="editCustomerEmail w-full border rounded px-2 py-1 @error('email') border-red-500 @enderror @error('contact') border-red-500 @enderror" value="{{ old('email', $customer->email) }}" maxlength="255" title="Please enter a valid email address">
														@error('email')
															<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
														@enderror
														@error('contact')
															<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
														@else
															<p class="text-gray-400 text-xs mt-1">** At least one contact method (phone or email) is required</p>
														@enderror
														<p class="editCustomerContactError text-red-500 text-xs mt-1 hidden"></p>
													</div>
													<div class="flex justify-end gap-2">
														<button type="button" class="px-3 py-2 border rounded" onclick="closeModal('editCustomerModal-{{ $customer->id }}')">Cancel</button>
														<button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Save</button>
													</div>
												</form>
											</div>
									</div>
								@empty
									<tr><td colspan="7" class="text-center py-4">No customers yet. Click "New Customer" to add one.</td></tr>
								@endforelse
								<tr id="customersNoMatch" class="hidden"><td colspan="7" class="text-center py-4">No matches</td></tr>
							</tbody>
						</table>
					</div>
				</section>

				<!-- New Order Modal -->
				<div id="newOrderModal" class="fixed inset-0 bg-black/50 hidden">
					<div class="bg-white text-gray-900 rounded shadow max-w-2xl w-full mx-auto mt-16 p-6 max-h-[90vh] overflow-y-auto">
						<div class="flex items-center justify-between mb-4">
							<h3 class="font-semibold">Create New Order</h3>
							<button onclick="closeModal('newOrderModal')">✕</button>
						</div>
						@if ($errors->any())
							<div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
								<ul class="list-disc list-inside text-sm">
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<form method="POST" action="{{ route('sales-orders.store') }}">
							@csrf
							<div class="grid gap-4">
								<div>
									<label class="text-sm">Customer <span class="text-red-500">*</span></label>
									<select name="customer_id" class="w-full border rounded px-2 py-1 @error('customer_id') border-red-500 @enderror" required>
										<option value="">-- Select Customer --</option>
										@foreach($customers as $c)
											<option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->customer_type }})</option>
										@endforeach
									</select>
									@error('customer_id')
										<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
									@enderror
								</div>
								<div class="grid grid-cols-2 gap-3">
									<div>
										<label class="text-sm">Delivery Date <span class="text-red-500">*</span></label>
										<input type="date" name="delivery_date" class="w-full border rounded px-2 py-1 @error('delivery_date') border-red-500 @enderror" value="{{ old('delivery_date') }}" required>
										@error('delivery_date')
											<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
										@enderror
									</div>
								</div>
								<div class="grid grid-cols-3 gap-3 items-end">
									<div>
										<label class="text-sm">Product <span class="text-red-500">*</span></label>
										<select id="newItemProduct" name="items[0][product_id]" class="w-full border rounded px-2 py-1 @error('items.0.product_id') border-red-500 @enderror" required>
											<option value="">-- select product --</option>
											@foreach($products as $p)
												<option value="{{ $p->id }}" data-price="{{ number_format($p->selling_price,2,'.','') }}">{{ $p->product_name }}</option>
											@endforeach
										</select>
										@error('items.0.product_id')
											<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
										@enderror
									</div>
									<div>
										<label class="text-sm">Quantity <span class="text-red-500">*</span></label>
										<input id="newItemQty" type="number" min="1" name="items[0][quantity]" class="w-full border rounded px-2 py-1 @error('items.0.quantity') border-red-500 @enderror" placeholder="1" value="{{ old('items.0.quantity') }}" required>
										@error('items.0.quantity')
											<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
										@enderror
									</div>
									<div>
										<label class="text-sm">Unit Price</label>
										<input id="newItemUnitPrice" type="text" class="w-full border rounded px-2 py-1 bg-gray-100" value="" placeholder="auto" disabled>
										<input id="newItemUnitPriceHidden" type="hidden" name="items[0][unit_price]" value="">
										<div class="text-xs text-gray-500 mt-1" id="newItemLineTotal">Line total: ₱0.00</div>
									</div>
								</div>
								<div>
									<label class="text-sm">Notes</label>
									<textarea name="note" rows="2" class="w-full border rounded px-2 py-1" placeholder="Optional notes..."></textarea>
								</div>
								<div class="flex justify-end gap-2 mt-2">
									<button type="button" class="px-3 py-2 border rounded" onclick="closeModal('newOrderModal')">Cancel</button>
									<button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Create</button>
								</div>
							</div>
						</form>
					</div>
				</div>

				<!-- New Customer Modal -->
				<div id="newCustomerModal" class="fixed inset-0 bg-black/50 hidden">
					<div class="bg-white text-gray-900 rounded shadow max-w-lg w-full mx-auto mt-24 p-6">
						<div class="flex items-center justify-between mb-4">
							<h3 class="font-semibold">Add New Customer</h3>
							<button onclick="closeModal('newCustomerModal')">✕</button>
						</div>
						@if ($errors->any())
							<div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
								<ul class="list-disc list-inside text-sm">
									@foreach ($errors->all() as $error)
										<li>{{ $error }}</li>
									@endforeach
								</ul>
							</div>
						@endif
						<form method="POST" action="{{ route('customers.store') }}" id="newCustomerForm">
							@csrf
							<div class="grid gap-4">
								<div>
									<label class="text-sm">Name <span class="text-red-500">*</span></label>
									<input type="text" name="name" class="w-full border rounded px-2 py-1 @error('name') border-red-500 @enderror" value="{{ old('name') }}" required minlength="2" maxlength="255" pattern="[a-zA-Z\s'-]+" title="Name must contain only letters, spaces, hyphens, and apostrophes">
									@error('name')
										<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
									@else
										<p class="text-gray-400 text-xs mt-1">This field is required. Enter customer name.</p>
									@enderror
								</div>
								<div class="grid grid-cols-2 gap-3">
									<div>
										<label class="text-sm">Type <span class="text-red-500">*</span></label>
										<select name="customer_type" class="w-full border rounded px-2 py-1 @error('customer_type') border-red-500 @enderror" required>
											<option value="">-- Select Type --</option>
											@foreach(['Retail','Contractor','Wholesale'] as $t)
												<option value="{{ $t }}" {{ old('customer_type') === $t ? 'selected' : '' }}>{{ $t }}</option>
											@endforeach
										</select>
										@error('customer_type')
											<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
										@else
											<p class="text-gray-400 text-xs mt-1">This field is required. Select a customer type.</p>
										@enderror
									</div>
									<div>
										<label class="text-sm">Phone <span class="text-orange-500">**</span></label>
										<input type="tel" name="phone" id="newCustomerPhone" class="w-full border rounded px-2 py-1 @error('phone') border-red-500 @enderror @error('contact') border-red-500 @enderror" value="{{ old('phone') }}" placeholder="09XXXXXXXXX" maxlength="12" pattern="[0-9]{0,12}" title="Phone must be up to 12 digits">
										@error('phone')
											<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
										@else
											<p class="text-gray-400 text-xs mt-1">Enter a phone number (up to 12 digits) or email below.</p>
										@enderror
									</div>
								</div>
								<div>
									<label class="text-sm">Email <span class="text-orange-500">**</span></label>
									<input type="email" name="email" id="newCustomerEmail" class="w-full border rounded px-2 py-1 @error('email') border-red-500 @enderror @error('contact') border-red-500 @enderror" value="{{ old('email') }}" maxlength="255" title="Please enter a valid email address">
									@error('email')
										<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
									@enderror
									@error('contact')
										<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
									@else
										<p class="text-gray-400 text-xs mt-1">** At least one contact method (phone or email) is required</p>
									@enderror
									<p id="newCustomerContactError" class="text-red-500 text-xs mt-1 hidden"></p>
								</div>
								<div class="flex justify-end gap-2">
									<button type="button" class="px-3 py-2 border rounded" onclick="closeModal('newCustomerModal')">Cancel</button>
									<button type="submit" class="px-3 py-2 bg-blue-600 text-white rounded">Create</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>

		function openModal(modalId) {
			document.getElementById(modalId).classList.remove('hidden');
		}

		function closeModal(modalId) {
			document.getElementById(modalId).classList.add('hidden');
		}

		(function() {
			const salesTab = document.getElementById('salesTab');
			const customersTab = document.getElementById('customersTab');
			const salesTable = document.getElementById('salesTable');
			const customerTable = document.getElementById('customerTable');
			const headerBtn = document.getElementById('headerBtn');
			const searchInput = document.getElementById('searchInput');
			const statusFilter = document.getElementById('statusFilter');
			const paymentFilter = document.getElementById('paymentFilter');
			const salesTbody = document.getElementById('salesTbody');
			const customersTbody = document.getElementById('customersTbody');
			const salesNoMatch = document.getElementById('salesNoMatch');
			const customersNoMatch = document.getElementById('customersNoMatch');
			// New order real-time pricing refs
			const newItemProduct = document.getElementById('newItemProduct');
			const newItemQty = document.getElementById('newItemQty');
			const newItemUnitPrice = document.getElementById('newItemUnitPrice');
			const newItemUnitPriceHidden = document.getElementById('newItemUnitPriceHidden');
			const newItemLineTotal = document.getElementById('newItemLineTotal');

			function setMode(mode) {
				if (mode === 'sales') {
					salesTable.classList.remove('hidden');
					customerTable.classList.add('hidden');
					headerBtn.textContent = '+ New Order';
					headerBtn.setAttribute('onclick', 'openModal("newOrderModal")');
					salesTab.style.backgroundColor = '#FFF1DA';
					salesTab.style.color = '#111827';
					salesTab.style.border = 'none';
					customersTab.style.backgroundColor = '#374151';
					customersTab.style.color = '#FFFFFF';
					customersTab.style.border = '1px solid #FFFFFF';
				} else {
					salesTable.classList.add('hidden');
					customerTable.classList.remove('hidden');
					headerBtn.textContent = '+ New Customer';
					headerBtn.setAttribute('onclick', 'openModal("newCustomerModal")');
					customersTab.style.backgroundColor = '#FFF1DA';
					customersTab.style.color = '#111827';
					customersTab.style.border = 'none';
					salesTab.style.backgroundColor = '#374151';
					salesTab.style.color = '#FFFFFF';
					salesTab.style.border = '1px solid #FFFFFF';
				}
				applyFilters();
			}

			salesTab.addEventListener('click', () => setMode('sales'));
			customersTab.addEventListener('click', () => setMode('customers'));

			function stringIncludes(haystack, needle) {
				return haystack.toLowerCase().includes(needle.toLowerCase());
			}

			function applyFilters() {
				const q = searchInput.value.trim();
				const sVal = statusFilter.value;
				const pVal = paymentFilter.value;
				const inSales = !salesTable.classList.contains('hidden');

				if (inSales) {
					let any = false;
					const rows = salesTbody.querySelectorAll('tr.data-row');
					rows.forEach(tr => {
						let show = true;
						if (q) {
							const text = tr.textContent || '';
							show = show && stringIncludes(text, q);
						}
						if (sVal) {
							show = show && (tr.dataset.status === sVal);
						}
						if (pVal) {
							show = show && (tr.dataset.payment === pVal);
						}
						tr.classList.toggle('hidden', !show);
						any = any || show;
					});
					salesNoMatch.classList.toggle('hidden', any);
				} else {
					let any = false;
					const rows = customersTbody.querySelectorAll('tr.data-row');
					rows.forEach(tr => {
						let show = true;
						if (q) {
							const nameCell = tr.querySelector('td:nth-child(1)');
							const typeCell = tr.querySelector('td:nth-child(2)');
							const contactCell = tr.querySelector('td:nth-child(3)');
							const hay = [nameCell, typeCell, contactCell].map(c => (c?.textContent || '')).join(' ');
							show = show && stringIncludes(hay, q);
						}
						tr.classList.toggle('hidden', !show);
						any = any || show;
					});
					customersNoMatch.classList.toggle('hidden', any);
				}
			}

			searchInput.addEventListener('input', applyFilters);
			statusFilter.addEventListener('change', applyFilters);
			paymentFilter.addEventListener('change', applyFilters);

			// ---- Real-time unit price + line total for New Order modal ----
			function toNumber(value) {
				const n = parseFloat(value);
				return Number.isFinite(n) ? n : 0;
			}

			function formatCurrency(num) {
				return '₱' + num.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
			}

			function getSelectedUnitPrice() {
				if (!newItemProduct) return 0;
				const opt = newItemProduct.options[newItemProduct.selectedIndex];
				const priceAttr = opt ? opt.getAttribute('data-price') : null;
				return toNumber(priceAttr);
			}

			function updatePricingFields() {
				const unit = getSelectedUnitPrice();
				const qty = toNumber(newItemQty?.value || '0');
				if (newItemUnitPrice) newItemUnitPrice.value = unit ? formatCurrency(unit) : '';
				if (newItemUnitPriceHidden) newItemUnitPriceHidden.value = unit ? unit.toFixed(2) : '';
				const total = unit * (qty || 0);
				if (newItemLineTotal) newItemLineTotal.textContent = 'Line total: ' + formatCurrency(total);
			}

			if (newItemProduct) {
				newItemProduct.addEventListener('change', () => {
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

			// Initialize pricing display if fields already have values
			updatePricingFields();

			// ---- Contact method validation for customer forms ----
			function validateContactMethod(phoneInput, emailInput, errorMessageEl) {
				const phone = (phoneInput?.value || '').trim();
				const email = (emailInput?.value || '').trim();
				const hasError = !phone && !email;

				if (hasError) {
					phoneInput?.classList.add('border-red-500');
					emailInput?.classList.add('border-red-500');
					if (errorMessageEl) {
						errorMessageEl.textContent = 'Please provide at least a phone number or email address.';
						errorMessageEl.classList.remove('hidden');
					}
				} else {
					phoneInput?.classList.remove('border-red-500');
					emailInput?.classList.remove('border-red-500');
					if (errorMessageEl) {
						errorMessageEl.classList.add('hidden');
						errorMessageEl.textContent = '';
					}
				}

				return !hasError;
			}

			// New Customer form validation
			const newCustomerForm = document.getElementById('newCustomerForm');
			if (newCustomerForm) {
				const newPhoneInput = document.getElementById('newCustomerPhone');
				const newEmailInput = document.getElementById('newCustomerEmail');
				const newContactError = document.getElementById('newCustomerContactError');

				newCustomerForm.addEventListener('submit', function(e) {
					if (!validateContactMethod(newPhoneInput, newEmailInput, newContactError)) {
						e.preventDefault();
						return false;
					}
				});

				// Real-time validation as user types
				newPhoneInput?.addEventListener('blur', () => validateContactMethod(newPhoneInput, newEmailInput, newContactError));
				newEmailInput?.addEventListener('blur', () => validateContactMethod(newPhoneInput, newEmailInput, newContactError));
			}

			// Edit Customer form validation (for each customer)
			const editCustomerForms = document.querySelectorAll('.editCustomerForm');
			editCustomerForms.forEach(form => {
				const phoneInput = form.querySelector('.editCustomerPhone');
				const emailInput = form.querySelector('.editCustomerEmail');
				const contactError = form.querySelector('.editCustomerContactError');

				form.addEventListener('submit', function(e) {
					if (!validateContactMethod(phoneInput, emailInput, contactError)) {
						e.preventDefault();
						return false;
					}
				});

				// Real-time validation as user types
				phoneInput?.addEventListener('blur', () => validateContactMethod(phoneInput, emailInput, contactError));
				emailInput?.addEventListener('blur', () => validateContactMethod(phoneInput, emailInput, contactError));
			});

			// default: sales tab
			setMode('sales');
		})();

		// Export Dropdown Toggle
		const exportButton = document.getElementById('exportButton');
		const exportDropdown = document.getElementById('exportDropdown');

		if (exportButton && exportDropdown) {
			exportButton.addEventListener('click', function(e) {
				e.stopPropagation();
				const isHidden = exportDropdown.classList.contains('hidden');
				
				if (isHidden) {
					// Position the dropdown below the button
					const rect = exportButton.getBoundingClientRect();
					exportDropdown.style.top = (rect.bottom + 8) + 'px';
					exportDropdown.style.right = (window.innerWidth - rect.right) + 'px';
					exportDropdown.classList.remove('hidden');
				} else {
					exportDropdown.classList.add('hidden');
				}
			});

			// Close dropdown when clicking outside
			document.addEventListener('click', function(e) {
				if (!exportButton.contains(e.target) && !exportDropdown.contains(e.target)) {
					exportDropdown.classList.add('hidden');
				}
			});
		}

		// Export Functions
		function exportReceipt(event) {
			event.preventDefault();
			exportDropdown.classList.add('hidden');
			
			// Get the selected order from the table (if any row is highlighted/selected)
			const selectedRow = document.querySelector('tr.data-row.selected-row');
			
			if (!selectedRow) {
				alert('Please select an order by clicking on a row in the table to export as receipt.');
				return;
			}
			
			// Extract order number from the selected row
			const orderNumber = selectedRow.querySelector('td:first-child').textContent.trim();
			
			// Open receipt in new tab
			window.open(`/sales/receipt/${orderNumber}`, '_blank');
		}

		function exportSalesReport(event) {
			event.preventDefault();
			exportDropdown.classList.add('hidden');
			// Implement sales report export (CSV/PDF)
			window.location.href = '/sales/export/report';
		}

		function exportCustomerList(event) {
			event.preventDefault();
			exportDropdown.classList.add('hidden');
			// Implement customer list export (CSV/Excel)
			window.location.href = '/customers/export';
		}

		// Add row selection functionality
		document.addEventListener('DOMContentLoaded', function() {
			const salesTbody = document.getElementById('salesTbody');
			
			if (salesTbody) {
				// Add click event to all data rows
				salesTbody.addEventListener('click', function(e) {
					const row = e.target.closest('tr.data-row');
					
					// Ignore clicks on action buttons
					if (e.target.closest('button') || e.target.closest('form')) {
						return;
					}
					
					if (row) {
						// Remove selection from all rows
						const allRows = salesTbody.querySelectorAll('tr.data-row');
						allRows.forEach(r => r.classList.remove('selected-row'));
						
						// Add selection to clicked row
						row.classList.add('selected-row');
					}
				});
			}
		});
	</script>
		</div>
@endsection