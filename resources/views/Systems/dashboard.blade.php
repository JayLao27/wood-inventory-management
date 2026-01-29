@extends('layouts.system')

@section('main-content')
			<!-- Header -->
			<div class="bg-amber-50 p-8">
			<h1 class="text-5xl font-bold text-gray-900">Dashboard</h1>
			<p class="text-xl text-gray-700 mt-2 font-medium">Wood works management system</p>
		</div>

			<!-- Main Content Area -->
			<div class="flex-1 p-8 bg-amber-50 overflow-y-auto">
			<div class="max-w-7xl mx-auto">
				<!-- KPI Cards -->
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
					<div class="bg-slate-700 text-white p-6 rounded-xl shadow-lg ">
						<div class="flex justify-between items-start">
							<div class="min-w-0">
							<h3 class="text-base font-semibold text-slate-100">Active Orders</h3>
							<p class="text-4xl xl:text-5xl font-bold mt-3 text-white">{{ $activeOrdersCount }}</p>
							<p class="text-green-300 text-base font-medium mt-2">+{{ $newOrdersThisWeek }} new this week</p>
							</div>
							<div class="flex-shrink-0 ml-2">@include('components.icons.cart', ['class' => 'w-9 h-9'])</div>
						</div>
					</div>

					<!-- In Production -->
					<div class="bg-slate-700 text-white p-6 rounded-xl shadow-lg">
						<div class="flex justify-between items-start">
							<div class="min-w-0">
							<h3 class="text-base font-semibold text-slate-100">In Production</h3>
							<p class="text-4xl xl:text-5xl font-bold mt-3 text-white">{{ $inProductionCount }}</p>
							<p class="text-base font-medium mt-2 {{ $overdueWorkOrders > 0 ? 'text-red-300' : 'text-green-300' }}">
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
							<h3 class="text-base font-semibold text-slate-100">Low Stock</h3>
							<p class="text-4xl xl:text-5xl font-bold mt-3 {{ $lowStockCount > 0 ? 'text-amber-300' : 'text-white' }}">{{ $lowStockCount }}</p>
							<p class="text-base font-medium mt-2 {{ $lowStockCount > 0 ? 'text-amber-200' : 'text-slate-300' }}">
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
					<h3 class="text-2xl font-bold text-gray-900 mb-4">Revenue & Expenses (Last 6 Months)</h3>
						<div class="h-72">
							<canvas id="revenueExpensesChart"></canvas>
						</div>
					</div>
					<!-- Net Profit Chart -->
					<div class="bg-white rounded-xl shadow-lg border border-slate-200 p-6">
					<h3 class="text-2xl font-bold text-gray-900 mb-4">Net Profit (Last 6 Months)</h3>
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
						<h3 class="text-2xl font-bold text-white">Low Stock Alerts</h3>
						<p class="text-base text-slate-200 font-medium">Items at or below minimum stock</p>
						</div>
						<div class="p-6 max-h-80 overflow-y-auto">
							@if ($lowStockMaterials->isEmpty() && $lowStockProducts->isEmpty())
								<p class="text-slate-500 text-center py-8">No low stock items.</p>
							@else
								<ul class="space-y-3">
									@foreach ($lowStockMaterials as $m)
									<li class="flex items-center justify-between py-3 px-4 rounded-lg bg-amber-50 border border-amber-300 mb-2">
										<div>
											<span class="font-bold text-gray-900 text-base">{{ $m->name }}</span>
											<span class="text-slate-600 text-sm ml-2 font-medium">(Material)</span>
										</div>
										<div class="text-right">
											<span class="text-red-700 font-bold text-base">{{ number_format($m->current_stock, 2) }}</span>
											<span class="text-slate-600 font-medium text-sm">/ {{ number_format($m->minimum_stock, 2) }} {{ $m->unit }}</span>
											</div>
										</li>
									@endforeach
									@foreach ($lowStockProducts as $p)
									<li class="flex items-center justify-between py-3 px-4 rounded-lg bg-amber-50 border border-amber-300 mb-2">
										<div>
											<span class="font-bold text-gray-900 text-base">{{ $p->product_name }}</span>
											<span class="text-slate-600 text-sm ml-2 font-medium">(Product)</span>
										</div>
										<div class="text-right">
											<span class="text-red-700 font-bold text-base">{{ number_format($p->current_stock, 2) }}</span>
											<span class="text-slate-600 font-medium text-sm">/ {{ number_format($p->minimum_stock, 2) }} {{ $p->unit }}</span>
											</div>
										</li>
									@endforeach
								</ul>
								<a href="{{ route('inventory') }}" class="inline-block mt-4 text-orange-700 hover:text-orange-900 font-bold text-base">View inventory →</a>
							@endif
						</div>
					</div>

					<!-- Sales Report -->
					<div class="bg-white rounded-xl shadow-lg border border-slate-200 overflow-hidden">
						<div class="px-6 py-4 bg-slate-700">
						<h3 class="text-2xl font-bold text-white">Sales Report</h3>
						<p class="text-base text-slate-200 font-medium">Monthly revenue & expenses</p>
						</div>
						<div class="overflow-x-auto">
							<table class="w-full text-left">
								<thead>
								<tr class="bg-slate-100 border-b border-slate-300">
									<th class="px-6 py-4 text-sm font-bold text-slate-800 uppercase">Month</th>
									<th class="px-6 py-4 text-sm font-bold text-slate-800 uppercase text-right">Revenue</th>
									<th class="px-6 py-4 text-sm font-bold text-slate-800 uppercase text-right">Expenses</th>
									<th class="px-6 py-4 text-sm font-bold text-slate-800 uppercase text-right">Profit</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($salesReportMonths as $i => $month)
										@php
											$rev = $salesReportRevenue[$i] ?? 0;
											$exp = $salesReportExpenses[$i] ?? 0;
											$profit = $rev - $exp;
										@endphp
									<tr class="border-b border-slate-200 hover:bg-slate-50">
										<td class="px-6 py-4 text-gray-900 font-medium">{{ $month }}</td>
										<td class="px-6 py-4 text-right font-bold text-green-700 text-base">₱{{ number_format($rev, 2) }}</td>
										<td class="px-6 py-4 text-right font-bold text-red-700 text-base">₱{{ number_format($exp, 2) }}</td>
										<td class="px-6 py-4 text-right font-bold text-base {{ $profit >= 0 ? 'text-green-700' : 'text-red-700' }}">₱{{ number_format($profit, 2) }}</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="px-6 py-4 bg-slate-50 border-t border-slate-200">
							<a href="{{ route('accounting') }}" class="text-orange-700 hover:text-orange-900 font-bold text-base">View accounting →</a>
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
