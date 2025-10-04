<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sales and Order Management System</title>
    <link rel="stylesheet" href="../css/sales.css" />
    <script src="https://kit.fontawesome.com/57ad728d01.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-content">
                <div class="logo-section">
                    <div class="logo">
                        <img src="../assets/logo.png" alt="RM Woodworks Logo" />
                    </div>
                    <div class="logo-text">
                        <h2>RM Wood Works</h2>
                        <p>Management System</p>
                    </div>
                </div>

                <hr class="sidebar-divider" />
                <div class="menu">
                    <ul>
                        <li><i class="fa-solid fa-house"></i> Dashboard</li>
                        <li><i class="fa-solid fa-box"></i> Inventory</li>
                        <li><i class="fa-solid fa-hammer"></i> Production</li>
                        <li class="active"><i class="fa-solid fa-cart-shopping"></i> Sales & Orders</li>
                        <li><i class="fa-solid fa-file-lines"></i> Procurement</li>
                        <li><i class="fa-solid fa-coins"></i> Accounting</li>
                        <li><i class="fa-solid fa-chart-column"></i> Reports</li>
                    </ul>
                </div>
            </div>
            <hr class="sidebar-divider" />
            <div class="footer">© 2024 RM Woodworks</div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <div class="header">
                <div class="Sales-text">
                    <h1>Sales & Orders</h1>
                    <p>Manage customer orders, sales, and deliveries</p>
                </div>

                <div class="options">
                    <button class="export"><i class="fa-solid fa-download"></i> Export</button>
                    <button class="new"><i class="fa-solid fa-plus"></i> New Order</button>
                </div>
            </div>

            <!-- Dashboard Cards -->
            <section class="dashboard-cards">
                <div class="card">
                    <h3>Total Revenue</h3>
                    <p class="value">$6,949.84</p>
                    <span class="note">All time sales</span>
                </div>
                <div class="card">
                    <h3>Payments Received</h3>
                    <p class="value success">$3,899.91</p>
                    <span class="note">Items requiring attention</span>
                </div>
                <div class="card">
                    <h3>Pending Payments</h3>
                    <p class="value warning">$3,049.93</p>
                    <span class="note">Outstanding amount</span>
                </div>
                <div class="card">
                    <h3>Active Orders</h3>
                    <p class="value">4</p>
                    <span class="note">Orders in progress</span>
                </div>
            </section>

            <!-- Table Section -->
            <section class="sales-management">
                <header class="section-header">
                    <h2>Sales Management</h2>
                    <p>Manage customer orders and track sales performance</p>
                </header>

                <div class="toolbar">
                    <input type="search" placeholder="Search order or customers..." />
                    <div class="filters">
                        <select>
                            <option>All Status</option>
                        </select>
                        <select>
                            <option>All Priority</option>
                        </select>
                    </div>
                </div>

                <div class="table-filters">
                    <button class="tab active"><i class="fa-solid fa-cart-shopping"></i> Sales Orders</button>
                    <button class="tab"><i class="fa-solid fa-users"></i> Customers</button>
                </div>

                <!-- Sales Orders Table -->
                <table id="sales-orders-table" class="data-table">
                    <thead>
                        <tr>
                            <th>Order #</th>
                            <th>Customer</th>
                            <th>Order Date</th>
                            <th>Delivery Date</th>
                            <th>Status</th>
                            <th>Total Amount</th>
                            <th>Payment Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>WO-2025-001</td>
                            <td>Home Design Studio <span class="tag">Wholesale</span></td>
                            <td>1/15/2025</td>
                            <td>1/30/2025</td>
                            <td><span class="badge in-progress">In Production</span></td>
                            <td>$1,199.96</td>
                            <td><span class="badge partial">Partial</span></td>
                            <td>
                                <button class="action-btn view"><i class="fa-solid fa-eye"></i></button>
                                <button class="action-btn edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="action-btn delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Customers Table -->
                <table id="customers-table" class="data-table" style="display:none;">
                    <thead>
                        <tr>
                            <th>Customer Name</th>
                            <th>Type</th>
                            <th>Contact</th>
                            <th>Email</th>
                            <th>Total Orders</th>
                            <th>Total Spent</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Oclarit Family</td>
                            <td><span class="badge">Retail</span></td>
                            <td>+1-555-0202</td>
                            <td>mary.johnson@email.com</td>
                            <td>2</td>
                            <td>$899.99</td>
                            <td>
                                <button class="action-btn view"><i class="fa-solid fa-eye"></i></button>
                                <button class="action-btn edit"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button class="action-btn delete"><i class="fa-solid fa-trash"></i></button>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <!-- Modals -->
                <div id="viewModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2><i class="fa-solid fa-eye"></i> View Details</h2>
                        <div class="modal-body">
                            <p><strong>Order #:</strong> WO-2025-001</p>
                            <p><strong>Customer:</strong> Home Design Studio</p>
                            <p><strong>Status:</strong> In Production</p>
                            <p><strong>Total Amount:</strong> $1,199.96</p>
                            <p><strong>Payment:</strong> Partial</p>
                        </div>
                    </div>
                </div>

                <!-- Update Order -->
                <div id="editModal" class="modal">
                    <div class="modal-content update-order">
                        <span class="close">&times;</span>
                        <h2><i class="fa-solid fa-pen-to-square"></i> Update Order</h2>
                        <p class="subtext">Edit order details and update status.</p>
                        <form>
                            <label>Customer Name</label>
                            <input type="text" value="Home Design Studio">
                            <label>Status</label>
                            <select>
                                <option>Confirmed</option>
                                <option>In Production</option>
                                <option>Delivered</option>
                                <option>Cancelled</option>
                            </select>
                            <label>Total Amount ($)</label>
                            <input type="number" value="1199.96">
                            <div class="modal-actions">
                                <button type="button" class="cancel-btn">Cancel</button>
                                <button type="submit" class="save-btn">Save Changes</button>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Cancel Order -->
                <div id="cancelModal" class="modal">
                    <div class="modal-content cancel-order">
                        <span class="close">&times;</span>
                        <h2>Cancel Order</h2>
                        <p class="subtext">Are you sure you want to cancel order SO-2024-002?</p>
                        <div class="order-info">
                            <div class="customer"><strong>Oclarit Family</strong>
                                <p>Total: $899.99</p>
                            </div>
                            <div class="delivery">
                                <p><strong>Delivery Date</strong><br>1/25/2024</p>
                            </div>
                        </div>
                        <label><strong>Cancellation Reason</strong></label>
                        <div class="reason-select" id="reasonSelect">Select Reason ▾</div>
                        <label><strong>Additional Notes</strong></label>
                        <textarea placeholder="Optional notes..."></textarea>
                        <div class="modal-actions">
                            <button class="keep-btn">Keep Order</button>
                            <button class="cancel-btn">Cancel Order</button>
                        </div>
                    </div>
                </div>

                <!-- Reason Modal -->
                <div id="reasonModal" class="modal">
                    <div class="modal-content small">
                        <ul class="reason-list">
                            <li>Customer Request</li>
                            <li>Material Shortage</li>
                            <li>Production Delay</li>
                            <li>Payment Issue</li>
                            <li>Other</li>
                        </ul>
                    </div>
                </div>

                <!-- New Sales Order -->
                <div id="newOrderModal" class="modal">
                    <div class="modal-content">
                        <span class="close">&times;</span>
                        <h2>Create New Sales Order</h2>
                        <p class="modal-subtitle">Create a new sales order for a customer.</p>
                        <div class="modal-body">
                            <label>Customer</label>
                            <div class="select-box" id="customerSelect">
                                <span>Select Customer</span>
                                <i class="fa-solid fa-chevron-down"></i>
                            </div>

                            <label>Delivery Date</label>
                            <input type="date">

                            <label>Product</label>
                            <div class="product-row">
                                <div class="select-box" id="productSelect">
                                    <span>Select Product</span>
                                    <i class="fa-solid fa-chevron-down"></i>
                                </div>
                                <input type="number" placeholder="Qty" min="1" class="qty-input">
                            </div>

                            <label>Notes</label>
                            <textarea placeholder="Optional notes..."></textarea>
                            <button class="create-btn">Create Work Order</button>
                        </div>
                    </div>
                </div>

                <!-- Success -->
                <div id="successModal" class="modal">
                    <div class="modal-content small">
                        <span class="close">&times;</span>
                        <h2><i class="fa-solid fa-circle-check" style="color:#2e8b57;"></i> Order Created!</h2>
                        <p>Your new sales order has been successfully created.</p>
                        <button class="ok-btn">OK</button>
                    </div>
                </div>

                <!-- Select Customer -->
                <div id="customerSelectModal" class="modal">
                    <div class="modal-content small">
                        <span class="close">&times;</span>
                        <h2><i class="fa-solid fa-users"></i> Select Customer</h2>
                        <div class="modal-body">
                            <ul class="select-list">
                                <li>Home Design Studio</li>
                                <li>Oclarit Family</li>
                                <li>Lao Tressure Co.</li>
                                <li>Neil Idol</li>
                                <li>JV Family</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Select Product -->
                <div id="productSelectModal" class="modal">
                    <div class="modal-content small">
                        <span class="close">&times;</span>
                        <h2><i class="fa-solid fa-cube"></i> Select Product</h2>
                        <div class="modal-body">
                            <ul class="select-list">
                                <li>Classic Oak Dining Chair</li>
                                <li>Pine Coffee Table</li>
                                <li>Oak Kitchen Cabinet</li>
                                <li>Pine Bookshelf</li>
                                <li>Oak Dining Table</li>
                            </ul>
                        </div>
                    </div>
                </div>

            </section>
        </div>
    </div>
    <script src="script.js"></script>

</body>

</html>