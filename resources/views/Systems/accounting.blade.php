@extends('layouts.system')

@section('main-content')
	@php
		$typeBg = [
			'Payment Made' => '#FFB74D',
			'Payment Received' => '#64B5F6',
			'Expense' => '#EF5350',
			'Income' => '#81C784',
		];
	@endphp
	<!-- Main Content -->
	<div class="flex-1 flex flex-col overflow-hidden">
		<!-- Header -->
		<div class="bg-amber-50 p-8">
			<div class="flex justify-between items-center">
				<div
					<h1 class="text-4xl font-bold text-gray-800">Accounting & Finance</h1>
					<p class="text-lg text-gray-600 mt-2">Track finances, manage budgets, and generate financial reports</p>
				</div>
				<div class="flex space-x-3">
					<button class="flex items-center space-x-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm text-white transition">
						<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
						</svg>
						<span>Export Reports</span>
					</button>
					<button class="flex items-center space-x-2  bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm text-white transition">
						<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
						</svg>
						<span>Add Transaction</span>
					</button>
				</div>
			</div>
		</div>

		<!-- Dashboard Content -->
		<div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
			<!-- Summary Cards -->
			<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
				<!-- Total Revenue Card -->
				<div class="bg-slate-700 text-white p-6 rounded-xl">
					<div class="flex justify-between items-start">
						<div class="flex-1">
							<h3 class="text-sm font-medium text-slate-300">Total Revenue</h3>
							<p class="text-3xl font-bold mt-2">₱{{ number_format($totalRevenue, 2) }}</p>
							<div class="flex items-center mt-2">
								<span class="text-green-400 text-sm">+12.5% from last month</span>
							</div>
						</div>	
					<div >
						@include('components.icons.dollar', ['class' => 'icon-dollar'])
				</div>
					</div>
				</div>

				<!-- Total Expenses Card -->
				<div class="bg-slate-700 text-white p-6 rounded-xl">
					<div class="flex justify-between items-start">
						<div class="flex-1">
							<h3 class="text-sm font-medium text-slate-300">Total Expenses</h3>
							<p class="text-3xl font-bold mt-2">₱0</p>
							<div class="flex items-center mt-2">
								<span class="text-red-400 text-sm">wowowow</span>
							</div>
						</div>
						<div >
							@include('components.icons.dollar', ['class' => 'icon-dollar'])
					</div>
					</div>
				</div>

				<!-- Net Profit Card -->
				<div class="bg-slate-700 text-white p-6 rounded-xl">
					<div class="flex justify-between items-start">
						<div class="flex-1">
							<h3 class="text-sm font-medium text-slate-300">Net Profit</h3>
							<p class="text-3xl font-bold mt-2 text-red-400">-₱426,882.58</p>
							<div class="flex items-center mt-2">
								<span class="text-green-400 text-sm">+18.7% from last month</span>
							</div>
						</div>
								<div >
							@include('components.icons.dollar', ['class' => 'icon-dollar'])
					</div>
					</div>
				</div>

				<!-- Cash Flow Card -->
				<div class="bg-slate-700 text-white p-6 rounded-xl">
					<div class="flex justify-between items-start">
						<div class="flex-1">
							<h3 class="text-sm font-medium text-slate-300">Cash Flow</h3>
							<p class="text-3xl font-bold mt-2">₱10000</p>
							<p class="text-slate-400 text-sm mt-2">Cash</p>
						</div>
				<div >
					@include('components.icons.dollar', ['class' => 'icon-dollar'])
				</div>
					</div>
					
				</div>
			</div>

			<!-- Main Content Grid -->
			<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
				<!-- Financial Transactions Section (Left - 2 columns) -->
				<div class="lg:col-span-2">
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="mb-6">
							<h2 class="text-xl font-semibold mb-1">Financial Transactions</h2>
							<p class="text-slate-300 text-sm">Track all income, expenses, and financial activities</p>
						</div>

						<!-- Search and Filters -->
						<div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
							<div class="flex-1 max-w-md">
								<div class="relative">
									<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
										<svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
										</svg>
									</div>
									<input type="text" placeholder="Search transactions..." class="w-full pl-10 pr-4 py-2 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
								</div>
							</div>
							<div class="flex gap-2">
								<select class="bg-white text-gray-900 rounded-lg px-3 py-2 text-sm">
									<option>All Status</option>
									<option>Completed</option>
									<option>Pending</option>
								</select>
								<select class="bg-white text-gray-900 rounded-lg px-3 py-2 text-sm">
									<option>All Categories</option>
									<option>Income</option>
									<option>Expense</option>
								</select>
							</div>
						</div>

						<!-- Tabs -->
						<div class="flex space-x-1 mb-6">
							<button id="transactionTab" class="flex-1 px-4 py-2 rounded-lg bg-slate-600 text-white">Transaction</button>
							<button id="reportsTab" class="flex-1 px-4 py-2 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700">Reports</button>
						</div>

						<!-- Transactions Table -->
						<div class="overflow-x-auto">
							<table class="min-w-full border-collapse text-left text-sm">
								<thead class="bg-slate-800 text-gray-300">
									<tr>
										<th class="px-4 py-3 font-medium">Transaction #</th>
										<th class="px-4 py-3 font-medium">Date</th>
										<th class="px-4 py-3 font-medium">Type</th>
										<th class="px-4 py-3 font-medium">Category</th>
										<th class="px-4 py-3 font-medium">Description</th>
										<th class="px-4 py-3 font-medium">Amount</th>
									</tr>
								</thead>
								<tbody class="divide-y divide-slate-600">
									
								</tbody>
							</table>
						</div>
					</div>
				</div>

				<!-- Expense Breakdown Section (Right - 1 column) -->
				<div class="lg:col-span-1">
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="flex items-center space-x-2 mb-6">
							<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
							</svg>
							<h2 class="text-xl font-semibold">Expense Breakdown</h2>
						</div>

						<div class="space-y-6">
							<!-- Materials -->
							<div>
								<div class="flex justify-between items-center mb-2">
									<span class="text-sm font-medium">Materials</span>
									<span class="text-sm">Backend materials</span>
								</div>
								<div class="w-full bg-slate-600 rounded-full h-3">
									<div class="bg-red-700 h-3 rounded-full" style="width: 53.5%"></div>
								</div>
								<p class="text-xs text-slate-400 mt-1">backend</p>
							</div>

							<!-- Labor -->
							<div>
								<div class="flex justify-between items-center mb-2">
									<span class="text-sm font-medium">Labor</span>
									<span class="text-sm">backend</span>
								</div>
								<div class="w-full bg-slate-600 rounded-full h-3">
									<div class="bg-red-700 h-3 rounded-full" style="width: 29.5%"></div>
								</div>
								<p class="text-xs text-slate-400 mt-1">29.5% of total expenses</p>
							</div>

							<!-- Rent -->
							<div>
								<div class="flex justify-between items-center mb-2">
									<span class="text-sm font-medium">Rent</span>
						
								</div>
								<div class="w-full bg-slate-600 rounded-full h-3">
									<div class="bg-red-700 h-3 rounded-full" style="width: 12.3%"></div>
								</div>
								<p class="text-xs text-slate-400 mt-1">12.3% of total expenses</p>
							</div>

							<!-- Utilities -->
							<div>
								<div class="flex justify-between items-center mb-2">
									<span class="text-sm font-medium">Utilities</span>
									<span class="text-sm">₱52,791.69</span>
								</div>
								<div class="w-full bg-slate-600 rounded-full h-3">
									<div class="bg-red-700 h-3 rounded-full" style="width: 3.2%"></div>
								</div>
								<p class="text-xs text-slate-400 mt-1">backend</p>
							</div>

							<!-- Insurance -->
							<div>
								<div class="flex justify-between items-center mb-2">
									<span class="text-sm font-medium">Insurance</span>
									<span class="text-sm">₱24,636.12</span>
								</div>
								<div class="w-full bg-slate-600 rounded-full h-3">
									<div class="bg-red-700 h-3 rounded-full" style="width: 1.5%"></div>
								</div>
								<p class="text-xs text-slate-400 mt-1">1.5% of total expenses</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		// Tab functionality
		const transactionTab = document.getElementById('transactionTab');
		const reportsTab = document.getElementById('reportsTab');

		if (tab === 'transactionTab') {
                purchaseOrdersTab.style.backgroundColor = '#FFF1DA';
                purchaseOrdersTab.style.color = '#111827';
                purchaseOrdersTab.style.border = 'none';
                suppliersTab.style.backgroundColor = '#374151';
                suppliersTab.style.color = '#FFFFFF';
                suppliersTab.style.border = '1px solid #FFFFFF';
                purchaseOrdersTable.classList.remove('hidden');
                suppliersTable.classList.add('hidden');
                purchaseOrdersButton.classList.remove('hidden');
                suppliersButton.classList.add('hidden');
            } else {
                suppliersTab.style.backgroundColor = '#FFF1DA';
                suppliersTab.style.color = '#111827';
                suppliersTab.style.border = 'none';
                purchaseOrdersTab.style.backgroundColor = '#374151';
                purchaseOrdersTab.style.color = '#FFFFFF';
                purchaseOrdersTab.style.border = '1px solid #FFFFFF';
                suppliersTable.classList.remove('hidden');
                purchaseOrdersTable.classList.add('hidden');
                purchaseOrdersButton.classList.add('hidden');
                suppliersButton.classList.remove('hidden');
            }
		transactionTab.addEventListener('click', () => {
			transactionTab.classList.add('bg-slate-600', 'text-white');
			reportsTab.classList.remove('bg-slate-600', 'text-white');		
	</script>
@endsection
