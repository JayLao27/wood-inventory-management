@extends('layouts.system')

@section('main-content')
	@php
		$typeBg = [
			'Payment Made' => '#FFB74D',
			'Payment Received' => '#64B5F6',
			'Expense' => '#EF5350',
			'Income' => '#81C784',
		];
		$monthlyPerformance = $monthlyPerformance ?? [];
	@endphp
	<!-- Main Content -->
	<div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
		<!-- Header -->
		<div class="mb-8">
			<div class="flex justify-between items-center">
				<div>
					<h1 class="text-4xl font-bold text-gray-800">Accounting & Finance</h1>
					<p class="text-lg text-gray-600 mt-2">Track finances, manage budgets, and generate financial reports</p>
				</div>
				<div class="flex space-x-3">
					<div class="relative">
						<button id="exportButtonAccounting" class="flex items-center gap-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm text-white transition">
							<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
								<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
							</svg>
							<span>Export</span>
							<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
								<path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"/>
							</svg>
						</button>
						<!-- Export Dropdown -->
						<div id="exportDropdownAccounting" class="hidden fixed w-56 bg-white rounded-lg shadow-xl border border-gray-200 z-[9999]">
							<div class="py-1">
								<a href="#" onclick="exportTransactionReceipt(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
									<div class="flex items-center gap-2">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
										</svg>
										<span>Transaction Receipt</span>
									</div>
								</a>
								<a href="#" onclick="exportFinancialReport(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
									<div class="flex items-center gap-2">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
										</svg>
										<span>Financial Report</span>
									</div>
								</a>
								<a href="#" onclick="exportTransactionHistory(event)" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
									<div class="flex items-center gap-2">
										<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
										</svg>
										<span>Transaction History</span>
									</div>
								</a>
							</div>
						</div>
					</div>
					<button onclick="openAddTransaction()" class="flex items-center gap-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm text-white transition">
						<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
							<path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd"/>
						</svg>
						<span>Add Transaction</span>
					</button>
				</div>
			</div>
		</div>

		<!-- Dashboard Content -->
			<!-- Summary Cards -->
			<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
				<!-- Total Revenue Card -->
				<div class="bg-slate-700 text-white p-6 rounded-xl">
					<div class="flex justify-between items-start">
						<div class="flex-1">
							<h3 class="text-sm font-medium text-slate-300">Total Revenue</h3>
							<p class="text-3xl font-bold mt-2">₱{{ number_format($totalRevenue, 2) }}</p>
							<div class="flex items-center mt-2">
								<span class="text-sm {{ $lastMonthRevenuePercentage >= 1 ? 'text-green-400' : 'text-white' }}">+{{ $lastMonthRevenuePercentage }}% from last month</span>
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
							<p class="text-3xl font-bold mt-2">₱{{ number_format($totalExpenses, 2) }}</p>
							<div class="flex items-center mt-2">
								<span class="text-sm {{ $lastMonthExpensesPercentage >= 1 ? 'text-red-400' : 'text-white' }}">+{{ $lastMonthExpensesPercentage }}% from last month</span>
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
							<p class="text-3xl font-bold mt-2 text-white">₱{{ number_format($netProfit, 2) }}</p>
							<div class="flex items-center mt-2">
								<span class="text-sm {{ $lastMonthNetProfitPercentage >= 1 ? 'text-green-400' : 'text-white' }}">+{{ $lastMonthNetProfitPercentage }}% from last month</span>
							</div>
						</div>
								<div >
							@include('components.icons.dollar', ['class' => 'icon-dollar'])
					</div>
					</div>
				</div>
			</div>
			<!-- Main Content Grid -->
			<div class="grid grid-cols-1 gap-6">
				<!-- Financial Transactions Section (Full Width) -->
				<div class="w-full">
					<div class="bg-slate-700 text-white p-6 rounded-xl">
						<div class="mb-6">
							<h2 class="text-xl font-semibold mb-1">Financial Transactions</h2>
							<p class="text-slate-300 text-sm">Track all income, expenses, and financial activities</p>
						</div>

						<!-- Tabs -->
						<div class="flex space-x-2 w-full mb-6">
							<button onclick="showAccountingTab('transaction')" id="transactionTab" class="flex-1 px-5.5 py-3 rounded-xl border-2 font-bold text-sm transition-all shadow-lg" style="background-color: #FFF1DA; border-color: #FDE68A; color: #111827;">Transactions</button>
							<button onclick="showAccountingTab('reports')" id="reportsTab" class="flex-1 px-5.5 py-3 rounded-xl border-2 font-bold text-sm transition-all shadow-lg" style="background-color: #475569; border-color: #64748b; color: #FFFFFF;">Reports</button>
						</div>

						<div id="transactionContent">
							<!-- Search and Filters -->
							<div class="flex flex-col md:flex-row justify-between gap-4 mb-6">
								<div class="flex-1 max-w-md">
									<div class="relative">
										<div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
											<svg class="h-5 w-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
												<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
											</svg>
										</div>
										<input type="text" id="searchInput" placeholder="Search transactions..." class="w-full pl-10 pr-4 py-2 bg-white text-gray-900 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
									</div>
								</div>
								<div class="flex gap-2">
									<select id="statusFilter" class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
										<option value="all">All Status</option>
										<option value="paid">Paid</option>
										<option value="partial">Partial</option>
									</select>
									<select id="categoryFilter" class="flex items-center space-x-2 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-500 transition">
										<option value="all">All Categories</option>
										<option value="Income">Income</option>
										<option value="Expense">Expense</option>
									</select>
								</div>
							</div>

							<!-- Transactions Table -->
							<div class="overflow-y-auto max-h-[60vh]">
								<table class="w-full border-collapse text-left text-sm text-white">
								<thead class="bg-slate-800 text-slate-300 sticky top-0">
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
									@forelse($transactions as $transaction)
										<tr class="transaction-row hover:bg-slate-600 transition cursor-pointer" 
											data-type="{{ $transaction->transaction_type }}"
										data-status="@if($transaction->purchaseOrder){{ strtolower($transaction->purchaseOrder->payment_status ?? 'paid') }}@elseif($transaction->salesOrder){{ strtolower($transaction->salesOrder->payment_status ?? 'paid') }}@else{{ 'paid' }}@endif"
										data-id="TO-{{ \Carbon\Carbon::parse($transaction->date)->format('Y') }}-{{ str_pad($transaction->id, 3, '0', STR_PAD_LEFT) }}"
										data-date="{{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}"
										data-category="@if($transaction->salesOrder){{ strtolower($transaction->salesOrder->customer->name ?? '') }}@elseif($transaction->purchaseOrder){{ strtolower($transaction->purchaseOrder->supplier->name ?? '') }}@endif"
										data-description="@if($transaction->salesOrder){{ strtolower($transaction->salesOrder->order_number ?? '') }}@elseif($transaction->purchaseOrder){{ strtolower($transaction->purchaseOrder->order_number ?? '') }}@else{{ strtolower($transaction->description ?? '') }}@endif">
											<td class="px-4 py-3 font-mono text-slate-300">TO-{{ \Carbon\Carbon::parse($transaction->date)->format('Y') }}-{{ str_pad($transaction->id, 3, '0', STR_PAD_LEFT) }}</td>
											<td class="px-4 py-3 text-slate-300">{{ \Carbon\Carbon::parse($transaction->date)->format('M d, Y') }}</td>
											<td class="px-4 py-3">
												<span class="text-xs font-semibold {{ $transaction->transaction_type === 'Income' ? 'text-green-400' : 'text-red-400' }}">
													{{ $transaction->transaction_type }}
												</span>
											</td>
											<td class="px-4 py-3 font-medium">
												@if($transaction->salesOrder)
													<span class="text-blue-300">{{ $transaction->salesOrder->customer->name ?? 'N/A' }}</span>
												@elseif($transaction->purchaseOrder)
													<span class="text-purple-300">{{ $transaction->purchaseOrder->supplier->name ?? 'N/A' }}</span>
												@else
													<span class="text-slate-400">N/A</span>
												@endif
											</td>
											<td class="px-4 py-3">
												@if($transaction->salesOrder)
													<span class="text-slate-300">{{ $transaction->salesOrder->order_number }}</span>
												@elseif($transaction->purchaseOrder)
													<span class="text-slate-300">{{ $transaction->purchaseOrder->order_number }}</span>
												@else
													<span class="text-slate-400 italic">{{ $transaction->description ?? '-' }}</span>
												@endif
											</td>
											<td class="px-4 py-3 font-bold text-right">
												<span class="text-{{ $transaction->transaction_type === 'Income' ? 'green' : 'orange' }}-300">₱{{ number_format($transaction->amount, 2) }}</span>
											</td>
										</tr>
									@empty
										<tr>
											<td colspan="6" class="px-4 py-12 text-center text-slate-400">
												<div class="flex flex-col items-center space-y-2">
													<svg class="w-8 h-8 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
														<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
													</svg>
													<p>No transactions found</p>
												</div>
											</td>
										</tr>
									@endforelse
								</tbody>
								</table>
							</div>
						</div>

						<div id="reportsContent" class="hidden">
							<div class="bg-slate-800/60 rounded-xl p-6 border border-slate-600">
								<div class="mb-5">
									<h3 class="text-lg font-bold text-white">Monthly Performance</h3>
									<p class="text-slate-300 text-sm">Revenue, expenses, and net profit summary</p>
								</div>
								<div class="space-y-4">
									@foreach($monthlyPerformance as $month)
										<div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3 border-b border-slate-700 pb-4 last:border-b-0 last:pb-0">
											<div class="flex items-center gap-6">
												<span class="text-slate-200 font-semibold w-10">{{ $month['month'] }}</span>
												<div class="text-sm">
													<p class="text-green-400 font-semibold">Revenue: ₱{{ number_format($month['revenue'], 2) }}</p>
													<p class="text-red-400 font-semibold">Expenses: ₱{{ number_format($month['expenses'], 2) }}</p>
												</div>
											</div>
											<div class="text-right">
												<p class="text-blue-400 font-bold text-lg">₱{{ number_format($month['net_profit'], 2) }}</p>
												<p class="text-slate-300 text-xs">Net Profit</p>
											</div>
										</div>
									@endforeach
								</div>
							</div>
						</div>
						
					</div>
				</div>
			</div>
	</div>

	<!-- Add Transaction Modal -->
	<div id="addTransactionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
		<div class="bg-white rounded-lg shadow-lg p-8 w-full max-w-md">
			<div class="flex justify-between items-center mb-6">
				<h2 class="text-2xl font-bold text-gray-800">Add Transaction</h2>
				<button onclick="closeAddTransaction()" class="text-gray-500 hover:text-gray-700">
					<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
					</svg>
				</button>
			</div>

			<div class="flex gap-4 mb-6 border-b border-gray-200">
				<button onclick="showSalesOrders()" id="salesOrdersTab" class="pb-2 px-4 font-semibold text-slate-600 border-b-2 border-slate-600">Sales Orders (Income)</button>
				<button onclick="showPurchaseOrders()" id="purchaseOrdersTab" class="pb-2 px-4 font-semibold text-gray-500 hover:text-gray-700">Purchase Orders (Expense)</button>
			</div>

			<!-- Sales Orders List -->
			<div id="salesOrdersContainer" class="space-y-3 max-h-64 overflow-y-auto">
				@forelse($salesOrders as $salesOrder)
					<div onclick="selectTransaction('{{ $salesOrder->order_number }}', {{ $salesOrder->total_amount }}, '{{ \Carbon\Carbon::parse($salesOrder->order_date)->format('F d, Y') }}', 'Income', {{ $salesOrder->id }}, {{ $salesOrder->remaining_balance }})" class="p-4 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-400 cursor-pointer transition">
						<div class="flex justify-between items-start">
							<div class="flex-1">
								<h3 class="font-semibold text-gray-800">{{ $salesOrder->order_number }}: {{ $salesOrder->customer->name ?? 'N/A' }}</h3>
								<p class="text-sm text-gray-600">{{ $salesOrder->notes ?? 'Sales Order' }}</p>
							</div>
							<div class="flex flex-col items-end gap-1">
								<span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">₱{{ number_format($salesOrder->total_amount, 2) }}</span>
								@if($salesOrder->remaining_balance > 0)
									<span class="bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">Remaining: ₱{{ number_format($salesOrder->remaining_balance, 2) }}</span>
								@else
									<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Paid</span>
								@endif
							</div>
						</div>
						<p class="text-xs text-gray-500 mt-2">Date: {{ \Carbon\Carbon::parse($salesOrder->order_date)->format('F d, Y') }}</p>
					</div>
				@empty
					<p class="text-center text-gray-500 py-4">No sales orders available</p>
				@endforelse
			</div>

			<!-- Purchase Orders List -->
			<div id="purchaseOrdersContainer" class="space-y-3 max-h-64 overflow-y-auto hidden">
				@forelse($purchaseOrders as $purchaseOrder)
					<div onclick="selectTransaction('{{ $purchaseOrder->order_number }}', {{ $purchaseOrder->total_amount }}, '{{ \Carbon\Carbon::parse($purchaseOrder->order_date)->format('F d, Y') }}', 'Expense', {{ $purchaseOrder->id }}, {{ $purchaseOrder->remaining_balance }})" class="p-4 border border-gray-300 rounded-lg hover:bg-red-50 hover:border-red-400 cursor-pointer transition">
						<div class="flex justify-between items-start">
							<div class="flex-1">
								<h3 class="font-semibold text-gray-800">{{ $purchaseOrder->order_number }}: {{ $purchaseOrder->supplier->name ?? 'N/A' }}</h3>
								<p class="text-sm text-gray-600">{{ $purchaseOrder->notes ?? 'Purchase Order' }}</p>
							</div>
							<div class="flex flex-col items-end gap-1">
								<span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">₱{{ number_format($purchaseOrder->total_amount, 2) }}</span>
								@if($purchaseOrder->remaining_balance > 0)
									<span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-xs font-semibold">Remaining: ₱{{ number_format($purchaseOrder->remaining_balance, 2) }}</span>
								@else
									<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">Paid</span>
								@endif
							</div>
						</div>
						<p class="text-xs text-gray-500 mt-2">Date: {{ \Carbon\Carbon::parse($purchaseOrder->order_date)->format('F d, Y') }}</p>
					</div>
				@empty
					<p class="text-center text-gray-500 py-4">No purchase orders available</p>
				@endforelse
			</div>

			<!-- Confirmation Section -->
			<form id="transactionForm" method="POST" action="{{ route('accounting.transaction.store') }}">
				@csrf
				<input type="hidden" name="reference" id="formRef">
				<input type="hidden" name="date" id="formDate">
				<input type="hidden" name="transaction_type" id="formType">
				<input type="hidden" name="order_id" id="formOrderId">
				<input type="hidden" name="total_amount" id="formTotalAmount">
				
				<div id="confirmationSection" class="hidden mt-6 p-4 bg-gray-50 rounded-lg border border-gray-200">
					<h3 class="font-semibold text-gray-800 mb-3">Confirm Transaction</h3>
					<div class="space-y-2 mb-4">
						<div class="flex justify-between">
							<span class="text-gray-600">Reference:</span>
							<span id="confirmRef" class="font-semibold text-gray-800">-</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Total Amount:</span>
							<span id="confirmAmount" class="font-semibold text-gray-800">-</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Date:</span>
							<span id="confirmDate" class="font-semibold text-gray-800">-</span>
						</div>
						<div class="flex justify-between">
							<span class="text-gray-600">Type:</span>
							<span id="confirmType" class="font-semibold text-gray-800">-</span>
						</div>
					</div>
					<div class="mb-4">
						<label class="block text-sm font-medium text-gray-700 mb-2">Payment Amount</label>
						<input type="text" id="paymentAmount" name="amount" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-500 focus:border-transparent" placeholder="Enter payment amount" required>
						<p class="text-xs text-gray-500 mt-1">Max: <span id="maxAmount" class="font-semibold text-gray-700">-</span></p>
					</div>
					<div class="flex gap-3">
					<button onclick="resetSelection()" class="flex-1 px-4 py-2 bg-gray-300 text-gray-800 rounded-lg hover:bg-gray-400 transition">
						Back
					</button>
						<button type="submit" class="flex-1 px-4 py-2 bg-slate-600 text-white rounded-lg hover:bg-slate-700 transition">
							Confirm
						</button>
					</div>
				</div>
			</form>
		</div>
	</div>

	<script>
		let maxPaymentAmount = 0;

		// Filter functionality
		function filterTransactions() {
			const searchInput = document.getElementById('searchInput').value.toLowerCase();
			const categoryFilter = document.getElementById('categoryFilter').value;
			const statusFilter = document.getElementById('statusFilter').value;
			const rows = document.querySelectorAll('.transaction-row');
			
			rows.forEach(row => {
				const rowType = row.getAttribute('data-type');
				const rowStatus = row.getAttribute('data-status');
				const rowId = row.getAttribute('data-id').toLowerCase();
				const rowDate = row.getAttribute('data-date').toLowerCase();
				const rowCategory = row.getAttribute('data-category').toLowerCase();
				const rowDescription = row.getAttribute('data-description').toLowerCase();
				
				const categoryMatch = categoryFilter === 'all' || rowType === categoryFilter;
				const statusMatch = statusFilter === 'all' || rowStatus === statusFilter;
				const searchMatch = searchInput === '' || 
					rowId.includes(searchInput) ||
					rowDate.includes(searchInput) ||
					rowType.toLowerCase().includes(searchInput) ||
					rowCategory.includes(searchInput) ||
					rowDescription.includes(searchInput);
				
				if (categoryMatch && statusMatch && searchMatch) {
					row.style.display = '';
				} else {
					row.style.display = 'none';
				}
			});
		}

		// Attach filter event listeners
		document.getElementById('searchInput').addEventListener('input', filterTransactions);
		document.getElementById('categoryFilter').addEventListener('change', filterTransactions);
		document.getElementById('statusFilter').addEventListener('change', filterTransactions);

		// Modal functions
		function openAddTransaction() {
			document.getElementById('addTransactionModal').classList.remove('hidden');
			document.getElementById('confirmationSection').classList.add('hidden');
			document.getElementById('salesOrdersContainer').classList.remove('hidden');
		}

		function closeAddTransaction() {
			document.getElementById('addTransactionModal').classList.add('hidden');
			resetSelection();
		}

		// Tab switching
		function showSalesOrders() {
			document.getElementById('salesOrdersContainer').classList.remove('hidden');
			document.getElementById('purchaseOrdersContainer').classList.add('hidden');
			document.getElementById('salesOrdersTab').classList.add('text-slate-600', 'border-b-2', 'border-slate-600');
			document.getElementById('salesOrdersTab').classList.remove('text-gray-500');
			document.getElementById('purchaseOrdersTab').classList.remove('text-slate-600', 'border-b-2', 'border-slate-600');
			document.getElementById('purchaseOrdersTab').classList.add('text-gray-500');
			document.getElementById('confirmationSection').classList.add('hidden');
		}

		function showPurchaseOrders() {
			document.getElementById('purchaseOrdersContainer').classList.remove('hidden');
			document.getElementById('salesOrdersContainer').classList.add('hidden');
			document.getElementById('purchaseOrdersTab').classList.add('text-slate-600', 'border-b-2', 'border-slate-600');
			document.getElementById('purchaseOrdersTab').classList.remove('text-gray-500');
			document.getElementById('salesOrdersTab').classList.remove('text-slate-600', 'border-b-2', 'border-slate-600');
			document.getElementById('salesOrdersTab').classList.add('text-gray-500');
			document.getElementById('confirmationSection').classList.add('hidden');
		}

		// Transaction selection
		function selectTransaction(reference, amount, date, type, orderId, remainingBalance = null) {
			document.getElementById('confirmRef').textContent = reference;
			document.getElementById('confirmAmount').textContent = '₱' + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
			document.getElementById('confirmDate').textContent = date;
			document.getElementById('confirmType').textContent = type;
			
			// Use remaining balance for both Expense and Income types, fall back to full amount if not available
			const paymentCap = remainingBalance !== null ? remainingBalance : amount;
			
			// Store max amount for validation
			maxPaymentAmount = paymentCap;
			
			// Set hidden form fields
			document.getElementById('formRef').value = reference;
			document.getElementById('formTotalAmount').value = amount;
			document.getElementById('formDate').value = date;
			document.getElementById('formType').value = type;
			document.getElementById('formOrderId').value = orderId;
			document.getElementById('paymentAmount').value = paymentCap.toLocaleString('en-US');
			
			// Display max amount with formatting
			document.getElementById('maxAmount').textContent = '₱' + paymentCap.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
			
			// Hide transaction list and show confirmation
			document.getElementById('salesOrdersContainer').classList.add('hidden');
			document.getElementById('purchaseOrdersContainer').classList.add('hidden');
			document.getElementById('confirmationSection').classList.remove('hidden');
		}

		// Format payment amount input with commas and enforce max limit
		document.getElementById('paymentAmount').addEventListener('input', function(e) {
			let value = this.value.replace(/,/g, '');
			let numValue = parseInt(value) || 0;
			
			// Enforce max limit
			if (numValue > maxPaymentAmount) {
				numValue = maxPaymentAmount;
			}
			
			if (numValue > 0) {
				this.value = numValue.toLocaleString('en-US');
			} else {
				this.value = '';
			}
		});

		// Handle form submission - remove commas before sending
		document.getElementById('transactionForm').addEventListener('submit', function(e) {
			let paymentAmount = document.getElementById('paymentAmount').value.replace(/,/g, '');
			let numValue = parseInt(paymentAmount) || 0;
			
			// Validate payment amount doesn't exceed max
			if (numValue > maxPaymentAmount) {
				e.preventDefault();
				alert('Payment amount cannot exceed ₱' + maxPaymentAmount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
				return false;
			}
			
			document.getElementById('paymentAmount').value = paymentAmount;
		});

		function resetSelection() {
			document.getElementById('confirmationSection').classList.add('hidden');
			document.getElementById('salesOrdersContainer').classList.remove('hidden');
			document.getElementById('purchaseOrdersContainer').classList.add('hidden');
		}

		// Close modal when clicking outside
		document.getElementById('addTransactionModal').addEventListener('click', function(e) {
			if (e.target === this) {
				closeAddTransaction();
			}
		});

	// Export Dropdown Toggle
	const exportButtonAccounting = document.getElementById('exportButtonAccounting');
	const exportDropdownAccounting = document.getElementById('exportDropdownAccounting');

	if (exportButtonAccounting && exportDropdownAccounting) {
		exportButtonAccounting.addEventListener('click', function(e) {
			e.stopPropagation();
			const isHidden = exportDropdownAccounting.classList.contains('hidden');
			
			if (isHidden) {
				// Position the dropdown below the button
				const rect = exportButtonAccounting.getBoundingClientRect();
				exportDropdownAccounting.style.top = (rect.bottom + 8) + 'px';
				exportDropdownAccounting.style.right = (window.innerWidth - rect.right) + 'px';
				exportDropdownAccounting.classList.remove('hidden');
			} else {
				exportDropdownAccounting.classList.add('hidden');
			}
		});

		// Close dropdown when clicking outside
		document.addEventListener('click', function(e) {
			if (!exportButtonAccounting.contains(e.target) && !exportDropdownAccounting.contains(e.target)) {
				exportDropdownAccounting.classList.add('hidden');
			}
		});
	}

	// Add row selection functionality for transactions
	const transactionTable = document.querySelector('.transaction-row');
	if (transactionTable) {
		document.addEventListener('click', function(e) {
			const row = e.target.closest('tr.transaction-row');
			
			if (row) {
				// Remove selection from all rows
				const allRows = document.querySelectorAll('tr.transaction-row');
				allRows.forEach(r => {
					r.classList.remove('!bg-gray-600', 'border-l-4', 'border-amber-500');
				});
				
				// Add selection to clicked row using Tailwind classes
				row.classList.add('!bg-gray-600', 'border-l-4', 'border-amber-500');
			}
		});
	}

	// Tab switching functionality
	function showAccountingTab(tab) {
		const transactionTab = document.getElementById('transactionTab');
		const reportsTab = document.getElementById('reportsTab');
		const transactionContent = document.getElementById('transactionContent');
		const reportsContent = document.getElementById('reportsContent');
		
		if (tab === 'transaction') {
			transactionTab.style.backgroundColor = '#FFF1DA';
			transactionTab.style.color = '#111827';
			transactionTab.style.borderColor = '#FDE68A';
			reportsTab.style.backgroundColor = '#475569';
			reportsTab.style.color = '#FFFFFF';
			reportsTab.style.borderColor = '#64748b';
			transactionContent.classList.remove('hidden');
			reportsContent.classList.add('hidden');
		} else if (tab === 'reports') {
			reportsTab.style.backgroundColor = '#FFF1DA';
			reportsTab.style.color = '#111827';
			reportsTab.style.borderColor = '#FDE68A';
			transactionTab.style.backgroundColor = '#475569';
			transactionTab.style.color = '#FFFFFF';
			transactionTab.style.borderColor = '#64748b';
			transactionContent.classList.add('hidden');
			reportsContent.classList.remove('hidden');
		}
	}

	// Export Functions
	function exportTransactionReceipt(event) {
		event.preventDefault();
		exportDropdownAccounting.classList.add('hidden');
		
		// Get the selected transaction from the table
		const selectedRow = document.querySelector('tr.transaction-row.border-amber-500');
		
		if (!selectedRow) {
			alert('Please select a transaction by clicking on a row in the table to export as receipt.');
			return;
		}
		
		// Extract transaction ID from the selected row
		const transactionId = selectedRow.getAttribute('data-id');
		
		// Open receipt in new tab
		window.open(`/accounting/receipt/${transactionId}`, '_blank');
	}

	function exportFinancialReport(event) {
		event.preventDefault();
		exportDropdownAccounting.classList.add('hidden');
		// Implement financial report export (PDF)
		window.location.href = '/accounting/export/financial-report';
	}

	function exportTransactionHistory(event) {
		event.preventDefault();
		exportDropdownAccounting.classList.add('hidden');
		// Implement transaction history export (CSV)
		window.location.href = '/accounting/export/transactions';
	}
	</script>
@endsection
