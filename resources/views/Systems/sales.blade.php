<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Sales and Order Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#1f2a38",
            hover:"#fff1da",
            accent: "#f28c28",
            bg: "#f2e9d8",
            card: "#0f3a3d",
            beige: "#faedcd",
            retail: "#6f65ff",
            wholesale: "#5eb8ff",
            contractor: "#d27fd6",
          },
          fontFamily: {
            poppins: ["Poppins", "sans-serif"],
          },
        },
      },
    };
  </script>
  <script src="https://kit.fontawesome.com/57ad728d01.js" crossorigin="anonymous"></script>
</head>

<body class="bg-bg text-primary font-poppins min-h-screen p-8">

  <!-- Header -->
  <div class="flex justify-between items-center mb-8">
    <div>
      <h1 class="text-3xl font-semibold">Sales & Orders</h1>
      <p class="text-gray-600">Manage customer orders, sales, and deliveries</p>
    </div>
    <div>
      <button id="newOrderBtn"
        class="bg-gray-700 text-white px-4 py-2 rounded-md ml-2 hover:bg-accent transition"><i
          class="fa-solid fa-plus mr-1"></i> New Order</button>
    </div>
  </div>

  <!-- Sales Management Section -->
  <section class="bg-card text-white p-6 rounded-2xl">
    <header class="mb-4">
      <h2 class="text-xl font-semibold">Sales Management</h2>
      <p class="text-gray-300">Manage customer orders and track sales performance</p>
    </header>

    <div class="flex flex-col md:flex-row justify-between gap-4 mb-4">
      <input type="search" placeholder="Search order or customers..."
        class="w-full md:w-3/4 rounded-full px-4 py-2 text-primary focus:outline-none" />
      <div class="flex gap-2">
        <select class="bg-bg text-primary rounded-md px-3 py-2">
          <option>All Status</option>
        </select>
        <select class="bg-bg text-primary rounded-md px-3 py-2">
          <option>All Priority</option>
        </select>
      </div>
    </div>

    <!-- Toggle Buttons -->
    <div class="flex justify-center gap-2 mb-6">
      <button id="salesTab"
        class="bg-primary text-white px-72 py-2 rounded-md border border-gray-600 hover:bg-hover hover:text-black transition flex items-center gap-2""><i
          class="fa-solid fa-cart-shopping"></i> Sales Orders</button>
      <button id="customersTab"
        class="bg-primary text-white px-72 py-2 rounded-md border border-gray-600 hover:bg-hover hover:text-black transition flex items-center gap-2"><i
          class="fa-solid fa-users"></i> Customers</button>
    </div>

    <!-- Sales Table -->
    <div id="salesTable" class="overflow-x-auto">
      <table class="min-w-full border-collapse text-left text-sm">
        <thead class="bg-primary text-gray-300">
          <tr>
            <th class="px-4 py-2">Order #</th>
            <th class="px-4 py-2">Customer</th>
            <th class="px-4 py-2">Order Date</th>
            <th class="px-4 py-2">Delivery Date</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Total Amount</th>
            <th class="px-4 py-2">Payment Status</th>
            <th class="px-4 py-2">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd:bg-[#14494c] even:bg-[#155c5f]">
            <td class="px-4 py-2">WO-2025-001</td>
            <td class="px-4 py-2">Home Design Studio</td>
            <td class="px-4 py-2">1/15/2025</td>
            <td class="px-4 py-2">1/30/2025</td>
            <td class="px-4 py-2"><span class="bg-yellow-600 px-2 py-1 rounded text-white text-xs">In Production</span>
            </td>
            <td class="px-4 py-2">$1,199.96</td>
            <td class="px-4 py-2"><span class="bg-indigo-500 px-2 py-1 rounded text-white text-xs">Partial</span></td>
            <td class="px-4 py-2 flex gap-2">
              <button class="bg-green-600 hover:scale-110 transition rounded px-2 py-1"><i
                  class="fa-solid fa-eye"></i></button>
              <button class="bg-yellow-500 hover:scale-110 transition rounded px-2 py-1"><i
                  class="fa-solid fa-pen-to-square"></i></button>
              <button class="bg-red-600 hover:scale-110 transition rounded px-2 py-1"><i
                  class="fa-solid fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Customer Table -->
    <div id="customerTable" class="hidden overflow-x-auto">
      <table class="min-w-full border-collapse text-left text-sm">
        <thead class="bg-primary text-gray-300">
          <tr>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Type</th>
            <th class="px-4 py-2">Contact</th>
            <th class="px-4 py-2">Total Orders</th>
            <th class="px-4 py-2">Total Spent</th>
            <th class="px-4 py-2">Action</th>
          </tr>
        </thead>
        <tbody>
          <tr class="odd:bg-[#14494c] even:bg-[#155c5f]">
            <td class="px-4 py-2">Home Design Studio</td>
            <td class="px-4 py-2"><span class="bg-wholesale text-white px-3 py-1 rounded-full text-xs">Wholesale</span></td>
            <td class="px-4 py-2">
              +63-951-042-2303<br>
              <span class="text-gray-300 text-xs">orders@homedesign.com</span>
            </td>
            <td class="px-4 py-2">3</td>
            <td class="px-4 py-2">$4,599.88</td>
            <td class="px-4 py-2 flex gap-2">
              <button class="bg-green-600 hover:scale-110 transition rounded px-2 py-1"><i
                  class="fa-solid fa-eye"></i></button>
              <button class="bg-yellow-500 hover:scale-110 transition rounded px-2 py-1"><i
                  class="fa-solid fa-pen-to-square"></i></button>
              <button class="bg-red-600 hover:scale-110 transition rounded px-2 py-1"><i
                  class="fa-solid fa-trash"></i></button>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- New Order / Customer Modal -->
  <div id="modal"
    class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity">
    <div class="bg-beige p-6 rounded-lg w-[90%] max-w-md shadow-xl">
      <h2 id="modalTitle" class="text-xl font-semibold mb-1">Create New Sales Order</h2>
      <p id="modalSubtitle" class="text-gray-600 mb-4 text-sm">Create a new sales order for a customer.</p>

      <!-- Sales Order Form -->
      <form id="orderForm" class="space-y-3">
        <div>
          <label class="block text-sm font-medium mb-1">Customer</label>
          <input type="text" placeholder="Enter customer name"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none" />
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Delivery Date</label>
          <input type="date" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Product</label>
          <select class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none">
            <option>Select Product</option>
            <option>Classic Oak Dining Chair</option>
            <option>Pine Coffee Table</option>
            <option>Oak Kitchen Cabinet</option>
            <option>Pine Bookshelf</option>
            <option>Oak Dining Table</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Notes</label>
          <textarea rows="3"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none"></textarea>
        </div>
      </form>

      <!-- Customer Form -->
      <form id="customerForm" class="hidden space-y-3">
        <div>
          <label class="block text-sm font-medium mb-1">Name</label>
          <input type="text" placeholder="Customer name"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Type</label>
          <div class="flex gap-2">
            <button type="button"
              class="type-btn bg-retail text-white px-3 py-1 rounded-full text-xs focus:ring-2 focus:ring-offset-2"
              data-type="Retail">Retail</button>
            <button type="button"
              class="type-btn bg-wholesale text-white px-3 py-1 rounded-full text-xs focus:ring-2 focus:ring-offset-2"
              data-type="Wholesale">Wholesale</button>
            <button type="button"
              class="type-btn bg-contractor text-white px-3 py-1 rounded-full text-xs focus:ring-2 focus:ring-offset-2"
              data-type="Contractor">Contractor</button>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Contact Number</label>
          <input type="text" placeholder="+1 555-1234"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input type="email" placeholder="email@example.com"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Total Orders</label>
          <input type="number" min="0"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Total Spent</label>
          <input type="number" min="0" step="0.01"
            class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none">
        </div>
      </form>

      <div class="flex justify-end mt-4">
        <button id="closeModalBtn"
          class="px-4 py-2 rounded-md bg-gray-300 text-primary mr-2 hover:bg-gray-400">Cancel</button>
        <button id="submitBtn"
          class="px-4 py-2 rounded-md bg-primary text-white hover:bg-accent">Save</button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    const salesTab = document.getElementById("salesTab");
    const customersTab = document.getElementById("customersTab");
    const salesTable = document.getElementById("salesTable");
    const customerTable = document.getElementById("customerTable");
    const newOrderBtn = document.getElementById("newOrderBtn");
    const modal = document.getElementById("modal");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const modalTitle = document.getElementById("modalTitle");
    const modalSubtitle = document.getElementById("modalSubtitle");
    const orderForm = document.getElementById("orderForm");
    const customerForm = document.getElementById("customerForm");

    // Toggle Views
    customersTab.addEventListener("click", () => {
      salesTable.classList.add("hidden");
      customerTable.classList.remove("hidden");
      customersTab.classList.add("bg-accent", "text-primary");
      salesTab.classList.remove("bg-accent", "text-primary");
      salesTab.classList.add("bg-primary", "text-white");
      newOrderBtn.innerHTML = '<i class="fa-solid fa-plus mr-1"></i> New Customer';
    });

    salesTab.addEventListener("click", () => {
      customerTable.classList.add("hidden");
      salesTable.classList.remove("hidden");
      salesTab.classList.add("bg-accent", "text-primary");
      customersTab.classList.remove("bg-accent", "text-primary");
      customersTab.classList.add("bg-primary", "text-white");
      newOrderBtn.innerHTML = '<i class="fa-solid fa-plus mr-1"></i> New Order';
    });

    // Modal Logic
    newOrderBtn.addEventListener("click", () => {
      modal.classList.remove("hidden");
      if (newOrderBtn.textContent.includes("Customer")) {
        modalTitle.textContent = "Create New Customer";
        modalSubtitle.textContent = "Add a new customer record.";
        customerForm.classList.remove("hidden");
        orderForm.classList.add("hidden");
      } else {
        modalTitle.textContent = "Create New Sales Order";
        modalSubtitle.textContent = "Create a new sales order for a customer.";
        orderForm.classList.remove("hidden");
        customerForm.classList.add("hidden");
      }
    });

    closeModalBtn.addEventListener("click", () => modal.classList.add("hidden"));
    modal.addEventListener("click", (e) => {
      if (e.target === modal) modal.classList.add("hidden");
    });
  </script>
</body>
</html>
