<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RM Woodworks - Dashboard</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="flex font-sans bg-[#FAEEDC]">

  <!-- Sidebar -->
  <aside class="w-64 bg-[#2C3345] text-white flex flex-col h-screen">
    <div class="text-center py-6 border-b border-gray-700">
      <img src="{{ asset('images/logo.png') }}" class="mx-auto max-h-20 " alt="Logo">
      <h4 class="mt-2 font-semibold">RM Wood Works</h4>
      <p class="text-xs text-gray-400">Management System</p>
    </div>

    <ul class="flex-1 mt-6 space-y-1">
      <li class="flex items-center gap-3 px-6 py-3 bg-[#E17100] rounded-md">
        <i data-lucide="home" class="w-5 h-5"></i> Dashboard
      </li>
      <li class="flex items-center gap-3 px-6 py-3 hover:bg-[#3d455e] rounded-md cursor-pointer">
        <i data-lucide="package" class="w-5 h-5"></i> Inventory
      </li>
      <li class="flex items-center gap-3 px-6 py-3 hover:bg-[#3d455e] rounded-md cursor-pointer">
        <i data-lucide="settings" class="w-5 h-5"></i> Production
      </li>
      <li class="flex items-center gap-3 px-6 py-3 hover:bg-[#3d455e] rounded-md cursor-pointer">
        <i data-lucide="shopping-cart" class="w-5 h-5"></i> Sales & Orders
      </li>
      <li class="flex items-center gap-3 px-6 py-3 hover:bg-[#3d455e] rounded-md cursor-pointer">
        <i data-lucide="truck" class="w-5 h-5"></i> Procurement
      </li>
      <li class="flex items-center gap-3 px-6 py-3 hover:bg-[#3d455e] rounded-md cursor-pointer">
        <i data-lucide="dollar-sign" class="w-5 h-5"></i> Accounting
      </li>
      <li class="flex items-center gap-3 px-6 py-3 hover:bg-[#3d455e] rounded-md cursor-pointer">
        <i data-lucide="bar-chart-2" class="w-5 h-5"></i> Reports
      </li>
    </ul>

    <div class="text-xs text-gray-400 text-center py-4 border-t border-gray-700">
      © 2024 RM Woodworks
    </div>
  </aside>

  <!-- Main -->
  <main class="flex-1 p-8">
    <h1 class="text-3xl font-bold">Dashboard</h1>
    <p class="text-gray-600 mb-6">Wood works management system</p>

    <!-- Top Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
      <div class="bg-[#2C3345] text-white p-6 rounded-lg">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold">Total Revenue</h3>
          <i data-lucide="dollar-sign" class="w-5 h-5"></i>
        </div>
        <div class="text-2xl font-bold my-2">$45,231.89</div>
        <div class="text-sm text-green-400">+20.1% from last month</div>
      </div>

      <div class="bg-[#2C3345] text-white p-6 rounded-lg">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold">Active Orders</h3>
          <i data-lucide="shopping-cart" class="w-5 h-5"></i>
        </div>
        <div class="text-2xl font-bold my-2">23</div>
        <div class="text-sm text-blue-400">+12 new this week</div>
      </div>

      <div class="bg-[#2C3345] text-white p-6 rounded-lg">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold">In Production</h3>
          <i data-lucide="settings" class="w-5 h-5"></i>
        </div>
        <div class="text-2xl font-bold my-2">8</div>
        <div class="text-sm text-green-400">3 due this week</div>
      </div>

      <div class="bg-[#2C3345] text-white p-6 rounded-lg">
        <div class="flex items-center justify-between">
          <h3 class="text-lg font-semibold">Low Stock Items</h3>
          <i data-lucide="alert-triangle" class="w-5 h-5"></i>
        </div>
        <div class="text-2xl font-bold my-2 text-[#B70E11]">5</div>
        <div class="text-sm text-gray-400">Require immediate attention</div>
      </div>
    </div>

    <!-- Modules -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
      <!-- Inventory -->
      <div class="bg-[#2C3345] text-white p-6 rounded-lg">
        <div class="flex items-center gap-2 mb-4">
          <i data-lucide="package" class="w-5 h-5"></i>
          <h2 class="text-lg font-semibold">Inventory Management</h2>
        </div>
        <p class="text-sm text-gray-300 mb-4">Track raw material and finished products</p>

        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span>Raw Materials</span>
            <span class="bg-blue-500 px-3 py-1 text-xs rounded-full">150 Items</span>
          </div>
          <div class="flex justify-between">
            <span>Finished Products</span>
            <span class="bg-purple-500 px-3 py-1 text-xs rounded-full">18 Items</span>
          </div>
          <div class="flex justify-between">
            <span>Low Stock Alerts</span>
            <span class="bg-[#B70E11] px-3 py-1 text-xs rounded-full">5 Items</span>
          </div>
        </div>

        <div class="flex gap-3 mt-4">
          <button class="flex-1 py-2 rounded-md bg-white text-gray-800 font-bold flex items-center justify-center gap-2">
            <i data-lucide="archive" class="w-4 h-4"></i> Manage Stock
          </button>
          <button class="flex-1 py-2 rounded-md bg-[#FFF1DA] text-black font-bold flex items-center justify-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> Add Item
          </button>
        </div>
      </div>

      <!-- Production -->
      <div class="bg-[#2C3345] text-white p-6 rounded-lg">
        <div class="flex items-center gap-2 mb-4">
          <i data-lucide="settings" class="w-5 h-5"></i>
          <h2 class="text-lg font-semibold">Production Management</h2>
        </div>
        <p class="text-sm text-gray-300 mb-4">Plan and track furniture production</p>

        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span>Active Work Orders</span>
            <span class="bg-blue-500 px-3 py-1 text-xs rounded-full">8 Orders</span>
          </div>
          <div class="flex justify-between">
            <span>Pending Quality Check</span>
            <span class="bg-yellow-500 px-3 py-1 text-xs rounded-full">3 Orders</span>
          </div>
          <div class="flex justify-between">
            <span>Overdue Orders</span>
            <span class="bg-[#B70E11] px-3 py-1 text-xs rounded-full">1 Order</span>
          </div>
        </div>

        <div class="flex gap-3 mt-4">
          <button class="flex-1 py-2 rounded-md bg-white text-gray-800 font-bold flex items-center justify-center gap-2">
            <i data-lucide="check-square" class="w-4 h-4"></i> Manage Task
          </button>
          <button class="flex-1 py-2 rounded-md bg-[#FFF1DA] text-black font-bold flex items-center justify-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> New Order
          </button>
        </div>
      </div>

      <!-- Sales -->
      <div class="bg-[#2C3345] text-white p-6 rounded-lg">
        <div class="flex items-center gap-2 mb-4">
          <i data-lucide="shopping-cart" class="w-5 h-5"></i>
          <h2 class="text-lg font-semibold">Sales & Orders</h2>
        </div>
        <p class="text-sm text-gray-300 mb-4">Manage customer orders and sales</p>

        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span>Pending Orders</span>
            <span class="bg-blue-500 px-3 py-1 text-xs rounded-full">12 Orders</span>
          </div>
          <div class="flex justify-between">
            <span>Ready for Delivery</span>
            <span class="bg-green-500 px-3 py-1 text-xs rounded-full">4 Orders</span>
          </div>
          <div class="flex justify-between">
            <span>This Month Sales</span>
            <span class="bg-green-500 px-3 py-1 text-xs rounded-full">$28,240</span>
          </div>
        </div>

        <div class="flex gap-3 mt-4">
          <button class="flex-1 py-2 rounded-md bg-white text-gray-800 font-bold flex items-center justify-center gap-2">
            <i data-lucide="eye" class="w-4 h-4"></i> View Orders
          </button>
          <button class="flex-1 py-2 rounded-md bg-[#FFF1DA] text-black font-bold flex items-center justify-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> New Sale
          </button>
        </div>
      </div>
    </div>

    <!-- Bottom Modules -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
      <!-- Procurement -->
      <div class="bg-[#2C3345] text-white p-6 rounded-lg">
        <div class="flex items-center gap-2 mb-4">
          <i data-lucide="truck" class="w-5 h-5"></i>
          <h2 class="text-lg font-semibold">Procurement</h2>
        </div>
        <p class="text-sm text-gray-300 mb-4">Manage supplier and purchase orders</p>

        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span>Active Suppliers</span>
            <span class="bg-blue-500 px-3 py-1 text-xs rounded-full">12 Suppliers</span>
          </div>
          <div class="flex justify-between">
            <span>Pending Deliveries</span>
            <span class="bg-yellow-500 px-3 py-1 text-xs rounded-full">3 Orders</span>
          </div>
          <div class="flex justify-between">
            <span>This Month Purchases</span>
            <span class="bg-[#B70E11] px-3 py-1 text-xs rounded-full">$15,230</span>
          </div>
        </div>

        <div class="flex gap-3 mt-4">
          <button class="flex-1 py-2 rounded-md bg-white text-gray-800 font-bold flex items-center justify-center gap-2">
            <i data-lucide="truck" class="w-4 h-4"></i> View Deliveries
          </button>
          <button class="flex-1 py-2 rounded-md bg-[#FFF1DA] text-black font-bold flex items-center justify-center gap-2">
            <i data-lucide="plus" class="w-4 h-4"></i> New Purchase
          </button>
        </div>
      </div>

      <!-- Accounting -->
      <div class="bg-[#2C3345] text-white p-6 rounded-lg">
        <div class="flex items-center gap-2 mb-4">
          <i data-lucide="dollar-sign" class="w-5 h-5"></i>
          <h2 class="text-lg font-semibold">Accounting & Finance</h2>
        </div>
        <p class="text-sm text-gray-300 mb-4">Track finances and generate reports</p>

        <div class="space-y-2 text-sm">
          <div class="flex justify-between">
            <span>Monthly Revenue</span>
            <span class="bg-green-500 px-3 py-1 text-xs rounded-full">$45,231</span>
          </div>
          <div class="flex justify-between">
            <span>Monthly Expenses</span>
            <span class="bg-[#B70E11] px-3 py-1 text-xs rounded-full">$28,450</span>
          </div>
          <div class="flex justify-between">
            <span>Net Profit</span>
            <span class="bg-blue-500 px-3 py-1 text-xs rounded-full">$28,450</span>
          </div>
        </div>

        <div class="flex gap-3 mt-4">
          <button class="flex-1 py-2 rounded-md bg-white text-gray-800 font-bold flex items-center justify-center gap-2">
            <i data-lucide="file-text" class="w-4 h-4"></i> View Reports
          </button>
          <button class="flex-1 py-2 rounded-md bg-[#FFF1DA] text-black font-bold flex items-center justify-center gap-2">
            <i data-lucide="bar-chart-2" class="w-4 h-4"></i> Analytics
          </button>
        </div>
      </div>
    </div>
  </main>

  <script>
    lucide.createIcons();
  </script>
</body>
</html>
