<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <title>Sales and Order Management System</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            primary: "#1f2a38",
            hover: "#fff1da",
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
      <button id="newOrderBtn" class="bg-gray-700 text-white px-4 py-2 rounded-md ml-2 hover:bg-accent transition">
        <i class="fa-solid fa-plus mr-1"></i> New Order
      </button>
    </div>
  </div>

  <!-- Sales Management Section -->
  <section class="bg-card text-white p-6 rounded-2xl">
    <header class="mb-4">
      <h2 class="text-xl font-semibold">Sales Management</h2>
      <p class="text-gray-300">Manage customer orders and track sales performance</p>
    </header>

    <div class="flex flex-col md:flex-row justify-between gap-4 mb-4">
      <input type="search" id="searchInput" placeholder="Search order or customers..." class="w-full md:w-3/4 rounded-full px-4 py-2 text-primary focus:outline-none" />
      <div class="flex gap-2">
        <select id="statusFilter" class="bg-bg text-primary rounded-md px-3 py-2">
          <option value="">All Status</option>
          <option value="Pending">Pending</option>
          <option value="In Production">In Production</option>
          <option value="Ready">Ready</option>
          <option value="Delivered">Delivered</option>
          <option value="Cancelled">Cancelled</option>
        </select>
        <select id="paymentFilter" class="bg-bg text-primary rounded-md px-3 py-2">
          <option value="">All Payment</option>
          <option value="Unpaid">Unpaid</option>
          <option value="Partial">Partial</option>
          <option value="Paid">Paid</option>
        </select>
      </div>
    </div>

    <!-- Toggle Buttons -->
    <div class="flex justify-center gap-2 mb-6">
      <button id="salesTab" class="bg-accent text-primary px-72 py-2 rounded-md border border-gray-600 hover:bg-hover hover:text-black transition flex items-center gap-2">
        <i class="fa-solid fa-cart-shopping"></i> Sales Orders
      </button>
      <button id="customersTab" class="bg-primary text-white px-72 py-2 rounded-md border border-gray-600 hover:bg-hover hover:text-black transition flex items-center gap-2">
        <i class="fa-solid fa-users"></i> Customers
      </button>
    </div>

    <!-- Sales Table -->
    <div id="salesTable" class="overflow-x-auto">
      <table class="min-w-full border-collapse text-left text-sm">
        <thead class="bg-primary text-gray-300">
          <tr>
            <th class="px-4 py-2">Order #</th>
            <th class="px-4 py-2">Customer</th>
            <th class="px-4 py-2">Product</th>
            <th class="px-4 py-2">Order Date</th>
            <th class="px-4 py-2">Delivery Date</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Total Amount</th>
            <th class="px-4 py-2">Payment Status</th>
            <th class="px-4 py-2">Action</th>
          </tr>
        </thead>
        <tbody id="salesTableBody">
          <tr>
            <td colspan="9" class="text-center py-4">Loading...</td>
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
        <tbody id="customerTableBody">
          <tr>
            <td colspan="6" class="text-center py-4">Loading...</td>
          </tr>
        </tbody>
      </table>
    </div>
  </section>

  <!-- Modal -->
  <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-beige p-6 rounded-lg w-[90%] max-w-md shadow-xl max-h-[90vh] overflow-y-auto">
      <h2 id="modalTitle" class="text-xl font-semibold mb-1">Create New Sales Order</h2>
      <p id="modalSubtitle" class="text-gray-600 mb-4 text-sm">Create a new sales order for a customer.</p>

      <!-- Sales Order Form -->
      <form id="orderForm" class="space-y-3">
        <input type="hidden" id="orderIdField" />
        
        <div>
          <label class="block text-sm font-medium mb-1">Customer <span class="text-red-500">*</span></label>
          <select id="orderCustomer" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            <option value="">Select Customer</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Delivery Date <span class="text-red-500">*</span></label>
          <input type="date" id="orderDeliveryDate" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Product <span class="text-red-500">*</span></label>
          <select id="orderProduct" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            <option value="">Select Product</option>
            <option>Classic Oak Dining Chair</option>
            <option>Pine Coffee Table</option>
            <option>Oak Kitchen Cabinet</option>
            <option>Pine Bookshelf</option>
            <option>Oak Dining Table</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Total Amount</label>
          <input type="number" id="orderAmount" step="0.01" min="0" placeholder="0.00" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Status</label>
          <select id="orderStatus" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            <option value="Pending">Pending</option>
            <option value="In Production">In Production</option>
            <option value="Ready">Ready</option>
            <option value="Delivered">Delivered</option>
            <option value="Cancelled">Cancelled</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Payment Status</label>
          <select id="orderPaymentStatus" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            <option value="Unpaid">Unpaid</option>
            <option value="Partial">Partial</option>
            <option value="Paid">Paid</option>
          </select>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Notes</label>
          <textarea id="orderNotes" rows="3" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
        </div>
      </form>

      <!-- Customer Form -->
      <form id="customerForm" class="hidden space-y-3">
        <input type="hidden" id="customerIdField" />
        
        <div>
          <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
          <input type="text" id="customerName" required placeholder="Customer name" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Type <span class="text-red-500">*</span></label>
          <input type="hidden" id="customerType" value="Retail">
          <div class="flex gap-2">
            <button type="button" class="type-btn bg-retail text-white px-3 py-1 rounded-full text-xs ring-2 ring-retail" data-type="Retail">Retail</button>
            <button type="button" class="type-btn bg-gray-300 text-gray-600 px-3 py-1 rounded-full text-xs" data-type="Wholesale">Wholesale</button>
            <button type="button" class="type-btn bg-gray-300 text-gray-600 px-3 py-1 rounded-full text-xs" data-type="Contractor">Contractor</button>
          </div>
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Contact Number</label>
          <input type="text" id="customerPhone" placeholder="+63 XXX XXX XXXX" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Email</label>
          <input type="email" id="customerEmail" placeholder="email@example.com" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Contact Person</label>
          <input type="text" id="customerContactPerson" placeholder="Contact person name" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
        </div>

        <div>
          <label class="block text-sm font-medium mb-1">Address</label>
          <textarea id="customerAddress" rows="2" class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent"></textarea>
        </div>
      </form>

      <div class="flex justify-end mt-4 gap-2">
        <button id="closeModalBtn" class="px-4 py-2 rounded-md bg-gray-300 text-primary hover:bg-gray-400">Cancel</button>
        <button id="submitBtn" class="px-4 py-2 rounded-md bg-primary text-white hover:bg-accent">Save</button>
      </div>
    </div>
  </div>

  <!-- Scripts -->
  <script>
    // CSRF Token Setup
    const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

    // State
    let currentView = 'sales';
    let currentEditId = null;
    let currentEditType = null;
    let allOrders = [];
    let allCustomers = [];

    // DOM Elements
    const salesTab = document.getElementById("salesTab");
    const customersTab = document.getElementById("customersTab");
    const salesTable = document.getElementById("salesTable");
    const customerTable = document.getElementById("customerTable");
    const salesTableBody = document.getElementById("salesTableBody");
    const customerTableBody = document.getElementById("customerTableBody");
    const newOrderBtn = document.getElementById("newOrderBtn");
    const modal = document.getElementById("modal");
    const closeModalBtn = document.getElementById("closeModalBtn");
    const modalTitle = document.getElementById("modalTitle");
    const modalSubtitle = document.getElementById("modalSubtitle");
    const orderForm = document.getElementById("orderForm");
    const customerForm = document.getElementById("customerForm");
    const submitBtn = document.getElementById("submitBtn");
    const searchInput = document.getElementById("searchInput");
    const statusFilter = document.getElementById("statusFilter");
    const paymentFilter = document.getElementById("paymentFilter");

    // Customer Type Buttons
    const typeButtons = document.querySelectorAll('.type-btn');
    typeButtons.forEach(btn => {
      btn.addEventListener('click', function() {
        typeButtons.forEach(b => {
          b.classList.remove('ring-2');
          b.classList.add('bg-gray-300', 'text-gray-600');
          b.classList.remove('bg-retail', 'bg-wholesale', 'bg-contractor', 'text-white');
        });
        
        const type = this.dataset.type;
        document.getElementById('customerType').value = type;
        this.classList.remove('bg-gray-300', 'text-gray-600');
        this.classList.add('text-white', 'ring-2');
        
        if (type === 'Retail') {
          this.classList.add('bg-retail', 'ring-retail');
        } else if (type === 'Wholesale') {
          this.classList.add('bg-wholesale', 'ring-wholesale');
        } else {
          this.classList.add('bg-contractor', 'ring-contractor');
        }
      });
    });

    // API Functions
    async function fetchOrders() {
      try {
        const response = await fetch('/api/sales-orders', {
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          }
        });
        allOrders = await response.json();
        renderOrders();
      } catch (error) {
        console.error('Error fetching orders:', error);
        showNotification('Error loading orders', 'error');
      }
    }

    async function fetchCustomers() {
      try {
        const response = await fetch('/api/customers', {
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          }
        });
        allCustomers = await response.json();
        renderCustomers();
        updateCustomerDropdown();
      } catch (error) {
        console.error('Error fetching customers:', error);
        showNotification('Error loading customers', 'error');
      }
    }

    async function createOrder(data) {
      try {
        const response = await fetch('/api/sales-orders', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          },
          body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
          showNotification(result.message, 'success');
          fetchOrders();
          fetchCustomers();
          closeModal();
        } else {
          showNotification('Error creating order', 'error');
        }
      } catch (error) {
        console.error('Error creating order:', error);
        showNotification('Error creating order', 'error');
      }
    }

    async function updateOrder(id, data) {
      try {
        const response = await fetch(`/api/sales-orders/${id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          },
          body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
          showNotification(result.message, 'success');
          fetchOrders();
          fetchCustomers();
          closeModal();
        } else {
          showNotification('Error updating order', 'error');
        }
      } catch (error) {
        console.error('Error updating order:', error);
        showNotification('Error updating order', 'error');
      }
    }

    async function deleteOrder(id) {
      if (!confirm('Are you sure you want to delete this order?')) return;
      
      try {
        const response = await fetch(`/api/sales-orders/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          }
        });
        const result = await response.json();
        if (result.success) {
          showNotification(result.message, 'success');
          fetchOrders();
          fetchCustomers();
        } else {
          showNotification('Error deleting order', 'error');
        }
      } catch (error) {
        console.error('Error deleting order:', error);
        showNotification('Error deleting order', 'error');
      }
    }

    async function createCustomer(data) {
      try {
        const response = await fetch('/api/customers', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          },
          body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
          showNotification(result.message, 'success');
          fetchCustomers();
          closeModal();
        } else {
          showNotification('Error creating customer', 'error');
        }
      } catch (error) {
        console.error('Error creating customer:', error);
        showNotification('Error creating customer', 'error');
      }
    }

    async function updateCustomer(id, data) {
      try {
        const response = await fetch(`/api/customers/${id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          },
          body: JSON.stringify(data)
        });
        const result = await response.json();
        if (result.success) {
          showNotification(result.message, 'success');
          fetchCustomers();
          closeModal();
        } else {
          showNotification('Error updating customer', 'error');
        }
      } catch (error) {
        console.error('Error updating customer:', error);
        showNotification('Error updating customer', 'error');
      }
    }

    async function deleteCustomer(id) {
      if (!confirm('Are you sure you want to delete this customer? All related orders will be deleted.')) return;
      
      try {
        const response = await fetch(`/api/customers/${id}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Accept': 'application/json'
          }
        });
        const result = await response.json();
        if (result.success) {
          showNotification(result.message, 'success');
          fetchCustomers();
          fetchOrders();
        } else {
          showNotification('Error deleting customer', 'error');
        }
      } catch (error) {
        console.error('Error deleting customer:', error);
        showNotification('Error deleting customer', 'error');
      }
    }

    // Render Functions
    function renderOrders() {
      let filtered = [...allOrders];
      
      // Apply filters
      const search = searchInput.value.toLowerCase();
      if (search) {
        filtered = filtered.filter(order => 
          order.order_number.toLowerCase().includes(search) ||
          order.customer?.customer_name.toLowerCase().includes(search) ||
          order.product.toLowerCase().includes(search)
        );
      }
      
      if (statusFilter.value) {
        filtered = filtered.filter(order => order.status === statusFilter.value);
      }
      
      if (paymentFilter.value) {
        filtered = filtered.filter(order => order.payment_status === paymentFilter.value);
      }

      if (filtered.length === 0) {
        salesTableBody.innerHTML = '<tr><td colspan="9" class="text-center py-4">No orders found</td></tr>';
        return;
      }

      salesTableBody.innerHTML = filtered.map(order => `
        <tr class="odd:bg-[#14494c] even:bg-[#155c5f]">
          <td class="px-4 py-2">${order.order_number}</td>
          <td class="px-4 py-2">${order.customer?.customer_name || 'N/A'}</td>
          <td class="px-4 py-2">${order.product}</td>
          <td class="px-4 py-2">${formatDate(order.order_date)}</td>
          <td class="px-4 py-2">${formatDate(order.delivery_date)}</td>
          <td class="px-4 py-2">${getStatusBadge(order.status)}</td>
          <td class="px-4 py-2">${parseFloat(order.total_amount).toFixed(2)}</td>
          <td class="px-4 py-2">${getPaymentBadge(order.payment_status)}</td>
          <td class="px-4 py-2 flex gap-2">
            <button onclick="editOrder(${order.id})" class="bg-yellow-500 hover:scale-110 transition rounded px-2 py-1"><i class="fa-solid fa-pen-to-square"></i></button>
            <button onclick="deleteOrder(${order.id})" class="bg-red-600 hover:scale-110 transition rounded px-2 py-1"><i class="fa-solid fa-trash"></i></button>
          </td>
        </tr>
      `).join('');
    }

    function renderCustomers() {
      const search = searchInput.value.toLowerCase();
      let filtered = [...allCustomers];
      
      if (search) {
        filtered = filtered.filter(customer => 
          customer.customer_name.toLowerCase().includes(search) ||
          customer.email?.toLowerCase().includes(search) ||
          customer.phone?.toLowerCase().includes(search)
        );
      }

      if (filtered.length === 0) {
        customerTableBody.innerHTML = '<tr><td colspan="6" class="text-center py-4">No customers found</td></tr>';
        return;
      }

      customerTableBody.innerHTML = filtered.map(customer => `
        <tr class="odd:bg-[#14494c] even:bg-[#155c5f]">
          <td class="px-4 py-2">${customer.customer_name}</td>
          <td class="px-4 py-2">${getCustomerTypeBadge(customer.customer_type)}</td>
          <td class="px-4 py-2">
            ${customer.phone || 'N/A'}<br>
            <span class="text-gray-300 text-xs">${customer.email || 'N/A'}</span>
          </td>
          <td class="px-4 py-2">${customer.total_orders || 0}</td>
          <td class="px-4 py-2">${parseFloat(customer.total_spent || 0).toFixed(2)}</td>
          <td class="px-4 py-2 flex gap-2">
            <button onclick="editCustomer(${customer.customer_id})" class="bg-yellow-500 hover:scale-110 transition rounded px-2 py-1"><i class="fa-solid fa-pen-to-square"></i></button>
            <button onclick="deleteCustomer(${customer.customer_id})" class="bg-red-600 hover:scale-110 transition rounded px-2 py-1"><i class="fa-solid fa-trash"></i></button>
          </td>
        </tr>
      `).join('');
    }

    function updateCustomerDropdown() {
      const select = document.getElementById('orderCustomer');
      select.innerHTML = '<option value="">Select Customer</option>' + 
        allCustomers.map(customer => 
          `<option value="${customer.customer_id}">${customer.customer_name}</option>`
        ).join('');
    }

    // Helper Functions
    function formatDate(date) {
      if (!date) return 'N/A';
      const d = new Date(date);
      return d.toLocaleDateString('en-US', { year: 'numeric', month: 'numeric', day: 'numeric' });
    }

    function getStatusBadge(status) {
      const colors = {
        'Pending': 'bg-gray-500',
        'In Production': 'bg-yellow-600',
        'Ready': 'bg-blue-500',
        'Delivered': 'bg-green-600',
        'Cancelled': 'bg-red-600'
      };
      return `<span class="${colors[status]} px-2 py-1 rounded text-white text-xs">${status}</span>`;
    }

    function getPaymentBadge(status) {
      const colors = {
        'Unpaid': 'bg-red-500',
        'Partial': 'bg-indigo-500',
        'Paid': 'bg-green-600'
      };
      return `<span class="${colors[status]} px-2 py-1 rounded text-white text-xs">${status}</span>`;
    }

    function getCustomerTypeBadge(type) {
      const colors = {
        'Retail': 'bg-retail',
        'Wholesale': 'bg-wholesale',
        'Contractor': 'bg-contractor'
      };
      return `<span class="${colors[type]} text-white px-3 py-1 rounded-full text-xs">${type}</span>`;
    }

    function showNotification(message, type) {
      alert(message);
    }

    // Edit Functions
    window.editOrder = async function(id) {
      const order = allOrders.find(o => o.id === id);
      if (!order) return;

      currentEditId = id;
      currentEditType = 'order';
      
      modalTitle.textContent = 'Edit Sales Order';
      modalSubtitle.textContent = 'Update sales order information.';
      orderForm.classList.remove('hidden');
      customerForm.classList.add('hidden');
      
      document.getElementById('orderIdField').value = id;
      document.getElementById('orderCustomer').value = order.customer_id;
      document.getElementById('orderDeliveryDate').value = order.delivery_date;
      document.getElementById('orderProduct').value = order.product;
      document.getElementById('orderAmount').value = order.total_amount;
      document.getElementById('orderStatus').value = order.status;
      document.getElementById('orderPaymentStatus').value = order.payment_status;
      document.getElementById('orderNotes').value = order.notes || '';
      
      modal.classList.remove('hidden');
    }

    window.editCustomer = async function(id) {
      const customer = allCustomers.find(c => c.customer_id === id);
      if (!customer) return;

      currentEditId = id;
      currentEditType = 'customer';
      
      modalTitle.textContent = 'Edit Customer';
      modalSubtitle.textContent = 'Update customer information.';
      customerForm.classList.remove('hidden');
      orderForm.classList.add('hidden');
      
      document.getElementById('customerIdField').value = id;
      document.getElementById('customerName').value = customer.customer_name;
      document.getElementById('customerType').value = customer.customer_type;
      document.getElementById('customerPhone').value = customer.phone || '';
      document.getElementById('customerEmail').value = customer.email || '';
      document.getElementById('customerContactPerson').value = customer.contact_person || '';
      document.getElementById('customerAddress').value = customer.address || '';
      
      // Update type buttons
      typeButtons.forEach(btn => {
        btn.classList.remove('ring-2', 'bg-retail', 'bg-wholesale', 'bg-contractor', 'text-white');
        btn.classList.add('bg-gray-300', 'text-gray-600');
        
        if (btn.dataset.type === customer.customer_type) {
          btn.classList.remove('bg-gray-300', 'text-gray-600');
          btn.classList.add('text-white', 'ring-2');
          if (customer.customer_type === 'Retail') {
            btn.classList.add('bg-retail', 'ring-retail');
          } else if (customer.customer_type === 'Wholesale') {
            btn.classList.add('bg-wholesale', 'ring-wholesale');
          } else {
            btn.classList.add('bg-contractor', 'ring-contractor');
          }
        }
      });
      
      modal.classList.remove('hidden');
    }

    // Tab Switching
    customersTab.addEventListener("click", () => {
      currentView = 'customers';
      salesTable.classList.add("hidden");
      customerTable.classList.remove("hidden");
      customersTab.classList.add("bg-accent", "text-primary");
      customersTab.classList.remove("bg-primary", "text-white");
      salesTab.classList.remove("bg-accent", "text-primary");
      salesTab.classList.add("bg-primary", "text-white");
      newOrderBtn.innerHTML = '<i class="fa-solid fa-plus mr-1"></i> New Customer';
      searchInput.value = '';
      fetchCustomers();
    });

    salesTab.addEventListener("click", () => {
      currentView = 'sales';
      customerTable.classList.add("hidden");
      salesTable.classList.remove("hidden");
      salesTab.classList.add("bg-accent", "text-primary");
      salesTab.classList.remove("bg-primary", "text-white");
      customersTab.classList.remove("bg-accent", "text-primary");
      customersTab.classList.add("bg-primary", "text-white");
      newOrderBtn.innerHTML = '<i class="fa-solid fa-plus mr-1"></i> New Order';
      searchInput.value = '';
      fetchOrders();
    });

    // Modal Logic
    newOrderBtn.addEventListener("click", () => {
      currentEditId = null;
      currentEditType = null;
      
      if (currentView === 'customers') {
        modalTitle.textContent = "Create New Customer";
        modalSubtitle.textContent = "Add a new customer record.";
        customerForm.classList.remove("hidden");
        orderForm.classList.add("hidden");
        customerForm.reset();
        document.getElementById('customerType').value = 'Retail';
        
        // Reset type buttons
        typeButtons.forEach(btn => {
          btn.classList.remove('ring-2', 'bg-retail', 'bg-wholesale', 'bg-contractor', 'text-white');
          btn.classList.add('bg-gray-300', 'text-gray-600');
          if (btn.dataset.type === 'Retail') {
            btn.classList.remove('bg-gray-300', 'text-gray-600');
            btn.classList.add('bg-retail', 'text-white', 'ring-2', 'ring-retail');
          }
        });
      } else {
        if (allCustomers.length === 0) {
          alert('Please add a customer first before creating an order.');
          return;
        }
        modalTitle.textContent = "Create New Sales Order";
        modalSubtitle.textContent = "Create a new sales order for a customer.";
        orderForm.classList.remove("hidden");
        customerForm.classList.add("hidden");
        orderForm.reset();
        document.getElementById('orderStatus').value = 'Pending';
        document.getElementById('orderPaymentStatus').value = 'Unpaid';
        
        // Set minimum date to today
        const today = new Date().toISOString().split('T')[0];
        document.getElementById('orderDeliveryDate').setAttribute('min', today);
      }
      modal.classList.remove("hidden");
    });

    closeModalBtn.addEventListener("click", closeModal);
    modal.addEventListener("click", (e) => {
      if (e.target === modal) closeModal();
    });

    function closeModal() {
      modal.classList.add("hidden");
      orderForm.reset();
      customerForm.reset();
      currentEditId = null;
      currentEditType = null;
    }

    // Form Submission
    submitBtn.addEventListener("click", async (e) => {
      e.preventDefault();
      
      if (currentView === 'sales' || currentEditType === 'order') {
        const formData = {
          customer_id: document.getElementById('orderCustomer').value,
          delivery_date: document.getElementById('orderDeliveryDate').value,
          product: document.getElementById('orderProduct').value,
          total_amount: document.getElementById('orderAmount').value || 0,
          status: document.getElementById('orderStatus').value,
          payment_status: document.getElementById('orderPaymentStatus').value,
          notes: document.getElementById('orderNotes').value
        };
        
        if (!formData.customer_id || !formData.delivery_date || !formData.product) {
          alert('Please fill in all required fields');
          return;
        }
        
        if (currentEditId) {
          await updateOrder(currentEditId, formData);
        } else {
          await createOrder(formData);
        }
      } else {
        const formData = {
          customer_name: document.getElementById('customerName').value,
          customer_type: document.getElementById('customerType').value,
          phone: document.getElementById('customerPhone').value,
          email: document.getElementById('customerEmail').value,
          contact_person: document.getElementById('customerContactPerson').value,
          address: document.getElementById('customerAddress').value
        };
        
        if (!formData.customer_name || !formData.customer_type) {
          alert('Please fill in all required fields');
          return;
        }
        
        if (currentEditId) {
          await updateCustomer(currentEditId, formData);
        } else {
          await createCustomer(formData);
        }
      }
    });

    // Search and Filter
    searchInput.addEventListener('input', () => {
      if (currentView === 'sales') {
        renderOrders();
      } else {
        renderCustomers();
      }
    });

    statusFilter.addEventListener('change', renderOrders);
    paymentFilter.addEventListener('change', renderOrders);

    // Initialize
    fetchOrders();
    fetchCustomers();
  </script>
</body>
</html>