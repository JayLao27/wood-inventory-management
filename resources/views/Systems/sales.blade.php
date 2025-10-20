@extends('layouts.app')

@section('content')
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
	<div class="flex h-screen bg-gray-100">
		<!-- Sidebar -->
		<div class="w-64 bg-slate-700 text-white flex flex-col">
			<!-- Logo Section -->
			<div class="p-6 border-b border-slate-600">
				<div class="flex items-center space-x-3">
					<div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
						<svg class="w-6 h-6 text-slate-700" fill="currentColor" viewBox="0 0 20 20">
							<path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
						</svg>
					</div>
					<div>
						<h1 class="text-lg font-bold">RM WOOD WORKS</h1>
						<p class="text-sm text-slate-300">Management System</p>
					</div>
				</div>
			</div>

			<!-- Sidebar Menu -->
			<nav class="flex-1 p-4">
				<ul class="space-y-2">
					<li>
						<a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-600 hover:text-white transition">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
								<path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
							</svg>
							<span>Dashboard</span>
						</a>
					</li>
					<li>
						<a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-600 hover:text-white transition">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
							</svg>
							<span>Inventory</span>
						</a>
					</li>
					<li>
						<a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-600 hover:text-white transition">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
							</svg>
							<span>Production</span>
						</a>
					</li>
					<li>
						<a href="{{ route('sales') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg bg-orange-500 text-white">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
								<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
							</svg>
							<span>Sales & Orders</span>
						</a>
					</li>
					<li>
						<a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-600 hover:text-white transition">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
								<path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
								<path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
							</svg>
							<span>Procurement</span>
						</a>
					</li>
					<li>
						<a href="#" class="flex items-center space-x-3 px-4 py-3 rounded-lg text-slate-300 hover:bg-slate-600 hover:text-white transition">
							<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
								<path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
							</svg>
							<span>Accounting</span>
						</a>
					</li>
				</ul>
			</nav>

			<!-- Footer -->
			<div class="p-4 border-t border-slate-600">
				<p class="text-xs text-slate-400">© 2024 RM Woodworks</p>
			</div>
		</div>

		<!-- Main Content -->
		<div class="flex-1 flex flex-col overflow-hidden">
			<!-- Header -->
			<div class="bg-amber-50 p-8">
				<div class="flex justify-between items-center">
					<div>
						<h1 class="text-4xl font-bold text-gray-800">Sales & Orders</h1>
						<p class="text-lg text-gray-600 mt-2">Manage customer orders, sales, and deliveries</p>
					</div>
					<div>
						<button id="headerActionBtn" class="bg-gray-700 text-white px-4 py-2 rounded-md ml-2 hover:bg-orange-500 transition" onclick="openActionModal()">
							+ New Order
						</button>
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
								<p class="text-3xl font-bold mt-2">₱{{ number_format($salesOrders->sum('total_amount'), 2) }}</p>
								<p class="text-slate-300 text-sm mt-1">All time sales</p>
							</div>
							<div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
									<path d="M3 4a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
								</svg>
							</div>
						</div>
					</div>

					<!-- Payments Received Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex justify-between items-start">
							<div>
								<h3 class="text-sm font-medium text-slate-300">Payments Received</h3>
								<p class="text-3xl font-bold mt-2">₱{{ number_format($salesOrders->where('payment_status', 'Paid')->sum('total_amount'), 2) }}</p>
								<p class="text-slate-300 text-sm mt-1">Paid orders</p>
							</div>
							<div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
									<path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
								</svg>
							</div>
						</div>
					</div>

					<!-- Pending Payments Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex justify-between items-start">
							<div>
								<h3 class="text-sm font-medium text-slate-300">Pending Payments</h3>
								<p class="text-3xl font-bold mt-2">₱{{ number_format($salesOrders->whereIn('payment_status', ['Pending', 'Partial'])->sum('total_amount'), 2) }}</p>
								<p class="text-slate-300 text-sm mt-1">Outstanding amount</p>
							</div>
							<div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
									<path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
								</svg>
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
							<div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
									<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
								</svg>
							</div>
						</div>
					</div>
				</div>

				<!-- Sales Management Card -->
				<section class="bg-slate-700 text-white p-6 rounded-2xl">
					<header class="mb-4">
						<h2 class="text-xl font-semibold">Sales Management</h2>
						<p class="text-gray-300">Manage customer orders and track sales performance</p>
					</header>

					<!-- Search + Filters -->
					<div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
						<input type="search" id="searchInput" placeholder="Search order or customers..." class="bg-white w-full md:w-3/4 rounded-full px-4 py-2 text-gray-900 focus:outline-none">
						<div class="flex gap-2">
							<select id="statusFilter" class="bg-white text-gray-900 rounded-md px-3 py-2">
								<option value="">All Status</option>
								<option value="Pending">Pending</option>
								<option value="In production">In Production</option>
								<option value="Ready">Ready</option>
								<option value="Delivered">Delivered</option>
							</select>
							<select id="paymentFilter" class="bg-white text-gray-900 rounded-md px-3 py-2">
								<option value="">All Payment</option>
								<option value="Pending">Unpaid</option>
								<option value="Partial">Partial</option>
								<option value="Paid">Paid</option>
							</select>
						</div>
					</div>

					<!-- Tabs -->
					<div class="flex justify-center gap-2 mb-6">
						<button id="salesTab" class="bg-orange-500 text-gray-900 px-48 py-2 rounded-md border border-gray-600 hover:bg-yellow-100 hover:text-black transition">Sales Orders</button>
						<button id="customersTab" class="bg-slate-600 text-white px-48 py-2 rounded-md border border-gray-600 hover:bg-yellow-100 hover:text-black transition">Customers</button>
					</div>

					<!-- Sales Orders Table -->
					<div id="salesTable" class="overflow-x-auto">
						<table class="min-w-full border-collapse text-left text-sm">
							<thead class="bg-slate-800 text-gray-300">
								<tr>
									<th class="px-4 py-2">Order #</th>
									<th class="px-4 py-2">Customer</th>
									<th class="px-4 py-2">Order Date</th>
									<th class="px-4 py-2">Delivery Date</th>
									<th class="px-4 py-2">Status</th>
									<th class="px-4 py-2">Total Amount</th>
									<th class="px-4 py-2">Payment Status</th>
									<th class="px-4 py-2">Action</th>
								</tr>
							</thead>
							<tbody id="salesTbody">
								@forelse($salesOrders as $order)
									<tr class="border-t border-slate-600 data-row" data-status="{{ $order->status }}" data-payment="{{ $order->payment_status }}">
										<td class="px-4 py-2">{{ $order->order_number }}</td>
										<td class="px-4 py-2">
											<div class="font-medium">{{ $order->customer?->name }}</div>
											@php $ct = $order->customer?->customer_type; $ctBg = $customerTypeBg[$ct] ?? '#e5e7eb'; @endphp
											<span class="mt-1 inline-block text-xs text-white px-2 py-0.5 rounded" style="background: {{ $ctBg }};">{{ $ct }}</span>
										</td>
										<td class="px-4 py-2">{{ \Illuminate\Support\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
										<td class="px-4 py-2">{{ \Illuminate\Support\Carbon::parse($order->delivery_date)->format('M d, Y') }}</td>
										@php
											$sb = $order->status === 'Pending' ? '#ffffff' : ($statusBg[$order->status] ?? '#e5e7eb');
											$stText = $order->status === 'Pending' ? 'text-gray-900' : 'text-white';
										@endphp
										<td class="px-4 py-2"><span class="inline-block text-xs px-2 py-0.5 rounded {{ $stText }}" style="background: {{ $sb }};">{{ $order->status }}</span></td>
										<td class="px-4 py-2">₱{{ number_format($order->total_amount, 2) }}</td>
										@php
											$pb = $paymentBg[$order->payment_status] ?? '#ffffff';
											$ptText = $order->payment_status === 'Pending' ? 'text-gray-900' : 'text-white';
											$pendingBorder = $order->payment_status==='Pending' ? 'border border-gray-300' : '';
										@endphp
										<td class="px-4 py-2">
											<span class="inline-block text-xs px-2 py-0.5 rounded {{ $ptText }} {{ $pendingBorder }}" style="background: {{ $pb }};">{{ $order->payment_status }}</span>
										</td>
										<td class="px-4 py-2">
											<button class="text-green-300 mr-2" onclick="openModal('viewOrderModal-{{ $order->id }}')">View</button>
											<button class="text-yellow-300" onclick="openModal('editOrderModal-{{ $order->id }}')">Edit</button>
											<form action="{{ route('sales-orders.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('Cancel this order?')">
												@csrf
												@method('DELETE')
												<button type="submit" class="text-red-300 ml-2">Cancel</button>
											</form>
										</td>
									</tr>

									<!-- View Order Modal -->
									<div id="viewOrderModal-{{ $order->id }}" class="fixed inset-0 bg-black/70 hidden">
										<div class="bg-white text-gray-900 rounded-lg shadow-xl max-w-2xl w-[92%] mx-auto mt-16 p-6">
											<div class="flex items-center justify-between mb-4">
												<h3 class="text-2xl font-bold">Order Details</h3>
												<button class="text-xl" onclick="closeModal('viewOrderModal-{{ $order->id }}')">✕</button>
											</div>
											<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg leading-relaxed">
												<div><span class="font-semibold">Order #:</span> {{ $order->order_number }}</div>
												<div><span class="font-semibold">Customer:</span> {{ $order->customer?->name }}</div>
												<div><span class="font-semibold">Customer Type:</span> <span class="px-2 py-0.5 rounded text-white" style="background: {{ $customerTypeBg[$order->customer?->customer_type] ?? '#e5e7eb' }};">{{ $order->customer?->customer_type }}</span></div>
												<div><span class="font-semibold">Order Date:</span> {{ \Illuminate\Support\Carbon::parse($order->order_date)->format('M d, Y') }}</div>
												<div><span class="font-semibold">Delivery Date:</span> {{ \Illuminate\Support\Carbon::parse($order->delivery_date)->format('M d, Y') }}</div>
												@php
													$vsb = $order->status === 'Pending' ? '#ffffff' : ($statusBg[$order->status] ?? '#e5e7eb');
													$vstText = $order->status === 'Pending' ? 'color: #111827;' : 'color: #ffffff;';
												@endphp
												<div><span class="font-semibold">Status:</span> <span class="px-2 py-0.5 rounded" style="background: {{ $vsb }}; {{ $vstText }}">{{ $order->status }}</span></div>
												@php
													$vpb = $paymentBg[$order->payment_status] ?? '#ffffff';
													$vptText = $order->payment_status === 'Pending' ? 'color: #111827;' : 'color: #ffffff;';
												@endphp
												<div><span class="font-semibold">Payment Status:</span> <span class="px-2 py-0.5 rounded" style="background: {{ $vpb }}; {{ $vptText }}">{{ $order->payment_status }}</span></div>
												<div><span class="font-semibold">Total Amount:</span> ₱{{ number_format($order->total_amount, 2) }}</div>
												<div class="md:col-span-2"><span class="font-semibold">Notes:</span>
													<div class="mt-1 whitespace-pre-wrap">{{ $order->note ?: '—' }}</div>
												</div>
											</div>
											<div class="flex justify-end mt-6">
												<button class="px-4 py-2 bg-gray-900 text-white rounded" onclick="closeModal('viewOrderModal-{{ $order->id }}')">Close</button>
											</div>
										</div>
									</div>

									<!-- Edit Order Modal -->
									<div id="editOrderModal-{{ $order->id }}" class="fixed inset-0 bg-black/50 hidden">
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
														<div>
															<label class="text-sm">Status</label>
															<select name="status" class="w-full border rounded px-2 py-1">
																@foreach(['In production','Pending','Delivered','Ready'] as $s)
																	<option value="{{ $s }}" @selected($order->status==$s)>{{ $s }}</option>
																@endforeach
															</select>
														</div>
														<div>
															<label class="text-sm">Payment Status</label>
															<select name="payment_status" class="w-full border rounded px-2 py-1">
																@foreach(['Pending','Partial','Paid'] as $ps)
																	<option value="{{ $ps }}" @selected($order->payment_status==$ps)>{{ $ps }}</option>
																@endforeach
															</select>
														</div>
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
					<div id="customerTable" class="hidden overflow-x-auto">
						<table class="min-w-full border-collapse text-left text-sm">
							<thead class="bg-slate-800 text-gray-300">
								<tr>
									<th class="px-4 py-2">Name</th>
									<th class="px-4 py-2">Type</th>
									<th class="px-4 py-2">Contact</th>
									<th class="px-4 py-2">Email</th>
									<th class="px-4 py-2">Total Orders</th>
									<th class="px-4 py-2">Total Spent</th>
									<th class="px-4 py-2">Action</th>
								</tr>
							</thead>
							<tbody id="customersTbody">
								@forelse($customers as $customer)
									<tr class="border-t border-slate-600 data-row">
										<td class="px-4 py-2">{{ $customer->name }}</td>
										@php $ctBg = $customerTypeBg[$customer->customer_type] ?? '#e5e7eb'; @endphp
										<td class="px-4 py-2"><span class="inline-block text-xs text-white px-2 py-0.5 rounded" style="background: {{ $ctBg }};">{{ $customer->customer_type }}</span></td>
										<td class="px-4 py-2">{{ $customer->phone }}</td>
										<td class="px-4 py-2">{{ $customer->email }}</td>
										<td class="px-4 py-2">{{ $customer->totalOrders() }}</td>
										<td class="px-4 py-2">₱{{ number_format($customer->totalSpent(), 2) }}</td>
										<td class="px-4 py-2">
											<button class="text-green-300 mr-2" onclick="openModal('viewCustomerModal-{{ $customer->id }}')">View</button>
											<button class="text-yellow-300 mr-2" onclick="openModal('editCustomerModal-{{ $customer->id }}')">Edit</button>
											<form action="{{ route('customers.destroy', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this customer?')">
												@csrf
												@method('DELETE')
												<button type="submit" class="text-red-300">Delete</button>
											</form>
										</td>
									</tr>

									<!-- View Customer Modal -->
									<div id="viewCustomerModal-{{ $customer->id }}" class="fixed inset-0 bg-black/70 hidden">
										<div class="bg-white text-gray-900 rounded-lg shadow-xl max-w-2xl w-[92%] mx-auto mt-16 p-6">
											<div class="flex items-center justify-between mb-4">
												<h3 class="text-2xl font-bold">Customer Details</h3>
												<button class="text-xl" onclick="closeModal('viewCustomerModal-{{ $customer->id }}')">✕</button>
											</div>
											<div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-lg leading-relaxed">
												<div><span class="font-semibold">Name:</span> {{ $customer->name }}</div>
												<div><span class="font-semibold">Type:</span> <span class="px-2 py-0.5 rounded text-white" style="background: {{ $customerTypeBg[$customer->customer_type] ?? '#e5e7eb' }};">{{ $customer->customer_type }}</span></div>
												<div><span class="font-semibold">Contact #:</span> {{ $customer->phone ?: '—' }}</div>
												<div><span class="font-semibold">Email:</span> {{ $customer->email ?: '—' }}</div>
												<div><span class="font-semibold">Total Orders:</span> {{ $customer->totalOrders() }}</div>
												<div><span class="font-semibold">Total Spent:</span> ₱{{ number_format($customer->totalSpent(), 2) }}</div>
											</div>
											<div class="flex justify-end mt-6">
												<button class="px-4 py-2 bg-gray-900 text-white rounded" onclick="closeModal('viewCustomerModal-{{ $customer->id }}')">Close</button>
											</div>
										</div>
									</div>

									<!-- Edit Customer Modal -->
									<div id="editCustomerModal-{{ $customer->id }}" class="fixed inset-0 bg-black/50 hidden">
										<div class="bg-white text-gray-900 rounded shadow max-w-lg w-full mx-auto mt-24 p-6">
											<div class="flex items-center justify-between mb-4">
												<h3 class="font-semibold">Edit Customer</h3>
												<button onclick="closeModal('editCustomerModal-{{ $customer->id }}')">✕</button>
											</div>
											<form method="POST" action="{{ route('customers.update', $customer) }}">
												@csrf
												@method('PUT')
												<div class="grid gap-4">
													<div>
														<label class="text-sm">Name</label>
														<input type="text" name="name" value="{{ $customer->name }}" class="w-full border rounded px-2 py-1">
													</div>
													<div class="grid grid-cols-2 gap-3">
														<div>
															<label class="text-sm">Type</label>
															<select name="customer_type" class="w-full border rounded px-2 py-1">
																@foreach(['Retail','Contractor','Wholesale'] as $t)
																	<option value="{{ $t }}" @selected($customer->customer_type==$t)>{{ $t }}</option>
																@endforeach
															</select>
														</div>
														<div>
															<label class="text-sm">Phone</label>
															<input type="text" name="phone" value="{{ $customer->phone }}" class="w-full border rounded px-2 py-1" placeholder="09XXXXXXXXX">
														</div>
													</div>
													<div class="grid grid-cols-2 gap-3">
														<div>
															<label class="text-sm">Email</label>
															<input type="email" name="email" value="{{ $customer->email }}" class="w-full border rounded px-2 py-1">
														</div>
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
					<div class="bg-white text-gray-900 rounded shadow max-w-2xl w-full mx-auto mt-16 p-6">
						<div class="flex items-center justify-between mb-4">
							<h3 class="font-semibold">Create New Order</h3>
							<button onclick="closeModal('newOrderModal')">✕</button>
						</div>
						<form method="POST" action="{{ route('sales-orders.store') }}">
							@csrf
							<div class="grid gap-4">
								<div>
									<label class="text-sm">Customer <span class="text-red-500">*</span></label>
									<select name="customer_id" class="w-full border rounded px-2 py-1" required>
										<option value="">Select Customer</option>
										@foreach($customers as $c)
											<option value="{{ $c->id }}">{{ $c->name }} ({{ $c->customer_type }})</option>
										@endforeach
									</select>
								</div>
								<div class="grid grid-cols-2 gap-3">
									<div>
										<label class="text-sm">Delivery Date <span class="text-red-500">*</span></label>
										<input type="date" name="delivery_date" class="w-full border rounded px-2 py-1" required>
									</div>
									<div>
										<label class="text-sm">Status</label>
										<input type="text" value="Pending" class="w-full border rounded px-2 py-1 bg-gray-100" disabled>
									</div>
								</div>
								<div class="grid grid-cols-3 gap-3 items-end">
									<div>
										<label class="text-sm">Product</label>
										<select id="newItemProduct" name="items[0][product_id]" class="w-full border rounded px-2 py-1">
											<option value="">-- select product --</option>
											@foreach($products as $p)
												<option value="{{ $p->id }}" data-price="{{ number_format($p->unit_price,2,'.','') }}">{{ $p->name }}</option>
											@endforeach
										</select>
									</div>
									<div>
										<label class="text-sm">Quantity</label>
										<input id="newItemQty" type="number" min="1" name="items[0][quantity]" class="w-full border rounded px-2 py-1" placeholder="1">
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
						<form method="POST" action="{{ route('customers.store') }}">
							@csrf
							<div class="grid gap-4">
								<div>
									<label class="text-sm">Name <span class="text-red-500">*</span></label>
									<input type="text" name="name" class="w-full border rounded px-2 py-1" required>
								</div>
								<div class="grid grid-cols-2 gap-3">
									<div>
										<label class="text-sm">Type <span class="text-red-500">*</span></label>
										<select name="customer_type" class="w-full border rounded px-2 py-1" required>
											@foreach(['Retail','Contractor','Wholesale'] as $t)
												<option value="{{ $t }}">{{ $t }}</option>
											@endforeach
										</select>
									</div>
									<div>
										<label class="text-sm">Phone</label>
										<input type="text" name="phone" class="w-full border rounded px-2 py-1" placeholder="09XXXXXXXXX">
									</div>
								</div>
								<div>
									<label class="text-sm">Email</label>
									<input type="email" name="email" class="w-full border rounded px-2 py-1">
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
		// Header action button behavior based on active tab
		function openActionModal() {
			const inSales = !document.getElementById('salesTable').classList.contains('hidden');
			if (inSales) {
				openModal('newOrderModal');
			} else {
				openModal('newCustomerModal');
			}
		}

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
			const headerBtn = document.getElementById('headerActionBtn');
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
					salesTab.classList.add('bg-orange-500','text-gray-900');
					salesTab.classList.remove('bg-slate-600','text-white');
					customersTab.classList.add('bg-slate-600','text-white');
					customersTab.classList.remove('bg-orange-500','text-gray-900');
				} else {
					salesTable.classList.add('hidden');
					customerTable.classList.remove('hidden');
					headerBtn.textContent = '+ New Customer';
					customersTab.classList.add('bg-orange-500','text-gray-900');
					customersTab.classList.remove('bg-slate-600','text-white');
					salesTab.classList.add('bg-slate-600','text-white');
					salesTab.classList.remove('bg-orange-500','text-gray-900');
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

			// default: sales tab
			setMode('sales');
		})();
	</script>
@endsection