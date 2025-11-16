@extends('layouts.system')

@section('main-content')
			<!-- Header -->
			<div class="bg-amber-50 p-8">
				<h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
				<p class="text-lg text-gray-600 mt-2">Wood works management system</p>
			</div>
			<!-- Main Content Area -->
			<!-- Dashboard Content -->
			<div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
				<!-- Dashboard Content -->
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
					<!-- Total Revenue Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex justify-between items-start">
							<div>
								<h3 class="text-sm font-medium text-slate-300">Total Revenue</h3>
								<p class="text-3xl font-bold mt-2">₱{{ number_format($salesOrders->sum('total_amount'), 2) }}</p>
								<p class="text-green-400 text-sm mt-1">+20.1% from last month</p>
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
								<p class="text-green-400 text-sm mt-1">+12 new this week</p>
							</div>
							<div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
									<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
								</svg>
							</div>
						</div>
					</div>

					<!-- In Production Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex justify-between items-start">
							<div>
								<h3 class="text-sm font-medium text-slate-300">In Production</h3>
								<p class="text-3xl font-bold mt-2">8</p>
								<p class="text-green-400 text-sm mt-1">0 due this week</p>
							</div>
							<div class="w-12 h-12 bg-slate-600 rounded-lg flex items-center justify-center">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
								</svg>
							</div>
						</div>
					</div>

					<!-- Low Stock Items Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex justify-between items-start">
							<div>
								<h3 class="text-sm font-medium text-slate-300">Low Stock Items</h3>
								<p class="text-3xl font-bold mt-2 text-red-400">5</p>
								<p class="text-white text-sm mt-1">Require immediate attention</p>
							</div>
							<div class="w-12 h-12 bg-red-600 rounded-lg flex items-center justify-center">
								<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
								</svg>
							</div>
						</div>
					</div>
				</div>


				<!-- Management Section Cards -->
				<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
					<!-- Inventory Management Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex itePPms-center space-x-3 mb-4">
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
							</svg>
							<h3 class="text-lg font-semibold">Inventory Management</h3>
						</div>
						<p class="text-slate-300 text-sm mb-4">Track raw material and finished products</p>
						
						<div class="space-y-2 mb-6">
							<div class="flex justify-between items-center">
								<span class="text-sm">Raw Materials</span>
								<span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">150 items</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">Finished products</span>
								<span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">18 items</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">Low Stock Alerts</span>
								<span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">5 items</span>
							</div>
						</div>

						<div class="flex space-x-2">
							<a href="{{ route('inventory') }}" class="flex items-center space-x-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
								</svg>
								<span>Manage Stock</span>
							</a>
							<a href="{{ route('inventory') }}" class="flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
								</svg>
								<span>Add Item</span>
							</a>
						</div>
					</div>

					<!-- Production Management Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex items-center space-x-3 mb-4">
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
							</svg>
							<h3 class="text-lg font-semibold">Production Management</h3>
						</div>
						<p class="text-slate-300 text-sm mb-4">Plan and track furniture production</p>
						
						<div class="space-y-2 mb-6">
							<div class="flex justify-between items-center">
								<span class="text-sm">Active Work Orders</span>
								<span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">8 orders</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">Pending Quality Check</span>
								<span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">3 orders</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">Overdue Orders</span>
								<span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">1 order</span>
							</div>
						</div>

						<div class="flex space-x-2">
							<button class="flex items-center space-x-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
								</svg>
								<span>Manage Task</span>
							</button>
							<button class="flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
								</svg>
								<span>New Order</span>
							</button>
						</div>
					</div>

					<!-- Sales & Orders Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex items-center space-x-3 mb-4">
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
								<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
							</svg>
							<h3 class="text-lg font-semibold">Sales & Orders</h3>
						</div>
						<p class="text-slate-300 text-sm mb-4">Manage customer orders and sales</p>
						
						<div class="space-y-2 mb-6">
							<div class="flex justify-between items-center">
								<span class="text-sm">Pending Orders</span>
								<span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">12 orders</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">Ready for Delivery</span>
								<span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">4 orders</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">This Month Sales</span>
								<span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">$ 28,240</span>
							</div>
						</div>

						<div class="flex space-x-2">
							<button class="flex items-center space-x-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
								</svg>
								<span>View Orders</span>
							</button>
							<button class="flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
								</svg>
								<span>New Sale</span>
							</button>
						</div>
					</div>
				</div>

				<!-- Additional Management Cards -->
				<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
					<!-- Procurement Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex items-center space-x-3 mb-4">
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
								<path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
								<path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
							</svg>
							<h3 class="text-lg font-semibold">Procurement</h3>
						</div>
						<p class="text-slate-300 text-sm mb-4">Manage supplier and purchase orders</p>
						
						<div class="space-y-2 mb-6">
							<div class="flex justify-between items-center">
								<span class="text-sm">Active Suppliers</span>
								<span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">12 Suppliers</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">Pending Deliveries</span>
								<span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">3 Orders</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">This Month Purchases</span>
								<span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">$15,230</span>
							</div>
						</div>

						<div class="flex space-x-2">
							<button class="flex items-center space-x-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
									<path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
								</svg>
								<span>View Deliveries</span>
							</button>
							<button class="flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
								</svg>
								<span>New Purchase</span>
							</button>
						</div>
					</div>

					<!-- Accounting & Finance Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex items-center space-x-3 mb-4">
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
								<path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
								<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
							</svg>
							<h3 class="text-lg font-semibold">Accounting & Finance</h3>
						</div>
						<p class="text-slate-300 text-sm mb-4">Track finances and generate reports</p>
						
						<div class="space-y-2 mb-6">
							<div class="flex justify-between items-center">
								<span class="text-sm">Monthly Revenue</span>
								<span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">$45,231</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">Monthly Expenses</span>
								<span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">$28,450</span>
							</div>
							<div class="flex justify-between items-center">
								<span class="text-sm">Net Profit</span>
								<span class="bg-blue-500 text-white px-3 py-1 rounded-full text-xs">$28,450</span>
							</div>
						</div>

						<div class="flex space-x-2">
							<button class="flex items-center space-x-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
									<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
								</svg>
								<span>View Reports</span>
							</button>
							<button class="flex items-center space-x-2 bg-orange-500 hover:bg-orange-600 px-4 py-2 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M3 3a1 1 0 000 2v8a2 2 0 002 2h2.586l-1.293 1.293a1 1 0 101.414 1.414L10 15.414l2.293 2.293a1 1 0 001.414-1.414L12.414 15H15a2 2 0 002-2V5a1 1 0 100-2H3zm11.707 4.707a1 1 0 00-1.414-1.414L10 9.586 8.707 8.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
								</svg>
								<span>Analytics</span>
							</button>
						</div>
					</div>

					<!-- Quick Actions Card -->
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex items-center space-x-3 mb-4">
							<svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
							</svg>
							<h3 class="text-lg font-semibold">Quick Actions</h3>
						</div>
						<p class="text-slate-300 text-sm mb-6">Common task and shortcuts</p>
						
						<div class="space-y-3">
							<a href="{{ route('sales') }}" class="w-full flex items-center space-x-3 bg-slate-600 hover:bg-slate-500 px-4 py-3 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
								</svg>
								<span>Add New Customer</span>
							</a>
							<button class="w-full flex items-center space-x-3 bg-slate-600 hover:bg-slate-500 px-4 py-3 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
								</svg>
								<span>Add New Supplier</span>
							</button>
							<button class="w-full flex items-center space-x-3 bg-slate-600 hover:bg-slate-500 px-4 py-3 rounded-lg text-sm transition">
								<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
									<path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
								</svg>
								<span>Create Work Orders</span>
							</button>
						</div>
					</div>
				</div>
			</div>
@endsection
<!--comment --> 