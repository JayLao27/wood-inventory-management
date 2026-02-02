@extends('layouts.system')

@section('main-content')
			<!-- Header with Gradient -->
			<div class="bg-gradient-to-br from-amber-50 via-amber-50 to-orange-50 p-8 border-b border-amber-100">
				<div class="max-w-7xl mx-auto">
					<h1 class="text-4xl font-bold text-gray-800 tracking-tight">Dashboard</h1>
					<p class="text-lg text-gray-600 mt-2 flex items-center gap-2">
						<svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
							<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
						</svg>
						Wood works management system
					</p>
				</div>
			</div>

			<!-- Main Content Area -->
			<div class="flex-1 p-8 bg-gradient-to-br from-amber-50 via-orange-50 to-amber-50 overflow-y-auto">
			<div class="max-w-7xl mx-auto">
				<!-- KPI Cards with Enhanced Design -->
				<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
					<!-- Active Orders -->
					<div class="bg-gradient-to-br from-slate-700 to-slate-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-slate-600">
						<div class="flex justify-between items-start">
							<div class="min-w-0 flex-1">
								<h3 class="text-sm font-medium text-slate-300 uppercase tracking-wide">Active Orders</h3>
								<p class="text-3xl xl:text-4xl font-bold mt-3 mb-2 bg-gradient-to-r from-white to-slate-200 bg-clip-text text-transparent">{{ $activeOrdersCount }}</p>
								<div class="flex items-center gap-1 mt-2">
									<svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
										<path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
									</svg>
									<p class="text-green-400 text-sm font-medium">+{{ $newOrdersThisWeek }} new this week</p>
								</div>
							</div>
							<div class="flex-shrink-0 ml-4 bg-white/10 p-3 rounded-xl backdrop-blur-sm">
								@include('components.icons.cart', ['class' => 'w-8 h-8 text-amber-400'])
							</div>
						</div>
						<div class="mt-4 pt-4 border-t border-slate-600/50">
							<div class="flex items-center justify-between text-xs text-slate-400">
								<span>Last updated</span>
								<span>Just now</span>
							</div>
						</div>
					</div>

					<!-- In Production -->
					<div class="bg-gradient-to-br from-slate-700 to-slate-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-slate-600">
						<div class="flex justify-between items-start">
							<div class="min-w-0 flex-1">
								<h3 class="text-sm font-medium text-slate-300 uppercase tracking-wide">In Production</h3>
								<p class="text-3xl xl:text-4xl font-bold mt-3 mb-2 bg-gradient-to-r from-white to-slate-200 bg-clip-text text-transparent">{{ $inProductionCount }}</p>
								<div class="flex items-center gap-1 mt-2">
									@if($overdueWorkOrders > 0)
										<svg class="w-4 h-4 text-red-400" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
										</svg>
										<p class="text-red-400 text-sm font-medium">{{ $overdueWorkOrders }} overdue</p>
									@else
										<svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
										</svg>
										<p class="text-green-400 text-sm font-medium">0 due this week</p>
									@endif
								</div>
							</div>
							<div class="flex-shrink-0 ml-4 bg-white/10 p-3 rounded-xl backdrop-blur-sm">
								@include('components.icons.time', ['class' => 'w-8 h-8 text-blue-400'])
							</div>
						</div>
						<div class="mt-4 pt-4 border-t border-slate-600/50">
							<div class="w-full bg-slate-600 rounded-full h-2 overflow-hidden">
								<div class="bg-gradient-to-r from-blue-500 to-blue-400 h-2 rounded-full transition-all duration-500" style="width: {{ $inProductionCount > 0 ? min(($inProductionCount / ($activeOrdersCount + $inProductionCount)) * 100, 100) : 0 }}%"></div>
							</div>
						</div>
					</div>

					<!-- Low Stock Items -->
					<div class="bg-gradient-to-br from-slate-700 to-slate-800 text-white p-6 rounded-2xl shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-1 border border-slate-600">
						<div class="flex justify-between items-start">
							<div class="min-w-0 flex-1">
								<h3 class="text-sm font-medium text-slate-300 uppercase tracking-wide">Low Stock</h3>
								<p class="text-3xl xl:text-4xl font-bold mt-3 mb-2 {{ $lowStockCount > 0 ? 'text-amber-400' : 'bg-gradient-to-r from-white to-slate-200 bg-clip-text text-transparent' }}">{{ $lowStockCount }}</p>
								<div class="flex items-center gap-1 mt-2">
									@if($lowStockCount > 0)
										<svg class="w-4 h-4 text-amber-400 animate-pulse" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
										</svg>
										<p class="text-amber-300 text-sm font-medium">Need attention</p>
									@else
										<svg class="w-4 h-4 text-green-400" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
										</svg>
										<p class="text-slate-400 text-sm font-medium">All good</p>
									@endif
								</div>
							</div>
							<div class="flex-shrink-0 ml-4 bg-white/10 p-3 rounded-xl backdrop-blur-sm">
								@include('components.icons.alert', ['class' => 'w-8 h-8 {{ $lowStockCount > 0 ? "text-amber-400" : "text-slate-400" }}'])
							</div>
						</div>
						<div class="mt-4 pt-4 border-t border-slate-600/50">
							<div class="flex items-center justify-between text-xs">
								<span class="text-slate-400">Inventory Status</span>
								<span class="{{ $lowStockCount > 0 ? 'text-amber-400 font-semibold' : 'text-green-400' }}">
									{{ $lowStockCount > 0 ? 'Action Required' : 'Healthy' }}
								</span>
							</div>
						</div>
					</div>
				</div>

				<!-- Charts Row with Enhanced Styling -->
				<div class="grid grid-cols-1 xl:grid-cols-2 gap-6 mb-8">
					<!-- Revenue & Expenses Chart -->
					<div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
						<div class="px-6 py-5 bg-gradient-to-r from-slate-700 to-slate-800 border-b border-slate-600">
							<div class="flex items-center justify-between">
								<div>
									<h3 class="text-lg font-semibold text-white">Revenue & Expenses</h3>
									<p class="text-sm text-slate-300 mt-1">Last 6 months comparison</p>
								</div>
								<div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
									<svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
									</svg>
								</div>
							</div>
						</div>
						<div class="p-6">
							<div class="h-80">
								<canvas id="revenueExpensesChart"></canvas>
							</div>
						</div>
					</div>

					<!-- Net Profit Chart -->
					<div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
						<div class="px-6 py-5 bg-gradient-to-r from-slate-700 to-slate-800 border-b border-slate-600">
							<div class="flex items-center justify-between">
								<div>
									<h3 class="text-lg font-semibold text-white">Net Profit</h3>
									<p class="text-sm text-slate-300 mt-1">Profit trend over 6 months</p>
								</div>
								<div class="bg-white/10 p-2 rounded-lg backdrop-blur-sm">
									<svg class="w-6 h-6 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
									</svg>
								</div>
							</div>
						</div>
						<div class="p-6">
							<div class="h-80">
								<canvas id="netProfitChart"></canvas>
							</div>
						</div>
					</div>
				</div>

				<!-- Low Stock Alerts & Sales Report -->
				<div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
					<!-- Low Stock Alerts -->
					<div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
						<div class="px-6 py-5 bg-gradient-to-r from-slate-700 to-slate-800">
							<div class="flex items-center justify-between">
								<div>
									<h3 class="text-lg font-semibold text-white flex items-center gap-2">
										<svg class="w-5 h-5 text-amber-400" fill="currentColor" viewBox="0 0 20 20">
											<path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
										</svg>
										Low Stock Alerts
									</h3>
									<p class="text-sm text-slate-300 mt-1">Items at or below minimum stock</p>
								</div>
								@if($lowStockCount > 0)
									<span class="bg-amber-500 text-white text-xs font-bold px-3 py-1 rounded-full">{{ $lowStockCount }}</span>
								@endif
							</div>
						</div>
						<div class="p-6 max-h-96 overflow-y-auto custom-scrollbar">
							@if ($lowStockMaterials->isEmpty() && $lowStockProducts->isEmpty())
								<div class="text-center py-12">
									<svg class="w-16 h-16 text-green-500 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
									</svg>
									<p class="text-slate-500 font-medium">No low stock items</p>
									<p class="text-slate-400 text-sm mt-1">All inventory levels are healthy</p>
								</div>
							@else
								<ul class="space-y-3">
									@foreach ($lowStockMaterials as $m)
										<li class="group hover:scale-[1.02] transition-transform duration-200">
											<div class="flex items-center justify-between py-3 px-4 rounded-xl bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 shadow-sm hover:shadow-md transition-shadow">
												<div class="flex items-center gap-3">
													<div class="bg-amber-500 text-white p-2 rounded-lg">
														<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
														</svg>
													</div>
													<div>
														<span class="font-semibold text-gray-800 block">{{ $m->name }}</span>
														<span class="text-slate-500 text-xs">Material</span>
													</div>
												</div>
												<div class="text-right">
													<div class="flex items-baseline gap-1">
														<span class="text-red-600 font-bold text-lg">{{ number_format($m->current_stock, 2) }}</span>
														<span class="text-slate-400 text-sm">/ {{ number_format($m->minimum_stock, 2) }}</span>
													</div>
													<span class="text-slate-500 text-xs">{{ $m->unit }}</span>
												</div>
											</div>
										</li>
									@endforeach
									@foreach ($lowStockProducts as $p)
										<li class="group hover:scale-[1.02] transition-transform duration-200">
											<div class="flex items-center justify-between py-3 px-4 rounded-xl bg-gradient-to-r from-amber-50 to-orange-50 border-2 border-amber-200 shadow-sm hover:shadow-md transition-shadow">
												<div class="flex items-center gap-3">
													<div class="bg-orange-500 text-white p-2 rounded-lg">
														<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
															<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4" />
														</svg>
													</div>
													<div>
														<span class="font-semibold text-gray-800 block">{{ $p->product_name }}</span>
														<span class="text-slate-500 text-xs">Product</span>
													</div>
												</div>
												<div class="text-right">
													<div class="flex items-baseline gap-1">
														<span class="text-red-600 font-bold text-lg">{{ number_format($p->current_stock, 2) }}</span>
														<span class="text-slate-400 text-sm">/ {{ number_format($p->minimum_stock, 2) }}</span>
													</div>
													<span class="text-slate-500 text-xs">{{ $p->unit }}</span>
												</div>
											</div>
										</li>
									@endforeach
								</ul>
								<a href="{{ route('inventory') }}" class="inline-flex items-center gap-2 mt-5 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-medium text-sm rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
									<span>View inventory</span>
									<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
										<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
									</svg>
								</a>
							@endif
						</div>
					</div>

					<!-- Sales Report -->
					<div class="bg-white rounded-2xl shadow-xl border border-slate-200 overflow-hidden hover:shadow-2xl transition-shadow duration-300">
						<div class="px-6 py-5 bg-gradient-to-r from-slate-700 to-slate-800">
							<div class="flex items-center justify-between">
								<div>
									<h3 class="text-lg font-semibold text-white flex items-center gap-2">
										<svg class="w-5 h-5 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
											<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
										</svg>
										Sales Report
									</h3>
									<p class="text-sm text-slate-300 mt-1">Monthly revenue & expenses</p>
								</div>
							</div>
						</div>
						<div class="overflow-x-auto custom-scrollbar max-h-96">
							<table class="w-full text-left">
								<thead class="sticky top-0 z-10">
									<tr class="bg-gradient-to-r from-slate-50 to-slate-100 border-b-2 border-slate-300">
										<th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider">Month</th>
										<th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider text-right">Revenue</th>
										<th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider text-right">Expenses</th>
										<th class="px-6 py-4 text-xs font-bold text-slate-700 uppercase tracking-wider text-right">Profit</th>
									</tr>
								</thead>
								<tbody>
									@foreach ($salesReportMonths as $i => $month)
										@php
											$rev = $salesReportRevenue[$i] ?? 0;
											$exp = $salesReportExpenses[$i] ?? 0;
											$profit = $rev - $exp;
										@endphp
										<tr class="border-b border-slate-100 hover:bg-gradient-to-r hover:from-amber-50 hover:to-orange-50 transition-colors duration-150">
											<td class="px-6 py-4 text-gray-800 font-medium">{{ $month }}</td>
											<td class="px-6 py-4 text-right">
												<span class="inline-flex items-center gap-1 font-semibold text-green-700">
													<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
														<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-11a1 1 0 10-2 0v2H7a1 1 0 100 2h2v2a1 1 0 102 0v-2h2a1 1 0 100-2h-2V7z" clip-rule="evenodd" />
													</svg>
													₱{{ number_format($rev, 2) }}
												</span>
											</td>
											<td class="px-6 py-4 text-right">
												<span class="inline-flex items-center gap-1 font-semibold text-red-700">
													<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
														<path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM7 9a1 1 0 000 2h6a1 1 0 100-2H7z" clip-rule="evenodd" />
													</svg>
													₱{{ number_format($exp, 2) }}
												</span>
											</td>
											<td class="px-6 py-4 text-right">
												<span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-sm font-bold {{ $profit >= 0 ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
													@if($profit >= 0)
														<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
															<path fill-rule="evenodd" d="M12 7a1 1 0 110-2h5a1 1 0 011 1v5a1 1 0 11-2 0V8.414l-4.293 4.293a1 1 0 01-1.414 0L8 10.414l-4.293 4.293a1 1 0 01-1.414-1.414l5-5a1 1 0 011.414 0L11 10.586 14.586 7H12z" clip-rule="evenodd" />
														</svg>
													@else
														<svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
															<path fill-rule="evenodd" d="M12 13a1 1 0 100 2h5a1 1 0 001-1V9a1 1 0 10-2 0v2.586l-4.293-4.293a1 1 0 00-1.414 0L8 9.586 3.707 5.293a1 1 0 00-1.414 1.414l5 5a1 1 0 001.414 0L11 9.414 14.586 13H12z" clip-rule="evenodd" />
														</svg>
													@endif
													₱{{ number_format($profit, 2) }}
												</span>
											</td>
										</tr>
									@endforeach
								</tbody>
							</table>
						</div>
						<div class="px-6 py-4 bg-gradient-to-r from-slate-50 to-slate-100 border-t-2 border-slate-200">
							<a href="{{ route('accounting') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-orange-600 to-orange-700 hover:from-orange-700 hover:to-orange-800 text-white font-medium text-sm rounded-lg shadow-md hover:shadow-lg transition-all duration-200">
								<span>View accounting</span>
								<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
									<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
								</svg>
							</a>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Custom Scrollbar Styles -->
		<style>
			.custom-scrollbar::-webkit-scrollbar {
				width: 8px;
				height: 8px;
			}
			.custom-scrollbar::-webkit-scrollbar-track {
				background: #f1f5f9;
				border-radius: 4px;
			}
			.custom-scrollbar::-webkit-scrollbar-thumb {
				background: #cbd5e1;
				border-radius: 4px;
			}
			.custom-scrollbar::-webkit-scrollbar-thumb:hover {
				background: #94a3b8;
			}
		</style>

		<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
			<script>
				document.addEventListener('DOMContentLoaded', function () {
					const labels = @json($chartLabels);
					const revenue = @json($chartRevenue);
					const expenses = @json($chartExpenses);
					const profit = @json($chartProfit);

					// Chart defaults for better appearance
					Chart.defaults.font.family = "'Inter', 'system-ui', sans-serif";
					Chart.defaults.color = '#64748b';

					// Revenue & Expenses (bar) with gradient
					const revExpCtx = document.getElementById('revenueExpensesChart');
					if (revExpCtx) {
						const ctx = revExpCtx.getContext('2d');
						
						// Create gradients
						const revenueGradient = ctx.createLinearGradient(0, 0, 0, 400);
						revenueGradient.addColorStop(0, 'rgba(34, 197, 94, 0.8)');
						revenueGradient.addColorStop(1, 'rgba(34, 197, 94, 0.4)');
						
						const expensesGradient = ctx.createLinearGradient(0, 0, 0, 400);
						expensesGradient.addColorStop(0, 'rgba(239, 68, 68, 0.8)');
						expensesGradient.addColorStop(1, 'rgba(239, 68, 68, 0.4)');

						new Chart(revExpCtx, {
							type: 'bar',
							data: {
								labels,
								datasets: [
									{ 
										label: 'Revenue', 
										data: revenue, 
										backgroundColor: revenueGradient,
										borderColor: 'rgb(22, 163, 74)',
										borderWidth: 2,
										borderRadius: 8,
										borderSkipped: false
									},
									{ 
										label: 'Expenses', 
										data: expenses, 
										backgroundColor: expensesGradient,
										borderColor: 'rgb(220, 38, 38)',
										borderWidth: 2,
										borderRadius: 8,
										borderSkipped: false
									}
								]
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								interaction: {
									mode: 'index',
									intersect: false,
								},
								plugins: { 
									legend: { 
										position: 'top',
										labels: {
											usePointStyle: true,
											pointStyle: 'circle',
											padding: 20,
											font: {
												size: 13,
												weight: '600'
											}
										}
									},
									tooltip: {
										backgroundColor: 'rgba(15, 23, 42, 0.9)',
										padding: 12,
										titleFont: {
											size: 14,
											weight: 'bold'
										},
										bodyFont: {
											size: 13
										},
										borderColor: 'rgba(148, 163, 184, 0.3)',
										borderWidth: 1,
										displayColors: true,
										callbacks: {
											label: function(context) {
												let label = context.dataset.label || '';
												if (label) {
													label += ': ';
												}
												label += '₱' + Number(context.parsed.y).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
												return label;
											}
										}
									}
								},
								scales: {
									x: {
										grid: {
											display: false
										},
										ticks: {
											font: {
												size: 12,
												weight: '500'
											}
										}
									},
									y: { 
										beginAtZero: true,
										grid: {
											color: 'rgba(148, 163, 184, 0.1)',
											drawBorder: false
										},
										border: {
											display: false
										},
										ticks: { 
											callback: v => '₱' + Number(v).toLocaleString(),
											font: {
												size: 12
											},
											padding: 8
										}
									}
								}
							}
						});
					}

					// Net Profit (line) with enhanced styling
					const profitCtx = document.getElementById('netProfitChart');
					if (profitCtx) {
						const ctx = profitCtx.getContext('2d');
						
						// Create gradient for area fill
						const profitGradient = ctx.createLinearGradient(0, 0, 0, 400);
						profitGradient.addColorStop(0, 'rgba(59, 130, 246, 0.3)');
						profitGradient.addColorStop(1, 'rgba(59, 130, 246, 0.01)');

						new Chart(profitCtx, {
							type: 'line',
							data: {
								labels,
								datasets: [{
									label: 'Net Profit',
									data: profit,
									borderColor: 'rgb(59, 130, 246)',
									backgroundColor: profitGradient,
									fill: true,
									tension: 0.4,
									borderWidth: 3,
									pointBackgroundColor: profit.map(p => p >= 0 ? 'rgb(34, 197, 94)' : 'rgb(239, 68, 68)'),
									pointBorderColor: '#fff',
									pointBorderWidth: 2,
									pointRadius: 6,
									pointHoverRadius: 8,
									pointHoverBorderWidth: 3
								}]
							},
							options: {
								responsive: true,
								maintainAspectRatio: false,
								interaction: {
									mode: 'index',
									intersect: false,
								},
								plugins: { 
									legend: { 
										position: 'top',
										labels: {
											usePointStyle: true,
											pointStyle: 'circle',
											padding: 20,
											font: {
												size: 13,
												weight: '600'
											}
										}
									},
									tooltip: {
										backgroundColor: 'rgba(15, 23, 42, 0.9)',
										padding: 12,
										titleFont: {
											size: 14,
											weight: 'bold'
										},
										bodyFont: {
											size: 13
										},
										borderColor: 'rgba(148, 163, 184, 0.3)',
										borderWidth: 1,
										displayColors: true,
										callbacks: {
											label: function(context) {
												let label = context.dataset.label || '';
												if (label) {
													label += ': ';
												}
												const value = context.parsed.y;
												label += '₱' + Number(value).toLocaleString('en-US', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
												return label;
											},
											afterLabel: function(context) {
												const value = context.parsed.y;
												return value >= 0 ? '↑ Profit' : '↓ Loss';
											}
										}
									}
								},
								scales: {
									x: {
										grid: {
											display: false
										},
										ticks: {
											font: {
												size: 12,
												weight: '500'
											}
										}
									},
									y: {
										beginAtZero: true,
										grid: {
											color: 'rgba(148, 163, 184, 0.1)',
											drawBorder: false
										},
										border: {
											display: false
										},
										ticks: {
											callback: v => '₱' + Number(v).toLocaleString(),
											font: {
												size: 12
											},
											padding: 8
										}
									}
								}
							}
						});
					}
				});
			</script>
@endsection