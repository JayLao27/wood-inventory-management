@extends('layouts.system')

@section('main-content')
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
				<section class="bg-slate-700 text-white p-6 rounded-2xl">
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
					<div id="salesTable" class="overflow-y-auto" style="max-height: 60vh;">
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
												<button onclick="openModal('viewOrderModal-{{ $order->id }}')" class="p-1 hover:bg-slate-500 rounded">
													<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
														<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
														<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
													</svg>
												</button>
												<button onclick="openModal('editOrderModal-{{ $order->id }}')" class="p-1 hover:bg-slate-500 rounded">
													<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
														<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
													</svg>
												</button>
												<form action="{{ route('sales-orders.destroy', $order) }}" method="POST" class="inline-block" onsubmit="return confirm('Cancel this order?')">
													@csrf
													@method('DELETE')
													<button type="submit" class="p-1 hover:bg-slate-500 rounded">
														<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
															<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
														</svg>
													</button>
												</form>
											</div>
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
												<div><span class="font-semibold">Payment Status:</span>
											@if($order->payment_status === 'Paid')
												<span class="text-green-400 font-semibold">{{ $order->payment_status }}</span>
											@elseif($order->payment_status === 'Partial')
												<span class="text-orange-400 font-semibold">{{ $order->payment_status }}</span>
											@else
												<span class="text-slate-400 font-semibold">{{ $order->payment_status }}</span>
											@endif
										</div>
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
					<div id="customerTable" class="hidden overflow-y-auto" style="max-height: 60vh;">
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
												<button onclick="openModal('viewCustomerModal-{{ $customer->id }}')" class="p-1 hover:bg-slate-500 rounded">
													<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
														<path d="M10 12a2 2 0 100-4 2 2 0 000 4z"/>
														<path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd"/>
													</svg>
												</button>
												<button onclick="openModal('editCustomerModal-{{ $customer->id }}')" class="p-1 hover:bg-slate-500 rounded">
													<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
														<path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z"/>
													</svg>
												</button>
												<form action="{{ route('customers.delete', $customer) }}" method="POST" class="inline-block" onsubmit="return confirm('Are you sure you want to delete this customer?')">
													@csrf
													@method('DELETE')
													<button type="submit" class="p-1 hover:bg-slate-500 rounded">
														<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
															<path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd"/>
														</svg>
													</button>
												</form>
											</div>
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
											<option value="{{ $c->id }}">{{ $c->name }} ({{ $c->customer_type }}	)</option>
										@endforeach
									</select>
								</div>
								<div class="grid grid-cols-2 gap-3">
									<div>
										<label class="text-sm">Delivery Date <span class="text-red-500">*</span></label>
										<input type="date" name="delivery_date" class="w-full border rounded px-2 py-1" required>
									</div>
								</div>
								<div class="grid grid-cols-3 gap-3 items-end">
									<div>
										<label class="text-sm">Product</label>
										<select id="newItemProduct" name="items[0][product_id]" class="w-full border rounded px-2 py-1">
											<option value="">-- select product --</option>
											@foreach($products as $p)
												<option value="{{ $p->id }}" data-price="{{ number_format($p->selling_price,2,'.','') }}">{{ $p->product_name }}</option>
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

			// default: sales tab
			setMode('sales');
		})();
	</script>
		</div>
@endsection