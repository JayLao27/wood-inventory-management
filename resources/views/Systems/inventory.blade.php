<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
      <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body>
     
<div class="bg-yellow-50 min-h-screen p-6">
    <!-- Header -->
    <div class="text-center mb-8">
        <h1 class="text-4xl font-bold text-gray-800">Inventory Management</h1>
        <p class="text-lg text-gray-600">Track and manage raw materials and finished products</p>
    </div>

    <!-- Stats Section -->
    <div class="grid grid-cols-4 gap-6 mb-8">
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Total Items</h2>
            <p class="text-3xl font-bold">10</p>
            <p class="text-sm">6 raw materials, 4 finished products</p>
        </div>
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Low Stock Alerts</h2>
            <p class="text-3xl font-bold">3</p>
            <p class="text-sm">Items requiring attention</p>
        </div>
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Total Value</h2>
            <p class="text-3xl font-bold">$5,867.21</p>
            <p class="text-sm">Raw materials inventory value</p>
        </div>
        <div class="bg-gray-800 text-white p-4 rounded-lg shadow">
            <h2 class="text-xl font-semibold">Product Value</h2>
            <p class="text-3xl font-bold">$3,415</p>
            <p class="text-sm">Finished products inventory value</p>
        </div>
    </div>

    <!-- Inventory Items Section -->
    <div class="bg-white p-6 rounded-lg shadow">
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-2xl font-bold text-gray-800">Inventory Items</h2>
            <div class="flex space-x-4">
                <button class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">Receive Stock</button>
                <button class="bg-gray-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-700">View Reports</button>
                <button class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700">+ Add Item</button>
            </div>
        </div>
        <p class="text-gray-600 mb-4">Manage your raw materials and finished products</p>

        <!-- Search Bar -->
        <div class="flex items-center mb-6">
            <input type="text" placeholder="Search items..." class="w-full p-2 border border-gray-300 rounded-lg shadow focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button class="ml-4 bg-yellow-500 text-white px-4 py-2 rounded-lg shadow hover:bg-yellow-600">All Categories</button>
        </div>

        <!-- Table -->
        <div class="overflow-x-auto">
            <table class="w-full border-collapse border border-gray-300">
                <thead>
                    <tr class="bg-gray-100">
                        <th class="border border-gray-300 p-2 text-left">Name</th>
                        <th class="border border-gray-300 p-2 text-left">Category</th>
                        <th class="border border-gray-300 p-2 text-left">Current Stock</th>
                        <th class="border border-gray-300 p-2 text-left">Min Stock</th>
                        <th class="border border-gray-300 p-2 text-left">Unit Cost</th>
                        <th class="border border-gray-300 p-2 text-left">Supplier</th>
                        <th class="border border-gray-300 p-2 text-left">Status</th>
                        <th class="border border-gray-300 p-2 text-left">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="border border-gray-300 p-2">Oak Lumber 2x4</td>
                        <td class="border border-gray-300 p-2">Wood</td>
                        <td class="border border-gray-300 p-2">150 pieces</td>
                        <td class="border border-gray-300 p-2">50 pieces</td>
                        <td class="border border-gray-300 p-2">$12.50</td>
                        <td class="border border-gray-300 p-2">Premium wood supply</td>
                        <td class="border border-gray-300 p-2 text-green-600 font-bold">In Stock</td>
                        <td class="border border-gray-300 p-2">
                            <button class="text-blue-600 hover:underline">View</button>
                            <button class="text-yellow-600 hover:underline">Edit</button>
                            <button class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                    <tr>
                        <td class="border border-gray-300 p-2">Pine Lumber 2x6</td>
                        <td class="border border-gray-300 p-2">Wood</td>
                        <td class="border border-gray-300 p-2">150 pieces</td>
                        <td class="border border-gray-300 p-2">50 pieces</td>
                        <td class="border border-gray-300 p-2">$12.50</td>
                        <td class="border border-gray-300 p-2">Premium wood supply</td>
                        <td class="border border-gray-300 p-2 text-red-600 font-bold">Low Stock</td>
                        <td class="border border-gray-300 p-2">
                            <button class="text-blue-600 hover:underline">View</button>
                            <button class="text-yellow-600 hover:underline">Edit</button>
                            <button class="text-red-600 hover:underline">Delete</button>
                        </td>
                    </tr>
                    <!-- Add more rows as needed -->
                </tbody>
            </table>
        </div>
    </div>
</div>

</body>
</html>