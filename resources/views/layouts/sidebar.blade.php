<!-- Sidebar with Toggle Functionality + Persistent State -->
<div x-data="{ 
    sidebarOpen: localStorage.getItem('sidebarOpen') !== 'false',
    toggleSidebar() {
        this.sidebarOpen = !this.sidebarOpen;
        localStorage.setItem('sidebarOpen', this.sidebarOpen);
    }
}" class="relative">
    <!-- Sidebar -->
    <div :class="sidebarOpen ? 'w-72' : 'w-20'" 
         class="bg-gradient-to-b from-slate-800 to-slate-900 text-white flex flex-col relative z-40 transition-all duration-300 ease-in-out shadow-2xl h-screen">
        
        <!-- Toggle Button -->
        <button @click="toggleSidebar()" 
                class="absolute -right-3 top-8 bg-[#6c4545] hover:bg-orange-600 text-white rounded-full p-2 shadow-lg transition-all duration-300 z-50">
            <svg x-show="sidebarOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
            </svg>
            <svg x-show="!sidebarOpen" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
            </svg>
        </button>

        <!-- Logo Section -->
        <div class="p-6 border-b border-slate-700">
            <div class="flex items-center" :class="sidebarOpen ? 'space-x-3' : 'justify-center'">
               <div class="mt-4 w-12 h-12 bg-gradient-to-br from-[#a87958] to-[#9f9690] rounded-2xl flex items-center justify-center mb-4 shadow-lg">
						<img src="/images/logo.png" alt="RM Wood Works" class="w-10 h-10 object-contain">
					</div>
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="overflow-hidden">
                    <h1 class="text-xl font-bold tracking-tight">RM WOOD WORKS</h1>
                    <p class="text-sm text-slate-400">Management System</p>
                </div>
            </div>
        </div>

        <!-- User Info -->
        <div class="px-4 py-4 border-b border-slate-700">
            <div class="flex items-center" :class="sidebarOpen ? 'space-x-3' : 'justify-center'">
                <div class="w-10 h-10 bg-gradient-to-br from-[#101010] to-[#807a7a] rounded-full flex items-center justify-center text-white font-semibold text-sm flex-shrink-0">
                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
                </div>
                <div x-show="sidebarOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0"
                     x-transition:enter-end="opacity-100"
                     class="overflow-hidden">
                    <p class="text-sm font-semibold truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs text-slate-400 truncate">{{ ucfirst(str_replace('_', ' ', auth()->user()->role ?? 'User')) }}</p>
                </div>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="flex-1 p-4 overflow-y-auto">
            <ul class="space-y-2">
                <!-- Dashboard - Available to All -->
                <li>
                    <a href="{{ route('dashboard') }}" 
                       class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('dashboard') ? 'bg-gradient-to-r from-[#E17100] to-[#531b1b] text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                       :class="sidebarOpen ? 'space-x-4' : 'justify-center'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"/>
                        </svg>
                        <span x-show="sidebarOpen" 
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100"
                              class="font-medium">Dashboard</span>
                        
                        <!-- Tooltip for collapsed state -->
                        <div x-show="!sidebarOpen" 
                             class="absolute left-full ml-2 px-3 py-2 bg-slate-900 text-white text-sm rounded-lg shadow-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                            Dashboard
                        </div>
                    </a>
                </li>

                @if(auth()->user()->hasAnyRole(['admin', 'inventory_clerk', 'procurement_officer']))
                <li>
                    <a href="{{ route('inventory') }}" 
                       class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('inventory') ? 'bg-gradient-to-r from-[#E17100] to-[#531b1b] text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                       :class="sidebarOpen ? 'space-x-4' : 'justify-center'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M3 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zm0 4a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"/>
                        </svg>
                        <span x-show="sidebarOpen" 
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100"
                              class="font-medium">Inventory</span>
                        
                        <div x-show="!sidebarOpen" 
                             class="absolute left-full ml-2 px-3 py-2 bg-slate-900 text-white text-sm rounded-lg shadow-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                            Inventory
                        </div>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['admin', 'workshop_staff']))
                <li>
                    <a href="{{ route('production') }}" 
                       class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('production') ? 'bg-gradient-to-r from-[#E17100] to-[#531b1b] text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                       :class="sidebarOpen ? 'space-x-4' : 'justify-center'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"/>
                        </svg>
                        <span x-show="sidebarOpen" 
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100"
                              class="font-medium">Production</span>
                        
                        <div x-show="!sidebarOpen" 
                             class="absolute left-full ml-2 px-3 py-2 bg-slate-900 text-white text-sm rounded-lg shadow-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                            Production
                        </div>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['admin', 'sales_clerk']))
                <li>
                    <a href="{{ route('sales-orders.index') }}" 
                       class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('sales-orders.*') ? 'bg-gradient-to-r from-[#E17100] to-[#531b1b] text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                       :class="sidebarOpen ? 'space-x-4' : 'justify-center'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M3 1a1 1 0 000 2h1.22l.305 1.222a.997.997 0 00.01.042l1.358 5.43-.893.892C3.74 11.846 4.632 14 6.414 14H15a1 1 0 000-2H6.414l1-1H14a1 1 0 00.894-.553l3-6A1 1 0 0017 3H6.28l-.31-1.243A1 1 0 005 1H3zM16 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM6.5 18a1.5 1.5 0 100-3 1.5 1.5 0 000 3z"/>
                        </svg>
                        <span x-show="sidebarOpen" 
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100"
                              class="font-medium">Sales & Orders</span>
                        
                        <div x-show="!sidebarOpen" 
                             class="absolute left-full ml-2 px-3 py-2 bg-slate-900 text-white text-sm rounded-lg shadow-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                            Sales & Orders
                        </div>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['admin', 'procurement_officer', 'inventory_clerk']))
                <li>
                    <a href="{{ route('procurement') }}" 
                       class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('procurement') ? 'bg-gradient-to-r from-[#E17100] to-[#531b1b] text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                       :class="sidebarOpen ? 'space-x-4' : 'justify-center'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0zM15 16.5a1.5 1.5 0 11-3 0 1.5 1.5 0 013 0z"/>
                            <path d="M3 4a1 1 0 00-1 1v10a1 1 0 001 1h1.05a2.5 2.5 0 014.9 0H10a1 1 0 001-1V5a1 1 0 00-1-1H3zM14 7a1 1 0 00-1 1v6.05A2.5 2.5 0 0115.95 16H17a1 1 0 001-1V8a1 1 0 00-1-1h-3z"/>
                        </svg>
                        <span x-show="sidebarOpen" 
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100"
                              class="font-medium">Procurement</span>
                        
                        <div x-show="!sidebarOpen" 
                             class="absolute left-full ml-2 px-3 py-2 bg-slate-900 text-white text-sm rounded-lg shadow-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                            Procurement
                        </div>
                    </a>
                </li>
                @endif

                @if(auth()->user()->hasAnyRole(['admin', 'accounting_staff']))
                <li>
                    <a href="{{ route('accounting') }}" 
                       class="flex items-center px-4 py-3.5 rounded-xl transition-all duration-200 group relative {{ request()->routeIs('accounting') ? 'bg-gradient-to-r from-[#E17100] to-[#531b1b] text-white shadow-lg' : 'text-slate-300 hover:bg-slate-800 hover:text-white' }}"
                       :class="sidebarOpen ? 'space-x-4' : 'justify-center'">
                        <svg class="w-6 h-6 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M8.433 7.418c.155-.103.346-.196.567-.267v1.698a2.305 2.305 0 01-.567-.267C8.07 8.34 8 8.114 8 8c0-.114.07-.34.433-.582zM11 12.849v-1.698c.22.071.412.164.567.267.364.243.433.468.433.582 0 .114-.07.34-.433.582a2.305 2.305 0 01-.567.267z"/>
                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-13a1 1 0 10-2 0v.092a4.535 4.535 0 00-1.676.662C6.602 6.234 6 7.009 6 8c0 .99.602 1.765 1.324 2.246.48.32 1.054.545 1.676.662v1.941c-.391-.127-.68-.317-.843-.504a1 1 0 10-1.51 1.31c.562.649 1.413 1.076 2.353 1.253V15a1 1 0 102 0v-.092a4.535 4.535 0 001.676-.662C13.398 13.766 14 12.991 14 12c0-.99-.602-1.765-1.324-2.246A4.535 4.535 0 0011 9.092V7.151c.391.127.68.317.843.504a1 1 0 101.511-1.31c-.563-.649-1.413-1.076-2.354-1.253V5z" clip-rule="evenodd"/>
                        </svg>
                        <span x-show="sidebarOpen" 
                              x-transition:enter="transition ease-out duration-200"
                              x-transition:enter-start="opacity-0"
                              x-transition:enter-end="opacity-100"
                              class="font-medium">Accounting</span>
                        
                        <div x-show="!sidebarOpen" 
                             class="absolute left-full ml-2 px-3 py-2 bg-slate-900 text-white text-sm rounded-lg shadow-xl whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none z-50">
                            Accounting
                        </div>
                    </a>
                </li>
                @endif

            </ul>
        </nav>

        <!-- Footer -->
        <div class="mt-auto p-4 border-t border-slate-700">
            <!-- Logout Button -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" 
                        onclick="event.preventDefault(); this.closest('form').submit();" 
                        class="w-full px-4 py-3 bg-gradient-to-r from-[#ff1818] to-[#4a0707] hover:from-[#5a2e2e] hover:to-[#743838]     text-white rounded-xl transition-all duration-200 font-medium shadow-lg flex items-center group"
                        :class="sidebarOpen ? 'justify-start space-x-3' : 'justify-center'">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                    </svg>
                    <span x-show="sidebarOpen" 
                          x-transition:enter="transition ease-out duration-200"
                          x-transition:enter-start="opacity-0"
                          x-transition:enter-end="opacity-100">{{ __('Log Out') }}</span>
                </button>
            </form>
            <p x-show="sidebarOpen" 
               x-transition:enter="transition ease-out duration-200"
               x-transition:enter-start="opacity-0"
               x-transition:enter-end="opacity-100"
               class="text-xs text-slate-500 mt-3 text-center">© 2025 RM Woodworks</p>
        </div>
    </div>
</div>

