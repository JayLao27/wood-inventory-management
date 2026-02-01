<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $salesOrder->order_number }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @media print {
            body {
                background-color: white !important;
                padding: 0 !important;
            }
            .receipt-container {
                box-shadow: none !important;
                padding: 1.25rem !important;
            }
            .print-button {
                display: none !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100 p-5">
    <button class="fixed top-5 right-5 bg-slate-700 hover:bg-slate-800 text-white px-6 py-3 rounded-lg font-semibold text-sm shadow-lg print:hidden" onclick="window.print()">🖨️ Print Receipt</button>

    <div class="max-w-4xl mx-auto bg-white p-10 shadow-lg">
        <div class="header">
            <h1>SALES RECEIPT</h1>
            <p>Wood Inventory Management System</p>
        </div>

        <div class="receipt-info">
            <div class="info-section">
                <h3>Order Information</h3>
                <p><span class="info-label">Order Number:</span> {{ $salesOrder->order_number }}</p>
                <p><span class="info-label">Order Date:</span> {{ \Carbon\Carbon::parse($salesOrder->order_date)->format('F d, Y') }}</p>
                <p><span class="info-label">Delivery Date:</span> {{ \Carbon\Carbon::parse($salesOrder->delivery_date)->format('F d, Y') }}</p>
                <p>
                    <span class="info-label">Status:</span> 
                    {{ $salesOrder->status }}
                </p>
            </div>

            <div class="info-section">
                <h3>Customer Information</h3>
                <p><span class="info-label">Name:</span> {{ $salesOrder->customer?->name ?? 'N/A' }}</p>
                <p><span class="info-label">Type:</span> {{ $salesOrder->customer?->customer_type ?? 'N/A' }}</p>
                @if($salesOrder->customer?->phone)
                    <p><span class="info-label">Phone:</span> {{ $salesOrder->customer->phone }}</p>
                @endif
                @if($salesOrder->customer?->email)
                    <p><span class="info-label">Email:</span> {{ $salesOrder->customer->email }}</p>
                @endif
                @if($salesOrder->customer?->address)
                    <p><span class="info-label">Address:</span> {{ $salesOrder->customer->address }}</p>
                @endif
            </div>
        </div>

        <table class="items-table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th class="text-right">Unit Price</th>
                    <th class="text-right">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salesOrder->items as $item)
                    <tr>
                        <td>{{ $item->product?->product_name ?? 'N/A' }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td class="text-right">₱{{ number_format($item->unit_price, 2) }}</td>
                        <td class="text-right">₱{{ number_format($item->total_price, 2) }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 30px; color: #9CA3AF;">
                            No items in this order
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="totals">
            <table class="totals-table">
                <tr>
                    <td>Subtotal:</td>
                    <td>₱{{ number_format($salesOrder->total_amount, 2) }}</td>
                </tr>
                <tr class="total-row">
                    <td>TOTAL:</td>
                    <td>₱{{ number_format($salesOrder->total_amount, 2) }}</td>
                </tr>
                <tr>
                    <td>Paid Amount:</td>
                    <td>₱{{ number_format($salesOrder->paid_amount, 2) }}</td>
                </tr>
                <tr style="border-top: 1px solid #E5E7EB;">
                    <td>Balance Due:</td>
                    <td style="color: {{ $salesOrder->total_amount - $salesOrder->paid_amount > 0 ? '#DC2626' : '#059669' }};">
                        ₱{{ number_format($salesOrder->total_amount - $salesOrder->paid_amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <td>Payment Status:</td>
                    <td>
                        <span class="status-badge status-{{ strtolower($salesOrder->payment_status) }}">
                            {{ $salesOrder->payment_status }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        @if($salesOrder->note)
            <div class="note-section">
                <h4>Notes:</h4>
                <p>{{ $salesOrder->note }}</p>
            </div>
        @endif

        <div class="footer">
            <p>Thank you for your business!</p>
            <p>Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
        </div>
    </div>

    <script>
        // Optional: Auto-print on load
        // window.onload = function() { window.print(); }
    </script>
</body>
</html>
