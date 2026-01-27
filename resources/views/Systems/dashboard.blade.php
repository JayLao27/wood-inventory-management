@extends('layouts.system')

@section('main-content')
			<!-- Header -->
			<div class="bg-amber-50 p-8">
				<h1 class="text-4xl font-bold text-gray-800">Dashboard</h1>
				<p class="text-lg text-gray-600 mt-2">Wood works management system</p>
			</div>

			<!-- Main Content Area -->
			<div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
			<div class="max-w-7xl mx-auto">
				<!-- KPI Cards -->
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
					<div class="bg-slate-700 text-white p-6 rounded-xl shadow-lg ">
						<div class="flex justify-between items-start">
							<div class="min-w-0">
								<h3 class="text-sm font-medium text-slate-300">Active Orders</h3>
								<p class="text-2xl xl:text-3xl font-bold mt-2">{{ $activeOrdersCount }}</p>
								<p class="text-green-400 text-sm mt-1">+{{ $newOrdersThisWeek }} new this week</p>
							</div>
							<div class="flex-shrink-0 ml-2">@include('components.icons.cart', ['class' => 'w-9 h-9'])</div>
						</div>
					</div>

					<!-- In Production -->
					<div class="bg-slate-700 text-white p-6 rounded-xl shadow-lg">
						<div class="flex justify-between items-start">
							<div class="min-w-0">
								<h3 class="text-sm font-medium text-slate-300">In Production</h3>
								<p class="text-2xl xl:text-3xl font-bold mt-2">{{ $inProductionCount }}</p>
								<p class="text-sm mt-1 {{ $overdueWorkOrders > 0 ? 'text-red-400' : 'text-green-400' }}">
									{{ $overdueWorkOrders > 0 ? $overdueWorkOrders . ' overdue' : '0 due this week' }}
								</p>
							</div>
							<div class="flex-shrink-0 ml-2">@include('components.icons.time', ['class' => 'w-9 h-9'])</div>
						</div>
					</div>

					<!-- Low Stock Items -->
					<div class="bg-slate-700 text-white p-6 rounded-xl shadow-lg">
						<div class="flex justify-between items-start">
							<div class="min-w-0">
								<h3 class="text-sm font-medium text-slate-300">Low Stock</h3>
								<p class="text-2xl xl:text-3xl font-bold mt-2 {{ $lowStockCount > 0 ? 'text-amber-400' : '' }}">{{ $lowStockCount }}</h3>
								<p class="text-sm mt-1 {{ $lowStockCount > 0 ? 'text-amber-300' : 'text-slate-400' }}">
									{{ $lowStockCount > 0 ? 'Need attention' : 'All good' }}
								</p>
							</div>
							<div class="flex-shrink-0 ml-2">@include('components.icons.alert', ['class' => 'w-9 h-9'])</div>
						</div>
					</div>
				</div>

				<!-- Charts Row -->
				<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
					<!-- Revenue & Expenses Chart -->
					<div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
						<h3 class="text-lg font-semibold text-gray-800 mb-4">Revenue & Expenses (Last 6 Months)</h3>
						<div class="h-72">
							<canvas id="revenueExpensesChart"></canvas>
						</div>
					</div>
					<!-- Net Profit Chart -->
					<div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
						<h3 class="text-lg font-semibold text-gray-800 mb-4">Net Profit (Last 6 Months)</h3>
						<div class="h-72">
							<canvas id="netProfitChart"></canvas>
						</div>
					</div>
				</div>

				<!-- Low Stock Alerts & Sales Report -->
				<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
					<!-- Low Stock Alerts -->
					<div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
						<div class="px-6 py-4 bg-slate-700">
							<h3 class="text-lg font-semibold text-white">Low Stock Alerts</h3>
							<p class="text-sm text-slate-300">Items at or below minimum stock</p>
						</div>
						<div class="p-6 max-h-80 overflow-y-auto">
							@if ($lowStockMaterials->isEmpty() && $lowStockProducts->isEmpty())
								<p class="text-slate-500 text-center py-8">No low stock items.</p>
							@else
								<ul class="space-y-3">
									@foreach ($lowStockMaterials as $m)
										<li class="flex items-center justify-between py-2 px-3 rounded-lg bg-amber-50 border border-amber-200">
											<div>
												<span class="font-medium text-gray-800">{{ $m->name }}</span>
												<span class="text-slate-500 text-sm ml-2">(Material)</span>
											</div>
											<div class="text-right">
												<span class="text-red-600 font-semibold">{{ number_format($m->current_stock, 2) }}</span>
												<span class="text-slate-400">/ {{ number_format($m->minimum_stock, 2) }} {{ $m->unit }}</span>
											</div>
										</li>
									@endforeach
									@foreach ($lowStockProducts as $p)
										<li class="flex items-center justify-between py-2 px-3 rounded-lg bg-amber-50 border border-amber-200">
											<div>
												<span class="font-medium text-gray-800">{{ $p->product_name }}</span>
												<span class="text-slate-500 text-sm ml-2">(Product)</span>
											</div>
											<div class="text-right">
												<span class="text-red-600 font-semibold">{{ number_format($p->current_stock, 2) }}</span>
												<span class="text-slate-400">/ {{ number_format($p->minimum_stock, 2) }} {{ $p->unit }}</span>
											</div>
										</li>
									@endforeach
								</ul>
								<a href="{{ route('inventory') }}" class="inline-block mt-4 text-orange-600 hover:text-orange-700 font-medium text-sm">View inventory →</a>
							@endif
						</div>
					</div>

					<!-- Sales Report -->
					<div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
						<div class="px-6 py-4 bg-slate-700">
							<h3 class="text-lg font-semibold text-white">Sales Report</h3>
							<p class="text-sm text-slate-300">Monthly revenue & expenses</p>
						</div>
						<div class="overflow-x-auto">
							<table class="w-full text-left">
								<thead>
									<tr class="bg-slate-50 border-b border-slate-200">
										<th class="px-6 py-3 text-xs font-semibold text-slate-600 uppercase">Month</th>
										<th class="px-6 py-3 text-xs font-semibold text-slate-600 uppercase text-right">Revenue</th>
										<th class="px-6 py-3 text-xs font-semibold text-slate-600 uppercase text-right">Expenses</th>
										<th class="px-6 py-3 text-xs font-semibold text-slate-600 uppercase text-right">Profit</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($salesReportMonths as $i => $month)
										@php
											$rev = $salesReportRevenue[$i] ?? 0;
											$exp = $salesReportExpenses[$i] ?? 0;
											$profit = $rev - $exp;
										@endphp
										<tr class="border-b border-slate-100 hover:bg-slate-50">
											<td class="px-6 py-3 text-gray-800">{{ $month }}</td>
											<td class="px-6 py-3 text-right font-medium text-green-700">₱{{ number_format($rev, 2) }}</td>
											<td class="px-6 py-3 text-right font-medium text-red-700">₱{{ number_format($exp, 2) }}</td>
											<td class="px-6 py-3 text-right font-medium {{ $profit >= 0 ? 'text-green-700' : 'text-red-700' }}">₱{{ number_format($profit, 2) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="px-6 py-3 bg-slate-50 border-t border-slate-200">
							<a href="{{ route('accounting') }}" class="text-orange-600 hover:text-orange-700 font-medium text-sm">View accounting →</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
			<script>
				document.addEventListener('DOMContentLoaded', function () {
					const labels = @json($chartLabels);
					const revenue = @json($chartRevenue);
					const expenses = @json($chartExpenses);
					const profit = @json($chartProfit);

					// Revenue & Expenses (bar)
					const revExpCtx = document.getElementById('revenueExpensesChart');
					if (revExpCtx) {
						new Chart(revExpCtx, {
							type: 'bar',
							data: {
								labels,
								datasets: [
									{ label: 'Revenue', data: revenue, backgroundColor: 'rgba(34, 197, 94, 0.7)', borderColor: 'rgb(22, 163, 74)', borderWidth: 1 },
									{ label: 'Expenses', data: expenses, backgroundColor: 'rgba(239, 68, 68, 0.7)', borderColor: 'rgb(220, 38, 38)', borderWidth: 1 }
								]
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								plugins: { legend: { position: 'top' } },
								scales: {
									y: { beginAtZero: true, ticks: { callback: v => '₱' + Number(v).toLocaleString() } }
								}
							}
						});
					}

					// Net Profit (line)
					const profitCtx = document.getElementById('netProfitChart');
					if (profitCtx) {
						new Chart(profitCtx, {
							type: 'line',
							data: {
								labels,
								datasets: [{
									label: 'Net Profit',
									data: profit,
									borderColor: 'rgb(59, 130, 246)',
									backgroundColor: 'rgba(59, 130, 246, 0.1)',
									fill: true,
									tension: 0.3,
									pointBackgroundColor: profit.map(p => p >= 0 ? 'rgb(34, 197, 94)' : 'rgb(239, 68, 68)')
								}]
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								plugins: { legend: { position: 'top' } },
								scales: {
									y: {
										beginAtZero: true,
										ticks: { callback: v => '₱' + Number(v).toLocaleString() }
									}
								}
							}
						});
					}
				});
			</script>
@endsection
