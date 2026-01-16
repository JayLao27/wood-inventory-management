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
							<div >
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
								<p class="text-green-400 text-sm mt-1">+12 new this week</p>
							</div>
							<div >
								@include('components.icons.cart', ['class' => 'icon-cart'])
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
							<div >
								@include('components.icons.time', ['class' => 'icon-time'])
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
							<div >
								@include('components.icons.alert', ['class' => 'icon-alert'])
							</div>
						</div>
					</div>
				</div>


@endsection
