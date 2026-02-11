@extends('layouts.system')

@section('main-content')
<style>
	.selected-row {
		background-color: #1e40af !important;
		color: white !important;
		border-left: 4px solid #f59e0b !important;
		box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15) !important;
	}

	/* New Dimmer Hover Effect */
	.data-row {
		cursor: pointer;
		transition: all 0.2s ease-in-out;
	}

	.data-row:hover {
		background-color: rgba(0, 0, 0, 0.2) !important;
		/* Dims the row */
		filter: brightness(1.1);
		/* Slightly pops the text */
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
	<div class="bg-amber-50 p-5">
		<div class="flex justify-between items-center">
			<div>
				<h1 class="text-xl font-bold text-gray-800">Sales & Orders</h1>
				<p class="text-base text-gray-600 mt-2">Manage customer orders, sales, and deliveries</p>
			</div>
			<div class="relative">
				<button id="exportButton" class="flex items-center gap-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm text-white transition">
					<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
					</svg>
					<span>Export</span>
					<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
					</svg>
				</button>
				<!-- Export Dropdown -->
				<div id="exportDropdown" class="hidden absolute top-full right-0 mt-2 w-48 bg-white rounded-lg shadow-xl border border-gray-200 z-50">
					<div class="py-1">
						<a href="#" onclick="exportReceipt(event)" class="block px-3 py-1.5 text-xs text-gray-700 hover:bg-gray-100 transition">
							<div class="flex items-center gap-1.5">
								<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
								</svg>
								<span>Receipt</span>
							</div>
						</a>
						<a href="#" onclick="exportSalesReport(event)" class="block px-3 py-1.5 text-xs text-gray-700 hover:bg-gray-100 transition">
							<div class="flex items-center gap-1.5">
								<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
								</svg>
								<span>Sales Report</span>
							</div>
						</a>
						<a href="#" onclick="exportCustomerList(event)" class="block px-3 py-1.5 text-xs text-gray-700 hover:bg-gray-100 transition">
							<div class="flex items-center gap-1.5">
								<svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
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
	<div class="flex-1 p-5 bg-amber-50 overflow-y-auto">
		<!-- Summary Cards Row -->
		<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3 mb-5">
			<!-- Total Revenue Card -->
			<div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl p-3 text-white shadow-xl border border-slate-600 hover:shadow-2xl transition-all duration-300">
				<div class="flex justify-between items-start">
					<div>
						<h3 class="text-xs font-medium text-slate-300 font-semibold uppercase tracking-wide">Total Revenue</h3>
						<p class="text-2xl font-bold mt-2 bg-gradient-to-r from-amber-300 to-amber-100 bg-clip-text text-transparent">₱{{ number_format($salesOrders->sum('total_amount'), 0) }}</p>
						<p class="text-slate-300 text-xs mt-1">All time sales</p>
					</div>
					<div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
						@include('components.icons.package', ['class' => 'w-5 h-5 text-amber-400'])
					</div>
				</div>
			</div>

			<!-- Payments Received Card -->
			<div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl p-3 text-white shadow-xl border border-slate-600 hover:shadow-2xl transition-all duration-300">
				<div class="flex justify-between items-start">
					<div>
						<h3 class="text-xs font-medium text-slate-300 font-semibold uppercase tracking-wide">Payments Received</h3>
						<p class="text-2xl font-bold mt-2 bg-gradient-to-r from-green-300 to-green-100 bg-clip-text text-transparent">₱{{ number_format($salesOrders->where('payment_status', 'Paid')->sum('total_amount'), 0) }}</p>
						<p class="text-slate-300 text-xs mt-1">Paid orders</p>
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
						<p class="text-2xl font-bold mt-2 bg-gradient-to-r from-yellow-300 to-yellow-100 bg-clip-text text-transparent">₱{{ number_format($salesOrders->whereIn('payment_status', ['Pending', 'Partial'])->sum('total_amount'), 0) }}</p>
						<p class="text-slate-300 text-xs mt-1">Outstanding amount</p>
					</div>
					<div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
						@include('components.icons.dollar', ['class' => 'w-5 h-5 text-yellow-400'])
					</div>
				</div>
			</div>

			<!-- Active Orders Card -->
			<div class="bg-gradient-to-br from-slate-700 to-slate-800 rounded-xl p-3 text-white shadow-xl border border-slate-600 hover:shadow-2xl transition-all duration-300">
				<div class="flex justify-between items-start">
					<div>
						<h3 class="text-xs font-medium text-slate-300 font-semibold uppercase tracking-wide">Active Orders</h3>
						<p class="text-2xl font-bold mt-2 bg-gradient-to-r from-blue-300 to-blue-100 bg-clip-text text-transparent">{{ $salesOrders->whereIn('status', ['Pending', 'In production', 'Ready'])->count() }}</p>
						<p class="text-slate-300 text-xs mt-1">Orders in progress</p>
					</div>
					<div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
						@include('components.icons.cart', ['class' => 'w-5 h-5 text-blue-400'])
					</div>
				</div>
			</div>
		</div>

		<!-- Sales Management Card -->
		<section class="bg-gradient-to-br from-slate-700 to-slate-800 text-white p-3 rounded-xl overflow-visible shadow-xl border border-slate-600">
			<header class="flex justify-between items-center mb-6">
				<div>
					<h2 class="text-xl font-bold text-white">Sales Management</h2>
					<p class="text-slate-300 text-xs font-medium mt-2">Manage customer orders and track sales performance</p>
				</div>
				<button id="headerBtn" class="px-3.5 py-1.5 bg-gradient-to-r from-amber-500 to-orange-600 text-white rounded-xl hover:from-amber-600 hover:to-orange-700 transition-all shadow-lg hover:shadow-xl flex items-center gap-1.5 font-medium" onclick="openModal('newOrderModal')">
					<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
						<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
					</svg>
					<span>New Order</span>
				</button>
			</header>

			<!-- Search + Filters -->
			<div class="flex flex-col md:flex-row justify-between gap-3 mb-6">
				<input type="search" id="searchInput" placeholder="Search order or customers..." class="bg-white w-full md:w-3/4 rounded-full px-3 py-1.5 text-gray-900 focus:outline-none">
				<div class="flex gap-1.5">
					<select id="paymentFilter" class="flex items-center space-x-2 px-3 py-1.5 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
						<option value="">All Payment</option>
						<option value="Pending">Unpaid</option>
						<option value="Partial">Partial</option>
						<option value="Paid">Paid</option>
					</select>
				</div>
			</div>

			<!-- Tabs -->
			<div class="flex space-x-2 w-full mb-6">
				<button id="salesTab" class="flex-1 px-5.5 py-3 rounded-xl border-2 font-bold text-sm transition-all shadow-lg" style="background-color: #FFF1DA; border-color: #FDE68A; color: #111827;">Orders</button>
				<button id="customersTab" class="flex-1 px-5.5 py-3 rounded-xl border-2 font-bold text-sm transition-all shadow-lg" style="background-color: #475569; border-color: #64748b; color: #FFFFFF;">Customers</button>
			</div>

			<!-- Sales Orders Table -->
			<div id="salesTable" class="overflow-y-auto overflow-x-visible" style="max-height: 60vh;">
				<table class="w-full border-collapse text-left text-xs text-white">
					<thead class="bg-slate-800 text-slate-300 sticky top-0">
						<tr>
							<th class="px-3 py-3 font-medium">Order #</th>
							<th class="px-3 py-3 font-medium">Customer</th>
							<th class="px-3 py-3 font-medium">Order Date</th>
							<th class="px-3 py-3 font-medium">Delivery Date</th>
							<th class="px-3 py-3 font-medium">Total Amount</th>
							<th class="px-3 py-3 font-medium">Payment Status</th>
							<th class="px-3 py-3 font-medium">Action</th>
						</tr>
					</thead>
					<tbody id="salesTbody" class="divide-y divide-slate-600">
						@forelse($salesOrders as $order)
						<tr class="hover:bg-slate-600 transition cursor-pointer data-row" data-status="{{ $order->status }}" data-payment="{{ $order->payment_status }}">
							<td class="px-3 py-3 font-mono text-slate-300">{{ $order->order_number }}</td>
							<td class="px-3 py-3">
								<div class="font-medium text-slate-300">{{ $order->customer?->name }}</div>
								@php $ct = $order->customer?->customer_type; $ctBg = $customerTypeBg[$ct] ?? '#e5e7eb'; @endphp
								<span class="mt-1 inline-block text-xs font-semibold text-white px-2 py-0.5 rounded" style="background: {{ $ctBg }};">{{ $ct }}</span>
							</td>
							<td class="px-3 py-3 text-slate-300">{{ \Illuminate\Support\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
							<td class="px-3 py-3 text-slate-300">{{ \Illuminate\Support\Carbon::parse($order->delivery_date)->format('M d, Y') }}</td>
							@php
							$sb = $order->status === 'Pending' ? '#ffffff' : ($statusBg[$order->status] ?? '#e5e7eb');
							$stText = $order->status === 'Pending' ? 'text-gray-900' : 'text-white';
							@endphp
							<td class="px-3 py-3 font-bold text-slate-300">₱{{ number_format($order->total_amount, 2) }}</td>
							@php
							$pb = $paymentBg[$order->payment_status] ?? '#ffffff';
							$ptText = $order->payment_status === 'Pending' ? 'text-gray-900' : 'text-white';
							$pendingBorder = $order->payment_status==='Pending' ? 'border border-gray-300' : '';
							@endphp
							<td class="px-3 py-3">
								@if($order->payment_status === 'Paid')
								<span class="text-xs font-semibold text-green-400">{{ $order->payment_status }}</span>
								@elseif($order->payment_status === 'Partial')
								<span class="text-xs font-semibold text-yellow-400">{{ $order->payment_status }}</span>
								@else
								<span class="text-xs font-semibold text-slate-400">{{ $order->payment_status }}</span>
								@endif
							</td>
							<td class="px-3 py-3">
								<div class="flex space-x-2">
									<button onclick="openModal('viewOrderModal-{{ $order->id }}')" class="p-1 hover:bg-slate-500 rounded" title="View">
										<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
											<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
											<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
										</svg>
									</button>
									<button onclick="openModal('editOrderModal-{{ $order->id }}')" class="p-1 hover:bg-slate-500 rounded" title="Edit">
										<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
											<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
										</svg>
									</button>
									@if(!in_array($order->payment_status, ['Paid', 'Partial']))
									<form action="{{ route('sales-orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Cancel this order?')" class="inline">
										@csrf
										@method('DELETE')
										<button type="submit" class="p-1 hover:bg-slate-500 rounded" title="Delete">
											<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
												<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
											</svg>
										</button>
									</form>
									@endif
								</div>
							</td>
						</tr>

						<!-- View Order Modal -->
						<div id="viewOrderModal-{{ $order->id }}" class="fixed inset-0 bg-black/70 hidden overflow-y-auto" style="z-index: 99999;">
							<div class="rounded-lg shadow-2xl max-w-4xl w-[95%] mx-auto my-8 p-5" style="background-color: #FFF1DA;">
								<!-- Header -->
								<div class="flex items-center justify-between mb-5 border-b-2 pb-6" style="border-color: #374151;">
									<div>
										<h3 class="text-xl font-bold" style="color: #374151;">Order #{{ $order->order_number }}</h3>
										<p class="mt-1" style="color: #666;">{{ $order->customer?->name }}</p>
									</div>
									<button class="text-xl transition" style="color: #999;" onclick="closeModal('viewOrderModal-{{ $order->id }}')">✕</button>
								</div>

								<!-- Order Information Cards -->
								<div class="grid grid-cols-2 md:grid-cols-4 gap-3 mb-5">
									<div class="p-3 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
										<p class="text-xs font-semibold" style="color: #374151;">Customer Type</p>
										<p class="text-base font-bold mt-2" style="color: {{ $customerTypeBg[$order->customer?->customer_type] ?? '#374151' }};">{{ $order->customer?->customer_type }}</p>
									</div>
									<div class="p-3 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
										<p class="text-xs font-semibold" style="color: #374151;">Order Date</p>
										<p class="text-base font-bold mt-2" style="color: #374151;">{{ \Illuminate\Support\Carbon::parse($order->order_date)->format('M d, Y') }}</p>
									</div>
									<div class="p-3 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
										<p class="text-xs font-semibold" style="color: #374151;">Delivery Date</p>
										<p class="text-base font-bold mt-2" style="color: #374151;">{{ \Illuminate\Support\Carbon::parse($order->delivery_date)->format('M d, Y') }}</p>
									</div>
									<div class="p-3 rounded-lg border-l-4" style="background-color: rgba(255,255,255,0.7); border-left-color: #374151;">
										<p class="text-xs font-semibold" style="color: #374151;">Status</p>
										<p class="text-base font-bold mt-2 px-2 py-1 rounded text-white text-center" style="background: {{ $statusBg[$order->status] ?? '#e5e7eb' }};">{{ $order->status }}</p>
									</div>
								</div>

								<!-- Payment Information -->
								<div class="grid grid-cols-2 md:grid-cols-3 gap-3 mb-5">
									<div class="p-3 rounded-lg border" style="background-color: rgba(255,255,255,0.7); border-color: #374151;">
										<p class="text-xs font-semibold" style="color: #374151;">Payment Status</p>
										<p class="text-base font-bold mt-2 
														@if($order->payment_status === 'Paid') text-green-600
														@elseif($order->payment_status === 'Partial') text-orange-600
														@else
														@endif" style="@if($order->payment_status !== 'Paid' && $order->payment_status !== 'Partial')color: #374151;@endif">
											{{ $order->payment_status }}
										</p>
									</div>
									<div class="p-3 rounded-lg border md:col-span-2" style="background-color: rgba(255,255,255,0.7); border-color: #374151;">
										<p class="text-xs font-semibold" style="color: #374151;">Total Amount</p>
										<p class="text-xl font-bold mt-2" style="color: #374151;">₱{{ number_format($order->total_amount, 2) }}</p>
									</div>
								</div>

								<!-- Products Ordered -->
								<div class="mb-5">
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
													<h5 class="font-bold text-base" style="color: #374151;">{{ $item->product?->product_name ?? 'Unknown Product' }}</h5>
													<p class="text-xs mt-1" style="color: #666;">Unit Price: <span class="font-semibold" style="color: #374151;">₱{{ number_format($item->unit_price, 2) }}</span></p>
												</div>
												<div class="text-right">
													<div class="inline-block px-3 py-1.5 rounded-full font-bold text-base" style="background-color: #374151; color: #FFF1DA;">
														{{ $item->quantity }} <span class="text-xs">pcs</span>
													</div>
												</div>
											</div>
											<div class="mt-3 pt-3 flex justify-between items-center" style="border-top: 1px solid #E8D5BF; color: #666;">
												<span class="text-xs">Line Total:</span>
												<span class="font-bold text-base" style="color: #374151;">₱{{ number_format($item->quantity * $item->unit_price, 2) }}</span>
											</div>
										</div>
										@endforeach
									</div>
									<!-- Order Summary -->
									<div class="mt-6 p-5 rounded-lg border-2 flex justify-between items-center" style="background-color: rgba(55,65,81,0.1); border-color: #374151;">
										<span class="text-base font-bold" style="color: #374151;">Order Total:</span>
										<span class="text-xl font-bold" style="color: #374151;">₱{{ number_format($order->total_amount, 2) }}</span>
									</div>
									@else
									<div class="p-3 rounded-lg border text-center" style="background-color: rgba(255,255,255,0.7); border-color: #374151; color: #999;">
										No products in this order
									</div>
									@endif
								</div>

								<!-- Notes Section -->
								@if($order->note)
								<div class="p-3 rounded-lg border-l-4 mb-5" style="background-color: rgba(255,255,255,0.85); border-left-color: #374151;">
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
							<div class="bg-white text-gray-900 rounded shadow max-w-lg w-full mx-auto mt-24 p-3">
								<div class="flex items-center justify-between mb-4">
									<h3 class="font-semibold">Edit Order {{ $order->order_number }}</h3>
									<button onclick="closeModal('editOrderModal-{{ $order->id }}')">✕</button>
								</div>
								<form method="POST" action="{{ route('sales-orders.update', $order) }}">
									@csrf
									@method('PUT')
									<div class="grid gap-3">
										<div>
											<label class="text-xs">Customer</label>
											<select name="customer_id" class="w-full border rounded px-2 py-1">
												@foreach($customers as $c)
												<option value="{{ $c->id }}" @selected($order->customer_id==$c->id)>{{ $c->name }} ({{ $c->customer_type }})</option>
												@endforeach
											</select>
										</div>
										<div>
											<label class="text-xs">Delivery Date</label>
											<input type="date" name="delivery_date" value="{{ $order->delivery_date }}" class="w-full border rounded px-2 py-1">
										</div>
										<div class="grid grid-cols-2 gap-3">


										</div>
										<div>
											<label class="text-xs">Notes</label>
											<textarea name="note" class="w-full border rounded px-2 py-1" rows="3">{{ $order->note }}</textarea>
										</div>
										<div class="flex justify-end gap-1.5">
											<button type="button" class="px-3 py-1.5 border rounded" onclick="closeModal('editOrderModal-{{ $order->id }}')">Cancel</button>
											<button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded">Save</button>
										</div>
								</form>
							</div>
						</div>

						@empty
						<tr>
							<td colspan="8" class="text-center py-4">No orders yet. Click "New Order" to create one.</td>
						</tr>
						@endforelse
						<tr id="salesNoMatch" class="hidden">
							<td colspan="8" class="text-center py-4">No matches</td>
						</tr>
					</tbody>
				</table>
			</div>

			<!-- Customers Table -->
			<div id="customerTable" class="hidden overflow-y-auto overflow-x-visible" style="max-height: 60vh;">
				<table class="w-full border-collapse text-left text-xs text-white">
					<thead class="bg-slate-800 text-slate-300 sticky top-0">
						<tr>
							<th class="px-3 py-3 font-medium">Name</th>
							<th class="px-3 py-3 font-medium">Type</th>
							<th class="px-3 py-3 font-medium">Contact</th>
							<th class="px-3 py-3 font-medium">Email</th>
							<th class="px-3 py-3 font-medium">Total Orders</th>
							<th class="px-3 py-3 font-medium">Total Spent</th>
							<th class="px-3 py-3 font-medium">Action</th>
						</tr>
					</thead>
					<tbody id="customersTbody" class="divide-y divide-slate-600">
						@forelse($customers as $customer)
						<tr class="hover:bg-slate-600 transition cursor-pointer data-row">
							<td class="px-3 py-3">
								<div class="font-medium text-slate-300">{{ $customer->name }}</div>
								@php $ctBg = $customerTypeBg[$customer->customer_type] ?? '#e5e7eb'; @endphp
								<span class="mt-1 inline-block text-xs font-semibold text-white px-2 py-0.5 rounded" style="background: {{ $ctBg }};">{{ $customer->customer_type }}</span>
							</td>
							<td class="px-3 py-3">
								<span class="inline-block text-xs font-semibold text-white px-2 py-0.5 rounded" style="background: {{ $ctBg }};">{{ $customer->customer_type }}</span>
							</td>
							<td class="px-3 py-3 text-slate-300">{{ $customer->phone }}</td>
							<td class="px-3 py-3 text-slate-300">{{ $customer->email }}</td>
							<td class="px-3 py-3 text-slate-300">{{ $customer->totalOrders() }}</td>
							<td class="px-3 py-3 font-bold text-slate-300">₱{{ number_format($customer->totalSpent(), 2) }}</td>
							<td class="px-3 py-3">
								<div class="flex space-x-2">
									<button onclick="openModal('viewCustomerModal-{{ $customer->id }}')" class="p-1 hover:bg-slate-500 rounded" title="View">
										<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
											<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
											<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
										</svg>
									</button>
									<button onclick="openModal('editCustomerModal-{{ $customer->id }}')" class="p-1 hover:bg-slate-500 rounded" title="Edit">
										<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
											<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
										</svg>
									</button>
									<form action="{{ route('customers.delete', $customer) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this customer?')" class="inline">
										@csrf
										@method('DELETE')
										<button type="submit" class="p-1 hover:bg-slate-500 rounded" title="Delete">
											<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
												<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
											</svg>
										</button>
									</form>
								</div>
								<!-- View Customer Modal -->
								<div id="viewCustomerModal-{{ $customer->id }}" class="fixed inset-0 bg-black/70 hidden" style="z-index: 99999;">
									<div class="bg-white text-gray-900 rounded-lg shadow-xl max-w-4xl w-[92%] mx-auto mt-16 p-3 max-h-[90vh] overflow-y-auto">
										<div class="flex items-center justify-between mb-4">
											<h3 class="text-xl font-bold">Customer Details</h3>
											<button class="text-xl" onclick="closeModal('viewCustomerModal-{{ $customer->id }}')">✕</button>
										</div>
										<div class="grid grid-cols-1 md:grid-cols-2 gap-3 text-base leading-relaxed mb-6">
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
												<table class="w-full text-xs border-collapse">
													<thead>
														<tr class="bg-slate-100 border-b">
															<th class="px-3 py-1.5 text-left font-semibold">Product Name</th>
															<th class="px-3 py-1.5 text-right font-semibold">Total Quantity</th>
														</tr>
													</thead>
													<tbody>
														@foreach($productsSummary as $productName => $totalQty)
														<tr class="border-b hover:bg-slate-600 transition cursor-pointer">
															<td class="px-3 py-1.5">{{ $productName }}</td>
															<td class="px-3 py-1.5 text-right font-medium">{{ $totalQty }} pcs</td>
														</tr>
														@endforeach
													</tbody>
												</table>
											</div>
											@else
											<p class="text-slate-500 text-xs">No products purchased yet</p>
											@endif
										</div>

										<div class="flex justify-end mt-6">
											<button class="px-3 py-1.5 bg-gray-900 text-white rounded" onclick="closeModal('viewCustomerModal-{{ $customer->id }}')">Close</button>
										</div>
									</div>
								</div>

								<!-- Edit Customer Modal -->
								<div id="editCustomerModal-{{ $customer->id }}" class="fixed inset-0 bg-black/50 hidden" style="z-index: 99999;">
									<div class="bg-white text-gray-900 rounded shadow max-w-lg w-full mx-auto mt-24 p-3 max-h-[90vh] overflow-y-auto">
										<div class="flex items-center justify-between mb-4">
											<h3 class="font-semibold">Edit Customer</h3>
											<button onclick="closeModal('editCustomerModal-{{ $customer->id }}')">✕</button>
										</div>
										@if ($errors->any())
										<div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
											<ul class="list-disc list-inside text-xs">
												@foreach ($errors->all() as $error)
												<li>{{ $error }}</li>
												@endforeach
											</ul>
										</div>
										@endif
										<form method="POST" action="{{ route('customers.update', $customer) }}" class="editCustomerForm">
											@csrf
											@method('PUT')
											<div class="grid gap-3">
												<div>
													<label class="text-xs">Name <span class="text-red-500">*</span></label>
													<input type="text" name="name" value="{{ old('name', $customer->name) }}" class="w-full border rounded px-2 py-1 @error('name') border-red-500 @enderror" required minlength="2" maxlength="255" pattern="[a-zA-Z\s'-]+" title="Name must contain only letters, spaces, hyphens, and apostrophes">
													@error('name')
													<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
													@else
													<p class="text-gray-400 text-xs mt-1">This field is required. Enter customer name.</p>
													@enderror
												</div>
												<div class="grid grid-cols-2 gap-3">
													<div>
														<label class="text-xs">Type <span class="text-red-500">*</span></label>
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
														<label class="text-xs">Phone <span class="text-orange-500">**</span></label>
														<input type="tel" name="phone" class="editCustomerPhone w-full border rounded px-2 py-1 @error('phone') border-red-500 @enderror @error('contact') border-red-500 @enderror" value="{{ old('phone', $customer->phone) }}" placeholder="09XXXXXXXXX" maxlength="12" pattern="[0-9]{0,12}" title="Phone must be up to 12 digits">
														@error('phone')
														<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
														@else
														<p class="text-gray-400 text-xs mt-1">Enter a phone number (up to 12 digits) or email below.</p>
														@enderror
													</div>
												</div>
												<div>
													<label class="text-xs">Email <span class="text-orange-500">**</span></label>
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
												<div class="flex justify-end gap-1.5">
													<button type="button" class="px-3 py-1.5 border rounded" onclick="closeModal('editCustomerModal-{{ $customer->id }}')">Cancel</button>
													<button type="submit" class="px-3 py-1.5 bg-blue-600 text-white rounded">Save</button>
												</div>
										</form>
									</div>
								</div>
								@empty
						<tr>
							<td colspan="7" class="text-center py-4">No customers yet. Click "New Customer" to add one.</td>
						</tr>
						@endforelse
						<tr id="customersNoMatch" class="hidden">
							<td colspan="7" class="text-center py-4">No matches</td>
						</tr>
					</tbody>
				</table>
			</div>
		</section>

		<!-- New Order Modal - IMPROVED VERSION -->
		<div id="newOrderModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50">
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
									Create New Order
								</h3>
								<p class="text-slate-300 text-xs mt-1">Add a new sales order for a customer</p>
							</div>
							<button onclick="closeModal('newOrderModal')" class="text-white hover:text-slate-300 hover:bg-white/10 rounded-xl p-2 transition-all">
								<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
						<form method="POST" action="{{ route('sales-orders.store') }}" id="newOrderForm" onsubmit="return confirmSalesOrder(event)">
							@csrf
							<div class="space-y-5">
								<!-- Customer Selection -->
								<div>
									<label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
										<svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
										</svg>
										Customer <span class="text-red-500">*</span>
									</label>
									<select name="customer_id" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('customer_id') border-red-500 @enderror" required>
										<option value="">-- Select Customer --</option>
										@foreach($customers as $c)
										<option value="{{ $c->id }}" {{ old('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->name }} ({{ $c->customer_type }})</option>
										@endforeach
									</select>
									@error('customer_id')
									<p class="text-red-500 text-xs mt-2 flex items-center gap-1">
										<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
										</svg>
										{{ $message }}
									</p>
									@enderror
								</div>

								<!-- Delivery Date -->
								<div>
									<label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
										<svg class="w-3.5 h-3.5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
										</svg>
										Delivery Date <span class="text-red-500">*</span>
									</label>
									<input type="date" name="delivery_date" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('delivery_date') border-red-500 @enderror" value="{{ old('delivery_date') }}" required>
									@error('delivery_date')
									<p class="text-red-500 text-xs mt-2 flex items-center gap-1">
										<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
										</svg>
										{{ $message }}
									</p>
									@enderror
								</div>

								<!-- Product Selection Section -->
								<div class="pt-4 border-t-2 border-gray-300">
									<h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-1.5">
										<span class="w-1 h-6 bg-amber-500 rounded"></span>
										Order Items
									</h4>

									<div class="bg-white rounded-xl border-2 border-slate-300 p-5 shadow-lg">
										<div class="grid grid-cols-1 md:grid-cols-3 gap-3">
											<!-- Product Selection -->
											<div>
												<label class="block text-xs font-bold text-slate-700 mb-2 flex items-center gap-1">
													<svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
														<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
													</svg>
													Product <span class="text-red-500">*</span>
												</label>
												<select id="newItemProduct" name="items[0][product_id]" class="w-full border-2 border-gray-300 rounded-lg px-3 py-1.5 text-base focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all @error('items.0.product_id') border-red-500 @enderror" required>
													<option value="">-- Select Product --</option>
													@foreach($products as $p)
													<option value="{{ $p->id }}" data-price="{{ number_format($p->selling_price,2,'.','') }}" data-max="{{ $p->max_producible ?? '' }}">{{ $p->product_name }}</option>
													@endforeach
												</select>
												@error('items.0.product_id')
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
												<input id="newItemQty" type="number" min="1" name="items[0][quantity]" class="w-full border-2 border-gray-300 rounded-lg px-3 py-1.5 text-base font-bold focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all @error('items.0.quantity') border-red-500 @enderror" placeholder="1" value="{{ old('items.0.quantity') }}" required>
												@error('items.0.quantity')
												<p class="text-red-500 text-xs mt-1">{{ $message }}</p>
												@enderror
												<p id="newItemQtyError" class="text-red-500 text-xs mt-1 hidden"></p>
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
										<span class="font-semibold">Required fields:</span> Customer, Delivery Date, Product
									</div>
									<div class="flex space-x-3">
										<button type="button" class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-bold text-base hover:bg-gray-100 transition-all shadow-sm" onclick="closeModal('newOrderModal')">
											Cancel
										</button>
										<button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold text-base rounded-xl hover:from-amber-600 hover:to-orange-700 shadow-lg hover:shadow-xl transition-all flex items-center gap-1.5">
											<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
											</svg>
											Create Order
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>

		<!-- Add New Customer Modal -->
		<div id="newCustomerModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50">
			<div class="flex items-center justify-center min-h-screen p-3">
				<div class="bg-amber-50 rounded-xl max-w-2xl w-full max-h-[90vh] overflow-y-auto shadow-2xl border-2 border-slate-700">
					<!-- Header -->
					<div class="sticky top-0 bg-gradient-to-r from-slate-700 to-slate-800 p-3 text-white rounded-t-2xl z-10">
						<div class="flex justify-between items-center">
							<div>
								<h3 class="text-xl font-bold flex items-center gap-1.5">
									<svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
									</svg>
									Add New Customer
								</h3>
								<p class="text-slate-300 text-xs mt-1">Register a new customer to the system</p>
							</div>
							<button onclick="closeModal('newCustomerModal')" class="text-white hover:text-slate-300 hover:bg-white/10 rounded-xl p-2 transition-all">
								<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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
						<form method="POST" action="{{ route('customers.store') }}" id="newCustomerForm" onsubmit="return confirmCustomer(event)">
							@csrf
							<div class="space-y-5">
								<!-- Basic Information Section -->
								<div>
									<h4 class="text-xl font-bold text-gray-900 mb-4 flex items-center gap-1.5">
										<span class="w-1 h-6 bg-amber-500 rounded"></span>
										Basic Information
									</h4>

									<div class="space-y-4">
										<!-- Customer Name -->
										<div>
											<label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
													<path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z" clip-rule="evenodd" />
												</svg>
												Customer Name <span class="text-red-500 text-base">*</span>
											</label>
											<input type="text" name="name" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm @error('name') border-red-500 @enderror" value="{{ old('name') }}" required minlength="2" maxlength="255" pattern="[a-zA-Z\s'-]+" title="Name must contain only letters, spaces, hyphens, and apostrophes" placeholder="Enter full name (e.g., Juan Dela Cruz)">
											@error('name')
											<p class="text-red-500 text-xs mt-2 flex items-center gap-1">
												<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
													<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
												</svg>
												{{ $message }}
											</p>
											@else
											<p class="text-gray-500 text-xs mt-2">Enter customer's full name (letters, spaces, hyphens, and apostrophes only)</p>
											@enderror
										</div>

										<!-- Customer Type -->
										<div>
											<label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
													<path d="M13 6a3 3 0 11-6 0 3 3 0 016 0zM18 8a2 2 0 11-4 0 2 2 0 014 0zM14 15a4 4 0 00-8 0v3h8v-3zM6 8a2 2 0 11-4 0 2 2 0 014 0zM16 18v-3a5.972 5.972 0 00-.75-2.906A3.005 3.005 0 0119 15v3h-3zM4.75 12.094A5.973 5.973 0 004 15v3H1v-3a3 3 0 013.75-2.906z" />
												</svg>
												Customer Type <span class="text-red-500 text-base">*</span>
											</label>
											<div class="grid grid-cols-3 gap-3">
												@foreach(['Retail','Contractor','Wholesale'] as $index => $t)
												<label class="relative flex flex-col items-center justify-center p-3 border-2 rounded-xl cursor-pointer transition-all hover:border-amber-500 hover:bg-amber-50 @error('customer_type') border-red-500 @else border-gray-300 @enderror">
													<input type="radio" name="customer_type" value="{{ $t }}" class="peer sr-only" {{ old('customer_type') === $t ? 'checked' : '' }} required>
													<div class="peer-checked:bg-gradient-to-r peer-checked:from-amber-500 peer-checked:to-orange-600 peer-checked:text-white absolute inset-0 rounded-xl opacity-0 peer-checked:opacity-100 transition-opacity"></div>
													<div class="relative z-10 flex flex-col items-center">
														@if($t === 'Retail')
														<svg class="w-8 h-8 mb-2 peer-checked:text-white text-amber-600" fill="currentColor" viewBox="0 0 20 20">
															<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
														</svg>
														@elseif($t === 'Contractor')
														<svg class="w-8 h-8 mb-2 peer-checked:text-white text-amber-600" fill="currentColor" viewBox="0 0 20 20">
															<path fill-rule="evenodd" d="M6 6V5a3 3 0 013-3h2a3 3 0 013 3v1h2a2 2 0 012 2v3.57A22.952 22.952 0 0110 13a22.95 22.95 0 01-8-1.43V8a2 2 0 012-2h2zm2-1a1 1 0 011-1h2a1 1 0 011 1v1H8V5zm1 5a1 1 0 011-1h.01a1 1 0 110 2H10a1 1 0 01-1-1z" clip-rule="evenodd" />
															<path d="M2 13.692V16a2 2 0 002 2h12a2 2 0 002-2v-2.308A24.974 24.974 0 0110 15c-2.796 0-5.487-.46-8-1.308z" />
														</svg>
														@else
														<svg class="w-8 h-8 mb-2 peer-checked:text-white text-amber-600" fill="currentColor" viewBox="0 0 20 20">
															<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z" />
														</svg>
														@endif
														<span class="font-bold text-xs peer-checked:text-white text-gray-900">{{ $t }}</span>
													</div>
												</label>
												@endforeach
											</div>
											@error('customer_type')
											<p class="text-red-500 text-xs mt-2 flex items-center gap-1">
												<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
													<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
												</svg>
												{{ $message }}
											</p>
											@else
											<p class="text-gray-500 text-xs mt-2">Select the customer's business type</p>
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

									<!-- Important Notice -->
									<div class="bg-gradient-to-r from-orange-50 to-amber-50 border-2 border-orange-400 rounded-xl p-3 mb-4 shadow-lg">
										<div class="flex items-start gap-3">
											<svg class="w-6 h-6 text-orange-600 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
												<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd" />
											</svg>
											<div>
												<p class="text-orange-900 text-xs font-bold mb-1">Contact Requirement</p>
												<p class="text-orange-800 text-xs">At least <span class="font-bold">one contact method</span> (phone number <span class="font-bold">OR</span> email address) is required</p>
											</div>
										</div>
									</div>

									<div class="grid grid-cols-1 md:grid-cols-2 gap-3">
										<!-- Phone Number -->
										<div class="bg-white rounded-xl border-2 border-gray-300 p-3 shadow-sm transition-all focus-within:border-amber-500 focus-within:shadow-lg @error('phone') border-red-500 @enderror @error('contact') border-red-500 @enderror">
											<label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
													<path d="M2 3a1 1 0 011-1h2.153a1 1 0 01.986.836l.74 4.435a1 1 0 01-.54 1.06l-1.548.773a11.037 11.037 0 006.105 6.105l.774-1.548a1 1 0 011.059-.54l4.435.74a1 1 0 01.836.986V17a1 1 0 01-1 1h-2C7.82 18 2 12.18 2 5V3z" />
												</svg>
												Phone Number
												<span class="text-orange-500 text-xs font-bold ml-1">**</span>
											</label>
											<input type="tel" name="phone" id="newCustomerPhone" class="w-full border-2 border-gray-200 rounded-lg px-3 py-1.5 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all" value="{{ old('phone') }}" placeholder="09XXXXXXXXX" maxlength="12" pattern="[0-9]{0,12}" title="Phone must be up to 12 digits">
											@error('phone')
											<p class="text-red-500 text-xs mt-2 flex items-center gap-1">
												<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
													<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
												</svg>
												{{ $message }}
											</p>
											@else
											<p class="text-gray-500 text-xs mt-2">Up to 12 digits</p>
											@enderror
										</div>

										<!-- Email Address -->
										<div class="bg-white rounded-xl border-2 border-gray-300 p-3 shadow-sm transition-all focus-within:border-amber-500 focus-within:shadow-lg @error('email') border-red-500 @enderror @error('contact') border-red-500 @enderror">
											<label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
												<svg class="w-3.5 h-3.5 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
													<path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
													<path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
												</svg>
												Email Address
												<span class="text-orange-500 text-xs font-bold ml-1">**</span>
											</label>
											<input type="email" name="email" id="newCustomerEmail" class="w-full border-2 border-gray-200 rounded-lg px-3 py-1.5 text-base font-medium focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all" value="{{ old('email') }}" maxlength="255" title="Please enter a valid email address" placeholder="customer@example.com">
											@error('email')
											<p class="text-red-500 text-xs mt-2 flex items-center gap-1">
												<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
													<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
												</svg>
												{{ $message }}
											</p>
											@enderror
											@error('contact')
											<p class="text-red-500 text-xs mt-2 flex items-center gap-1">
												<svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
													<path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
												</svg>
												{{ $message }}
											</p>
											@else
											<p class="text-gray-500 text-xs mt-2">Valid email format</p>
											@enderror
										</div>
									</div>

									<!-- Contact Error Message -->
									<div id="newCustomerContactError" class="mt-3 p-3 bg-red-50 border-2 border-red-400 rounded-xl hidden">
										<p class="text-red-600 text-xs font-bold flex items-center gap-1.5">
											<svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20">
												<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
											</svg>
											Please provide at least one contact method (phone or email)
										</p>
									</div>
								</div>

								<!-- Optional Address Section -->
								<div class="pt-4 border-t-2 border-gray-300">
									<label class="block text-base font-bold text-gray-900 mb-3 flex items-center gap-1.5">
										<svg class="w-3.5 h-3.5 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M5.05 4.05a7 7 0 119.9 9.9L10 18.9l-4.95-4.95a7 7 0 010-9.9zM10 11a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd" />
										</svg>
										Address (Optional)
									</label>
									<textarea name="address" rows="3" class="w-full border-2 border-gray-300 rounded-xl px-3 py-3 text-base focus:ring-2 focus:ring-amber-500 focus:border-amber-500 transition-all bg-white shadow-sm" placeholder="Enter customer's full address (Street, Barangay, City, Province)">{{ old('address') }}</textarea>
									<p class="text-gray-500 text-xs mt-2">Complete address helps with deliveries and record keeping</p>
								</div>

								<!-- Action Buttons -->
								<div class="flex justify-between items-center pt-4 border-t-2 border-gray-300">
									<div class="flex items-center gap-3 text-xs">
										<div class="flex items-center gap-1">
											<span class="text-red-500 font-bold text-base">*</span>
											<span class="text-gray-600">Required</span>
										</div>
										<div class="flex items-center gap-1">
											<span class="text-orange-500 font-bold">**</span>
											<span class="text-gray-600">One required</span>
										</div>
									</div>
									<div class="flex space-x-3">
										<button type="button" class="px-6 py-3 border-2 border-gray-300 rounded-xl text-gray-700 font-bold text-base hover:bg-gray-100 transition-all shadow-sm" onclick="closeModal('newCustomerModal')">
											Cancel
										</button>
										<button type="submit" class="px-6 py-3 bg-gradient-to-r from-amber-500 to-orange-600 text-white font-bold text-base rounded-xl hover:from-amber-600 hover:to-orange-700 shadow-lg hover:shadow-xl transition-all flex items-center gap-1.5">
											<svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
											</svg>
											Add Customer
										</button>
									</div>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
</div>

<!-- Confirmation Modal for Sales Order -->
<div id="confirmSalesOrderModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50 flex items-center justify-center">
	<div class="bg-white rounded-2xl max-w-md w-full shadow-2xl transform transition-all">
		<!-- Green Header -->
		<div class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 rounded-t-2xl">
			<div class="flex items-center gap-3">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
				</svg>
				<h3 class="text-xl font-bold">Confirm Sales Order</h3>
			</div>
		</div>
		
		<!-- Content -->
		<div class="p-6">
			<p class="text-gray-700 text-base mb-6">Are you sure you want to create this sales order?</p>
			
			<!-- Action Buttons -->
			<div class="flex gap-3 justify-end">
				<button type="button" onclick="closeConfirmSalesOrder()" class="px-5 py-2.5 border-2 border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition-all">
					Cancel
				</button>
				<button type="button" onclick="submitSalesOrder()" class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transition-all shadow-lg">
					Confirm
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Confirmation Modal for Customer -->
<div id="confirmCustomerModal" class="fixed inset-0 bg-black bg-opacity-60 backdrop-blur-sm hidden z-50 flex items-center justify-center">
	<div class="bg-white rounded-2xl max-w-md w-full shadow-2xl transform transition-all">
		<!-- Green Header -->
		<div class="bg-gradient-to-r from-green-600 to-green-700 text-white px-6 py-4 rounded-t-2xl">
			<div class="flex items-center gap-3">
				<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
					<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
				</svg>
				<h3 class="text-xl font-bold">Confirm New Customer</h3>
			</div>
		</div>
		
		<!-- Content -->
		<div class="p-6">
			<p class="text-gray-700 text-base mb-6">Are you sure you want to add this customer?</p>
			
			<!-- Action Buttons -->
			<div class="flex gap-3 justify-end">
				<button type="button" onclick="closeConfirmCustomer()" class="px-5 py-2.5 border-2 border-gray-300 rounded-lg text-gray-700 font-semibold hover:bg-gray-100 transition-all">
					Cancel
				</button>
				<button type="button" onclick="submitCustomer()" class="px-5 py-2.5 bg-gradient-to-r from-green-600 to-green-700 text-white rounded-lg font-semibold hover:from-green-700 hover:to-green-800 transition-all shadow-lg">
					Confirm
				</button>
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
				salesTab.style.borderColor = 'transparent';
				customersTab.style.backgroundColor = '#475569';
				customersTab.style.color = '#FFFFFF';
				customersTab.style.borderColor = '#64748b';
			} else {
				salesTable.classList.add('hidden');
				customerTable.classList.remove('hidden');
				headerBtn.textContent = '+ New Customer';
				headerBtn.setAttribute('onclick', 'openModal("newCustomerModal")');
				customersTab.style.backgroundColor = '#FFF1DA';
				customersTab.style.color = '#111827';
				customersTab.style.borderColor = 'transparent';
				salesTab.style.backgroundColor = '#475569';
				salesTab.style.color = '#FFFFFF';
				salesTab.style.borderColor = '#64748b';
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
			const sVal = statusFilter ? statusFilter.value : '';
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
		if (statusFilter) statusFilter.addEventListener('change', applyFilters);
		paymentFilter.addEventListener('change', applyFilters);

		// ---- Real-time unit price + line total for New Order modal ----
		function toNumber(value) {
			const n = parseFloat(value);
			return Number.isFinite(n) ? n : 0;
		}

		function formatCurrency(num) {
			return '₱' + num.toLocaleString(undefined, {
				minimumFractionDigits: 2,
				maximumFractionDigits: 2
			});
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
			['input', 'change', 'blur'].forEach(evt => newItemQty.addEventListener(evt, () => {
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

	// Export Dropdown Toggle - FIXED VERSION
	const exportButton = document.getElementById('exportButton');
	const exportDropdown = document.getElementById('exportDropdown');

	if (exportButton && exportDropdown) {
		exportButton.addEventListener('click', function(e) {
			e.preventDefault(); // Prevent default action
			e.stopPropagation();

			// Toggle dropdown visibility
			exportDropdown.classList.toggle('hidden');
		});

		// Close dropdown when clicking outside
		document.addEventListener('click', function(e) {
			if (!exportButton.contains(e.target) && !exportDropdown.contains(e.target)) {
				exportDropdown.classList.add('hidden');
			}
		});

		// Prevent dropdown from closing when clicking inside it
		exportDropdown.addEventListener('click', function(e) {
			e.stopPropagation();
		});
	}

	// Add row selection functionality
	const salesTbody = document.getElementById('salesTbody');
	if (salesTbody) {
		salesTbody.addEventListener('click', function(e) {
			const row = e.target.closest('tr.data-row');

			// Ignore clicks on action buttons
			if (e.target.closest('button') || e.target.closest('form')) {
				return;
			}

			if (row) {
				// Remove selection from all rows
				const allRows = salesTbody.querySelectorAll('tr.data-row');
				allRows.forEach(r => {
					r.classList.remove('!bg-gray-600', 'border-l-4', 'border-amber-500');
				});

				// Add selection to clicked row using Tailwind classes
				row.classList.add('!bg-gray-600', 'border-l-4', 'border-amber-500');
			}
		});
	}

	// Export Functions
	function exportReceipt(event) {
		event.preventDefault();
		exportDropdown.classList.add('hidden');

		// Check if a row is selected
		const selectedRow = document.querySelector('tr.data-row.border-amber-500');

		if (selectedRow) {
			// Get order number from the selected row
			const orderNumber = selectedRow.querySelector('td:first-child').textContent.trim();
			window.open(`/sales/receipt/${orderNumber}`, '_blank');
			return;
		}

		// If no row is selected, prompt user
		alert('Please select an order by clicking on a row in the table to export as receipt.');
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

	// Confirmation Modal Functions for Sales Order
	function confirmSalesOrder(event) {
		event.preventDefault();
		document.getElementById('confirmSalesOrderModal').classList.remove('hidden');
		return false;
	}

	function closeConfirmSalesOrder() {
		document.getElementById('confirmSalesOrderModal').classList.add('hidden');
	}

	function submitSalesOrder() {
		closeConfirmSalesOrder();
		// Submit the form
		const form = document.getElementById('newOrderForm');
		// Remove the onsubmit to avoid infinite loop
		form.onsubmit = null;
		form.submit();
	}

	// Confirmation Modal Functions for Customer
	function confirmCustomer(event) {
		event.preventDefault();
		document.getElementById('confirmCustomerModal').classList.remove('hidden');
		return false;
	}

	function closeConfirmCustomer() {
		document.getElementById('confirmCustomerModal').classList.add('hidden');
	}

	function submitCustomer() {
		closeConfirmCustomer();
		// Submit the form
		const form = document.getElementById('newCustomerForm');
		// Remove the onsubmit to avoid infinite loop
		form.onsubmit = null;
		form.submit();
	}
</script>
</div>
@endsection