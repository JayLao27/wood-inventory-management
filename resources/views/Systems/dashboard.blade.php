<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RM Woodworks - Dashboard</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
            background-color: #FFF1DA;
            display: flex;
        }
        /* Sidebar */
        .sidebar {
            width: 250px;
            background: #2C3345;
            color: #fff;
            display: flex;
            flex-direction: column;
            padding: 20px 0;
            height: 100vh;
        }
        .sidebar .logo {
            text-align: center;
            margin-bottom: 30px;
        }
        .sidebar .logo img {
            max-width: 120px;
        }
        .sidebar ul {
            list-style: none;
            padding: 0;
        }
        .sidebar ul li {
            padding: 15px 20px;
            cursor: pointer;
            display: flex;
            align-items: center;
            font-weight: 500;
        }
        .sidebar ul li.active {
            background: #E17100;
            border-radius: 6px;
        }
        .sidebar ul li:hover {
            background: #3d455e;
            border-radius: 6px;
        }
        .sidebar ul li i {
            margin-right: 10px;
        }
        .sidebar .footer {
            margin-top: auto;
            text-align: center;
            font-size: 12px;
            color: #aaa;
            padding: 10px;
        }

        /* Main content */
        .main {
            flex: 1;
            padding: 30px;
        }
        .main h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        .main p.subtitle {
            color: #666;
            margin-bottom: 20px;
        }

        /* Dashboard cards */
        .cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        .card {
            background: #2C3345;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
        }
        .card h3 {
            font-size: 20px;
            margin: 0;
        }
        .card .value {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .card .note {
            font-size: 13px;
            color: #aaa;
        }
        .card .positive { color: #22c55e; }
        .card .negative { color: #ef4444; }

        /* Module blocks */
        .modules {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .module {
            background: #2C3345;
            color: #fff;
            padding: 20px;
            border-radius: 10px;
        }
        .module h2 {
            margin: 0 0 10px;
            font-size: 18px;
        }
        .module p {
            font-size: 14px;
            color: #ccc;
        }
        .stats {
            margin: 15px 0;
            font-size: 14px;
        }
        .stats span {
            display: inline-block;
            margin-right: 10px;
            padding: 4px 8px;
            border-radius: 5px;
            font-size: 12px;
            background: #444;
        }
        .stats .green { background: #22c55e; color: #fff; }
        .stats .red { background: #ef4444; color: #fff; }
        .stats .blue { background: #3b82f6; color: #fff; }

        .actions {
            margin-top: 15px;
            display: flex;
            gap: 10px;
        }
        .actions button {
            flex: 1;
            padding: 10px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }
        .actions .primary {
            background: #E17100;
            color: #fff;
        }
        .actions .secondary {
            background: #fff;
            color: #333;
        }
        .actions button:hover {
            opacity: 0.9;
        }

        /* Wide modules */
        .modules-2 {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logo.png') }}" alt="RM Woodworks">
            <h4>RM Wood Works</h4>
            <p style="font-size: 12px; color: #bbb;">Management System</p>
        </div>
        <ul>
            <li class="active">🏠 Dashboard</li>
            <li>📦 Inventory</li>
            <li>⚙️ Production</li>
            <li>🛒 Sales & Orders</li>
            <li>🚚 Procurement</li>
            <li>💲 Accounting</li>
            <li>📊 Reports</li>
        </ul>
        <div class="footer">
            © 2024 RM Woodworks
        </div>
    </div>

    <!-- Main -->
    <div class="main">
        <h1>Dashboard</h1>
        <p class="subtitle">Wood works management system</p>

        <!-- Top cards -->
        <div class="cards">
            <div class="card">
                <h3>Total Revenue</h3>
                <div class="value">$45,231.89</div>
                <div class="note positive">+20.1% from last month</div>
            </div>
            <div class="card">
                <h3>Active Orders</h3>
                <div class="value">23</div>
                <div class="note">+12 new this week</div>
            </div>
            <div class="card">
                <h3>In Production</h3>
                <div class="value">8</div>
                <div class="note positive">3 due this week</div>
            </div>
            <div class="card">
                <h3>Low Stock Items</h3>
                <div class="value negative">5</div>
                <div class="note">Require immediate attention</div>
            </div>
        </div>

        <!-- Modules -->
        <div class="modules">
            <div class="module">
                <h2>Inventory Management</h2>
                <p>Track raw material and finished products</p>
                <div class="stats">
                    <span class="blue">150 Items</span>
                    <span class="blue">18 Items</span>
                    <span class="red">5 Items</span>
                </div>
                <div class="actions">
                    <button class="secondary">Manage Stock</button>
                    <button class="primary">+ Add Item</button>
                </div>
            </div>

            <div class="module">
                <h2>Production Management</h2>
                <p>Plan and track furniture production</p>
                <div class="stats">
                    <span class="blue">8 Orders</span>
                    <span class="blue">3 Orders</span>
                    <span class="red">1 Order</span>
                </div>
                <div class="actions">
                    <button class="secondary">Manage Task</button>
                    <button class="primary">+ New Order</button>
                </div>
            </div>

            <div class="module">
                <h2>Sales & Orders</h2>
                <p>Manage customer orders and sales</p>
                <div class="stats">
                    <span class="blue">12 Orders</span>
                    <span class="blue">4 Orders</span>
                    <span class="green">$28,240</span>
                </div>
                <div class="actions">
                    <button class="secondary">View Orders</button>
                    <button class="primary">+ New Sale</button>
                </div>
            </div>
        </div>

        <!-- Bottom modules -->
        <div class="modules-2">
            <div class="module">
                <h2>Procurement</h2>
                <p>Manage supplier and purchase orders</p>
                <div class="stats">
                    <span class="blue">12 Suppliers</span>
                    <span class="blue">3 Orders</span>
                    <span class="red">$15,230</span>
                </div>
                <div class="actions">
                    <button class="secondary">View Deliveries</button>
                    <button class="primary">+ New Purchase</button>
                </div>
            </div>

            <div class="module">
                <h2>Accounting & Finance</h2>
                <p>Track finances and generate reports</p>
                <div class="stats">
                    <span class="green">$45,231</span>
                    <span class="red">$28,450</span>
                    <span class="blue">$28,450</span>
                </div>
                <div class="actions">
                    <button class="secondary">$ View Reports</button>
                    <button class="primary">Analytics</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
