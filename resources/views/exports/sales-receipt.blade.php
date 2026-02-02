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
    <div class="max-w-4xl mx-auto bg-white p-10 shadow-lg">
        <div class="text-center border-b-4 border-slate-700 pb-5 mb-8">
            <h1 class="text-4xl font-bold text-slate-700 mb-1">SALES RECEIPT</h1>
            <p class="text-gray-500 text-sm">Wood Inventory Management System</p>
        </div>

        <div class="flex justify-between mb-8">
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-slate-700 uppercase mb-3">Order Information</h3>
                <p class="my-1 text-gray-600 text-sm">
                    <span class="font-semibold inline-block w-32">Order Number:</span> 
                    {{ $salesOrder->order_number }}
                </p>
                <p class="my-1 text-gray-600 text-sm">
                    <span class="font-semibold inline-block w-32">Order Date:</span> 
                    {{ \Carbon\Carbon::parse($salesOrder->order_date)->format('F d, Y') }}
                </p>
                <p class="my-1 text-gray-600 text-sm">
                    <span class="font-semibold inline-block w-32">Delivery Date:</span> 
                    {{ \Carbon\Carbon::parse($salesOrder->delivery_date)->format('F d, Y') }}
                </p>
                <p class="my-1 text-gray-600 text-sm">
                    <span class="font-semibold inline-block w-32">Status:</span> 
                    {{ $salesOrder->status }}
                </p>
            </div>

            <div class="flex-1">
                <h3 class="text-sm font-semibold text-slate-700 uppercase mb-3">Customer Information</h3>
                <p class="my-1 text-gray-600 text-sm">
                    <span class="font-semibold inline-block w-32">Name:</span> 
                    {{ $salesOrder->customer?->name ?? 'N/A' }}
                </p>
                <p class="my-1 text-gray-600 text-sm">
                    <span class="font-semibold inline-block w-32">Type:</span> 
                    {{ $salesOrder->customer?->customer_type ?? 'N/A' }}
                </p>
                @if($salesOrder->customer?->phone)
                    <p class="my-1 text-gray-600 text-sm">
                        <span class="font-semibold inline-block w-32">Phone:</span> 
                        {{ $salesOrder->customer->phone }}
                    </p>
                @endif
                @if($salesOrder->customer?->email)
                    <p class="my-1 text-gray-600 text-sm">
                        <span class="font-semibold inline-block w-32">Email:</span> 
                        {{ $salesOrder->customer->email }}
                    </p>
                @endif
                @if($salesOrder->customer?->address)
                    <p class="my-1 text-gray-600 text-sm">
                        <span class="font-semibold inline-block w-32">Address:</span> 
                        {{ $salesOrder->customer->address }}
                    </p>
                @endif
            </div>
        </div>

        <table class="w-full border-collapse my-8">
            <thead class="bg-slate-700 text-white">
                <tr>
                    <th class="px-3 py-3 text-left text-sm font-semibold">Product</th>
                    <th class="px-3 py-3 text-left text-sm font-semibold">Quantity</th>
                    <th class="px-3 py-3 text-right text-sm font-semibold">Unit Price</th>
                    <th class="px-3 py-3 text-right text-sm font-semibold">Total</th>
                </tr>
            </thead>
            <tbody>
                @forelse($salesOrder->items as $item)
                    <tr class="hover:bg-gray-50">
                        <td class="px-3 py-3 border-b border-gray-200 text-sm text-gray-600">
                            {{ $item->product?->product_name ?? 'N/A' }}
                        </td>
                        <td class="px-3 py-3 border-b border-gray-200 text-sm text-gray-600">
                            {{ $item->quantity }}
                        </td>
                        <td class="px-3 py-3 border-b border-gray-200 text-sm text-gray-600 text-right">
                            ₱{{ number_format($item->unit_price, 2) }}
                        </td>
                        <td class="px-3 py-3 border-b border-gray-200 text-sm text-gray-600 text-right">
                            ₱{{ number_format($item->total_price, 2) }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-3 py-8 text-center text-gray-400">
                            No items in this order
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <div class="mt-8 flex justify-end">
            <table class="w-80">
                <tr>
                    <td class="py-2 pr-5 text-right text-sm text-gray-500 font-medium">Subtotal:</td>
                    <td class="py-2 text-right text-sm text-slate-700 font-semibold">
                        ₱{{ number_format($salesOrder->total_amount, 2) }}
                    </td>
                </tr>
                <tr class="border-t-2 border-slate-700">
                    <td class="pt-4 pr-5 text-right text-lg font-bold text-slate-700">TOTAL:</td>
                    <td class="pt-4 text-right text-lg font-bold text-slate-700">
                        ₱{{ number_format($salesOrder->total_amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-5 text-right text-sm text-gray-500 font-medium">Paid Amount:</td>
                    <td class="py-2 text-right text-sm text-slate-700 font-semibold">
                        ₱{{ number_format($salesOrder->paid_amount, 2) }}
                    </td>
                </tr>
                <tr class="border-t border-gray-200">
                    <td class="py-2 pr-5 text-right text-sm text-gray-500 font-medium">Balance Due:</td>
                    <td class="py-2 text-right text-sm font-semibold {{ $salesOrder->total_amount - $salesOrder->paid_amount > 0 ? 'text-red-600' : 'text-green-600' }}">
                        ₱{{ number_format($salesOrder->total_amount - $salesOrder->paid_amount, 2) }}
                    </td>
                </tr>
                <tr>
                    <td class="py-2 pr-5 text-right text-sm text-gray-500 font-medium">Payment Status:</td>
                    <td class="py-2 text-right">
                        <span class="inline-block px-3 py-1 rounded text-xs font-semibold 
                            {{ $salesOrder->payment_status === 'Paid' ? 'bg-green-100 text-green-800' : '' }}
                            {{ $salesOrder->payment_status === 'Pending' ? 'bg-yellow-100 text-yellow-800' : '' }}
                            {{ $salesOrder->payment_status === 'Partial' ? 'bg-orange-100 text-orange-800' : '' }}">
                            {{ $salesOrder->payment_status }}
                        </span>
                    </td>
                </tr>
            </table>
        </div>

        @if($salesOrder->note)
            <div class="mt-8 p-4 bg-gray-50 border-l-4 border-slate-700">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">Notes:</h4>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $salesOrder->note }}</p>
            </div>
        @endif

        <div class="mt-12 pt-5 border-t border-gray-200 text-center text-gray-500 text-xs">
            <p>Thank you for your business!</p>
            <p>Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
        </div>
    </div>
</body>
</html>
