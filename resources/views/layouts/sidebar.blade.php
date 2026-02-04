<!-- Sidebar -->
<div class="w-64 bg-slate-700 text-white flex flex-col relative z-40">
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
                <a href="{{ route('dashboard') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('dashboard') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-600 hover:text-white' }} transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                    </svg>
                    <span>Dashboard</span>
                </a>
            </li>

            @if(auth()->user()->hasAnyRole(['admin', 'inventory_clerk', 'procurement_officer']))
              <li>
                <a href="{{ route('inventory') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('inventory') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-600 hover:text-white' }} transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                    </svg>
                    <span>Inventory</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole(['admin', 'workshop_staff']))
            <li>
                <a href="{{ route('production') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('production') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-600 hover:text-white' }} transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                    </svg>
                    <span>Production</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole(['admin', 'sales_clerk']))
            <li>
                <a href="{{ route('sales-orders.index') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('sales-orders.*') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-600 hover:text-white' }} transition">
                   @include('components.icons.cart', ['class' => 'w-5 h-5'])
                    <span>Sales & Orders</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole(['admin', 'procurement_officer', 'inventory_clerk']))
            <li>
                <a href="{{ route('procurement') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('procurement') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-600 hover:text-white' }} transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                        <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                    </svg>
                    <span>Procurement</span>
                </a>
            </li>
            @endif

            @if(auth()->user()->hasAnyRole(['admin', 'accounting_staff']))
            <li>
                <a href="{{ route('accounting') }}" class="flex items-center space-x-3 px-4 py-3 rounded-lg {{ request()->routeIs('accounting') ? 'bg-orange-500 text-white' : 'text-slate-300 hover:bg-slate-600 hover:text-white' }} transition">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                    </svg>
                    <span>Accounting</span>
                </a>
            </li>
            @endif
        </ul>
    </nav>

    <!-- Footer -->
    <div class="mt-auto p-4 border-t border-slate-600">
        <!-- Logout Button -->
        <form method="POST" action="{{ route('logout') }}" class="mb-3">
            @csrf
            <button type="submit" onclick="event.preventDefault(); this.closest('form').submit();" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition text-sm font-medium">
                {{ __('Log Out') }}
            </button>
        </form>
        <p class="text-xs text-slate-400">© 2025 RM Woodworks</p>
    </div>
</div>

