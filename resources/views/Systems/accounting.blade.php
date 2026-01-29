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
					<div>
					<h1 class="text-4xl font-bold text-gray-800">Accounting & Finance</h1>
					<p class="text-lg text-gray-600 mt-2">Track finances, manage budgets, and generate financial reports</p>
				</div>
				<div class="flex space-x-3">
				<button class="flex items-center gap-2 bg-slate-600 hover:bg-slate-500 px-4 py-2 rounded-lg text-sm text-white transition">
					<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
						<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
					</svg>
					<span>Export Reports</span>
				</button>
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
		<div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
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

						<!-- Tabs -->
						<div class="flex space-x-1 mb-6">
							<button id="transactionTab" class="flex-1 px-4 py-2 rounded-lg bg-slate-600 text-white">Transaction</button>
							<button id="reportsTab" class="flex-1 px-4 py-2 rounded-lg bg-slate-800 text-slate-300 hover:bg-slate-700">Reports</button>
						</div>

						<!-- Transactions Table -->
						<div class="overflow-y-auto" style="max-height: 60vh;">
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
											data-status="@if($transaction->purchaseOrder){{ strtolower($transaction->purchaseOrder->payment_status ?? 'paid') }}@else{{ 'paid' }}@endif">
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
					<div onclick="selectTransaction('{{ $salesOrder->order_number }}', {{ $salesOrder->total_amount }}, '{{ \Carbon\Carbon::parse($salesOrder->order_date)->format('F d, Y') }}', 'Income', {{ $salesOrder->id }})" class="p-4 border border-gray-300 rounded-lg hover:bg-blue-50 hover:border-blue-400 cursor-pointer transition">
						<div class="flex justify-between items-start">
							<div class="flex-1">
								<h3 class="font-semibold text-gray-800">{{ $salesOrder->order_number }}: {{ $salesOrder->customer->name ?? 'N/A' }}</h3>
								<p class="text-sm text-gray-600">{{ $salesOrder->notes ?? 'Sales Order' }}</p>
							</div>
							<span class="bg-green-100 text-green-800 px-3 py-1 rounded-full text-sm font-semibold">₱{{ number_format($salesOrder->total_amount, 2) }}</span>
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
					<div onclick="selectTransaction('{{ $purchaseOrder->order_number }}', {{ $purchaseOrder->total_amount }}, '{{ \Carbon\Carbon::parse($purchaseOrder->order_date)->format('F d, Y') }}', 'Expense', {{ $purchaseOrder->id }})" class="p-4 border border-gray-300 rounded-lg hover:bg-red-50 hover:border-red-400 cursor-pointer transition">
						<div class="flex justify-between items-start">
							<div class="flex-1">
								<h3 class="font-semibold text-gray-800">{{ $purchaseOrder->order_number }}: {{ $purchaseOrder->supplier->name ?? 'N/A' }}</h3>
								<p class="text-sm text-gray-600">{{ $purchaseOrder->notes ?? 'Purchase Order' }}</p>
							</div>
							<span class="bg-red-100 text-red-800 px-3 py-1 rounded-full text-sm font-semibold">₱{{ number_format($purchaseOrder->total_amount, 2) }}</span>
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
			const categoryFilter = document.getElementById('categoryFilter').value;
			const statusFilter = document.getElementById('statusFilter').value;
			const rows = document.querySelectorAll('.transaction-row');
			
			rows.forEach(row => {
				const rowType = row.getAttribute('data-type');
				const rowStatus = row.getAttribute('data-status');
				
				const categoryMatch = categoryFilter === 'all' || rowType === categoryFilter;
				const statusMatch = statusFilter === 'all' || rowStatus === statusFilter;
				
				if (categoryMatch && statusMatch) {
					row.style.display = '';
				} else {
					row.style.display = 'none';
				}
			});
		}

		// Attach filter event listeners
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
		function selectTransaction(reference, amount, date, type, orderId) {
			document.getElementById('confirmRef').textContent = reference;
			document.getElementById('confirmAmount').textContent = '₱' + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
			document.getElementById('confirmDate').textContent = date;
			document.getElementById('confirmType').textContent = type;
			
			// Store max amount for validation
			maxPaymentAmount = amount;
			
			// Set hidden form fields
			document.getElementById('formRef').value = reference;
			document.getElementById('formTotalAmount').value = amount;
			document.getElementById('formDate').value = date;
			document.getElementById('formType').value = type;
			document.getElementById('formOrderId').value = orderId;
			document.getElementById('paymentAmount').value = amount.toLocaleString('en-US');
			
			// Display max amount with formatting
			document.getElementById('maxAmount').textContent = '₱' + amount.toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
			
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
	</script>
	</script>
@endsection
