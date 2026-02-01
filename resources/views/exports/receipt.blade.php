<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt - {{ $salesOrder->order_number }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .receipt-container {
            max-width: 800px;
            margin: 0 auto;
            background-color: white;
            padding: 40px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        .header {
            text-align: center;
            border-bottom: 3px solid #374151;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }

        .header h1 {
            font-size: 32px;
            color: #374151;
            margin-bottom: 5px;
        }

        .header p {
            color: #6B7280;
            font-size: 14px;
        }

        .receipt-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .info-section {
            flex: 1;
        }

        .info-section h3 {
            font-size: 14px;
            color: #374151;
            text-transform: uppercase;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .info-section p {
            margin: 5px 0;
            color: #4B5563;
            font-size: 14px;
        }

        .info-label {
            font-weight: 600;
            display: inline-block;
            width: 120px;
        }

        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin: 30px 0;
        }

        .items-table thead {
            background-color: #374151;
            color: white;
        }

        .items-table th {
            padding: 12px;
            text-align: left;
            font-size: 14px;
            font-weight: 600;
        }

        .items-table td {
            padding: 12px;
            border-bottom: 1px solid #E5E7EB;
            font-size: 14px;
            color: #4B5563;
        }

        .items-table tbody tr:hover {
            background-color: #F9FAFB;
        }

        .text-right {
            text-align: right;
        }

        .totals {
            margin-top: 30px;
            display: flex;
            justify-content: flex-end;
        }

        .totals-table {
            width: 300px;
        }

        .totals-table tr td {
            padding: 8px 0;
            font-size: 14px;
        }

        .totals-table tr td:first-child {
            text-align: right;
            padding-right: 20px;
            color: #6B7280;
            font-weight: 500;
        }

        .totals-table tr td:last-child {
            text-align: right;
            color: #374151;
            font-weight: 600;
        }

        .totals-table .total-row {
            border-top: 2px solid #374151;
            font-size: 18px;
            font-weight: bold;
        }

        .totals-table .total-row td {
            padding-top: 15px;
            color: #374151;
        }

        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #E5E7EB;
            text-align: center;
            color: #6B7280;
            font-size: 12px;
        }

        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 4px;
            font-size: 12px;
            font-weight: 600;
            margin-left: 10px;
        }

        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }

        .status-paid {
            background-color: #D1FAE5;
            color: #065F46;
        }

        .status-partial {
            background-color: #FED7AA;
            color: #9A3412;
        }

        .print-button {
            position: fixed;
            top: 20px;
            right: 20px;
            background-color: #374151;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
        }

        .print-button:hover {
            background-color: #1F2937;
        }

        @media print {
            body {
                background-color: white;
                padding: 0;
            }

            .receipt-container {
                box-shadow: none;
                padding: 20px;
            }

            .print-button {
                display: none;
            }
        }

        .note-section {
            margin-top: 30px;
            padding: 15px;
            background-color: #F9FAFB;
            border-left: 4px solid #374151;
        }

        .note-section h4 {
            font-size: 14px;
            color: #374151;
            margin-bottom: 8px;
        }

        .note-section p {
            font-size: 13px;
            color: #4B5563;
            line-height: 1.5;
        }
    </style>
</head>
<body>
    <button class="print-button" onclick="window.print()">🖨️ Print Receipt</button>

    <div class="receipt-container">
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
