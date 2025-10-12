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
            <td colspan="9" class="text-center py-4">No orders yet. Click "New Order" to create one.</td>
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
            <td colspan="6" class="text-center py-4">No customers yet. Click "New Customer" to add one.</td>
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
<<<<<<< HEAD
     <div>
  <label class="block text-sm font-medium mb-1">Customer</label>
  <select id="customerDropdown"
    class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none">
    <option value="">Select Customer</option>
    <option value="Home Design Studio">Home Design Studio</option>
    <option value="Bright Interiors">Bright Interiors</option>
    <option value="Modern Concepts">Modern Concepts</option>
    <option value="Elite Contractors">Elite Contractors</option>
  </select>
</div>

=======
      <form id="orderForm" class="space-y-3">
        <input type="hidden" id="orderIdField" />
        
        <div>
          <label class="block text-sm font-medium mb-1">Customer <span class="text-red-500">*</span></label>
          <select id="orderCustomer" required class="w-full border border-gray-300 rounded-md px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-accent">
            <option value="">Select Customer</option>
          </select>
        </div>
>>>>>>> 905a5a19dd4fd0045e0b10a6c981fa35b63d29db

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
    // In-Memory Data Storage
    let allOrders = [];
    let allCustomers = [];
    let orderIdCounter = 1;
    let customerIdCounter = 1;

    // State
    let currentView = 'sales';
    let currentEditId = null;
    let currentEditType = null;

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

    // Helper Functions
    function generateOrderNumber() {
      const date = new Date();
      const year = date.getFullYear();
      const month = String(date.getMonth() + 1).padStart(2, '0');
      const day = String(date.getDate()).padStart(2, '0');
      return `ORD-${year}${month}${day}-${String(orderIdCounter).padStart(4, '0')}`;
    }

    function createOrder(data) {
      const customer = allCustomers.find(c => c.customer_id === parseInt(data.customer_id));
      const order = {
        id: orderIdCounter++,
        order_number: generateOrderNumber(),
        customer_id: parseInt(data.customer_id),
        customer: customer,
        product: data.product,
        order_date: new Date().toISOString().split('T')[0],
        delivery_date: data.delivery_date,
        status: data.status,
        total_amount: parseFloat(data.total_amount) || 0,
        payment_status: data.payment_status,
        notes: data.notes || ''
      };
      allOrders.push(order);
      updateCustomerStats();
      showNotification('Order created successfully!', 'success');
      renderOrders();
      closeModal();
    }

    function updateOrder(id, data) {
      const index = allOrders.findIndex(o => o.id === id);
      if (index !== -1) {
        const customer = allCustomers.find(c => c.customer_id === parseInt(data.customer_id));
        allOrders[index] = {
          ...allOrders[index],
          customer_id: parseInt(data.customer_id),
          customer: customer,
          product: data.product,
          delivery_date: data.delivery_date,
          status: data.status,
          total_amount: parseFloat(data.total_amount) || 0,
          payment_status: data.payment_status,
          notes: data.notes || ''
        };
        updateCustomerStats();
        showNotification('Order updated successfully!', 'success');
        renderOrders();
        closeModal();
      }
    }

    function deleteOrder(id) {
      if (!confirm('Are you sure you want to delete this order?')) return;
      
      const index = allOrders.findIndex(o => o.id === id);
      if (index !== -1) {
        allOrders.splice(index, 1);
        updateCustomerStats();
        showNotification('Order deleted successfully!', 'success');
        renderOrders();
      }
    }

    function createCustomer(data) {
      const customer = {
        customer_id: customerIdCounter++,
        customer_name: data.customer_name,
        customer_type: data.customer_type,
        phone: data.phone || '',
        email: data.email || '',
        contact_person: data.contact_person || '',
        address: data.address || '',
        total_orders: 0,
        total_spent: 0
      };
      allCustomers.push(customer);
      showNotification('Customer created successfully!', 'success');
      updateCustomerDropdown();
      renderCustomers();
      closeModal();
    }

    function updateCustomer(id, data) {
      const index = allCustomers.findIndex(c => c.customer_id === id);
      if (index !== -1) {
        allCustomers[index] = {
          ...allCustomers[index],
          customer_name: data.customer_name,
          customer_type: data.customer_type,
          phone: data.phone || '',
          email: data.email || '',
          contact_person: data.contact_person || '',
          address: data.address || ''
        };
        
        // Update customer reference in orders
        allOrders.forEach(order => {
          if (order.customer_id === id) {
            order.customer = allCustomers[index];
          }
        });
        
        showNotification('Customer updated successfully!', 'success');
        updateCustomerDropdown();
        renderCustomers();
        renderOrders();
        closeModal();
      }
    }

    function deleteCustomer(id) {
      if (!confirm('Are you sure you want to delete this customer? All related orders will be deleted.')) return;
      
      const index = allCustomers.findIndex(c => c.customer_id === id);
      if (index !== -1) {
        // Delete all orders for this customer
        allOrders = allOrders.filter(o => o.customer_id !== id);
        allCustomers.splice(index, 1);
        showNotification('Customer deleted successfully!', 'success');
        updateCustomerDropdown();
        renderCustomers();
        renderOrders();
      }
    }

    function updateCustomerStats() {
      allCustomers.forEach(customer => {
        const customerOrders = allOrders.filter(o => o.customer_id === customer.customer_id);
        customer.total_orders = customerOrders.length;
        customer.total_spent = customerOrders.reduce((sum, order) => sum + parseFloat(order.total_amount || 0), 0);
      });
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
          <td class="px-4 py-2">₱${parseFloat(order.total_amount).toFixed(2)}</td>
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
          <td class="px-4 py-2">₱${parseFloat(customer.total_spent || 0).toFixed(2)}</td>
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
    window.editOrder = function(id) {
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

    window.editCustomer = function(id) {
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

    window.deleteOrder = deleteOrder;
    window.deleteCustomer = deleteCustomer;

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
      renderCustomers();
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
      renderOrders();
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
    submitBtn.addEventListener("click", (e) => {
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
          updateOrder(currentEditId, formData);
        } else {
          createOrder(formData);
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
          updateCustomer(currentEditId, formData);
        } else {
          createCustomer(formData);
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
    renderOrders();
    renderCustomers();
  </script>
</body>
</html>