<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaction Receipt - {{ $transactionId }}</title>
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
        <div class="text-center border-b-4 border-slate-700 pb-5 mb-8">
            <h1 class="text-4xl font-bold text-slate-700 mb-1">TRANSACTION RECEIPT</h1>
            <p class="text-gray-500 text-sm">Wood Inventory Management System</p>
        </div>

        <div class="flex justify-between mb-8">
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-slate-700 uppercase mb-3">Transaction Information</h3>
                <p class="my-1 text-gray-600 text-sm">
                    <span class="font-semibold inline-block w-36">Transaction ID:</span> 
                    {{ $transactionId }}
                </p>
                <p class="my-1 text-gray-600 text-sm">
                    <span class="font-semibold inline-block w-36">Date:</span> 
                    {{ \Carbon\Carbon::parse($transaction->date)->format('F d, Y') }}
                </p>
                <p class="my-1 text-gray-600 text-sm">
                    <span class="font-semibold inline-block w-36">Type:</span> 
                    <span class="font-semibold {{ $transaction->transaction_type === 'Income' ? 'text-green-600' : 'text-red-600' }}">
                        {{ $transaction->transaction_type }}
                    </span>
                </p>
            </div>

            <div class="flex-1">
                <h3 class="text-sm font-semibold text-slate-700 uppercase mb-3">
                    @if($transaction->salesOrder)
                        Customer Information
                    @elseif($transaction->purchaseOrder)
                        Supplier Information
                    @else
                        Additional Information
                    @endif
                </h3>
                @if($transaction->salesOrder)
                    <p class="my-1 text-gray-600 text-sm">
                        <span class="font-semibold inline-block w-36">Customer Name:</span> 
                        {{ $transaction->salesOrder->customer->name ?? 'N/A' }}
                    </p>
                    <p class="my-1 text-gray-600 text-sm">
                        <span class="font-semibold inline-block w-36">Customer Type:</span> 
                        {{ $transaction->salesOrder->customer->customer_type ?? 'N/A' }}
                    </p>
                    <p class="my-1 text-gray-600 text-sm">
                        <span class="font-semibold inline-block w-36">Order Number:</span> 
                        {{ $transaction->salesOrder->order_number }}
                    </p>
                    @if($transaction->salesOrder->customer->phone)
                        <p class="my-1 text-gray-600 text-sm">
                            <span class="font-semibold inline-block w-36">Phone:</span> 
                            {{ $transaction->salesOrder->customer->phone }}
                        </p>
                    @endif
                @elseif($transaction->purchaseOrder)
                    <p class="my-1 text-gray-600 text-sm">
                        <span class="font-semibold inline-block w-36">Supplier Name:</span> 
                        {{ $transaction->purchaseOrder->supplier->name ?? 'N/A' }}
                    </p>
                    <p class="my-1 text-gray-600 text-sm">
                        <span class="font-semibold inline-block w-36">Order Number:</span> 
                        {{ $transaction->purchaseOrder->order_number }}
                    </p>
                    @if($transaction->purchaseOrder->supplier->contact_person)
                        <p class="my-1 text-gray-600 text-sm">
                            <span class="font-semibold inline-block w-36">Contact Person:</span> 
                            {{ $transaction->purchaseOrder->supplier->contact_person }}
                        </p>
                    @endif
                    @if($transaction->purchaseOrder->supplier->phone)
                        <p class="my-1 text-gray-600 text-sm">
                            <span class="font-semibold inline-block w-36">Phone:</span> 
                            {{ $transaction->purchaseOrder->supplier->phone }}
                        </p>
                    @endif
                @else
                    <p class="my-1 text-gray-600 text-sm">
                        <span class="font-semibold inline-block w-36">Description:</span> 
                        {{ $transaction->description ?? 'N/A' }}
                    </p>
                @endif
            </div>
        </div>

        <div class="bg-slate-50 border-2 border-slate-700 rounded-lg p-8 my-8">
            <div class="flex justify-between items-center">
                <div>
                    <h2 class="text-sm text-gray-500 font-medium uppercase">Transaction Amount</h2>
                    <p class="text-4xl font-bold mt-2 {{ $transaction->transaction_type === 'Income' ? 'text-green-600' : 'text-red-600' }}">
                        ₱{{ number_format($transaction->amount, 2) }}
                    </p>
                </div>
                <div class="text-right">
                    <span class="inline-block px-4 py-2 rounded-lg text-sm font-semibold {{ $transaction->transaction_type === 'Income' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                        {{ $transaction->transaction_type }}
                    </span>
                </div>
            </div>
        </div>

        @if($transaction->salesOrder)
            <div class="mt-8 p-4 bg-blue-50 border-l-4 border-blue-500">
                <h4 class="text-sm font-semibold text-blue-900 mb-2">Related Sales Order</h4>
                <p class="text-sm text-blue-800">
                    Order #{{ $transaction->salesOrder->order_number }} - 
                    Total: ₱{{ number_format($transaction->salesOrder->total_amount, 2) }} - 
                    Status: {{ $transaction->salesOrder->status }}
                </p>
            </div>
        @elseif($transaction->purchaseOrder)
            <div class="mt-8 p-4 bg-purple-50 border-l-4 border-purple-500">
                <h4 class="text-sm font-semibold text-purple-900 mb-2">Related Purchase Order</h4>
                <p class="text-sm text-purple-800">
                    Order #{{ $transaction->purchaseOrder->order_number }} - 
                    Total: ₱{{ number_format($transaction->purchaseOrder->total_amount, 2) }} - 
                    Status: {{ $transaction->purchaseOrder->status }}
                </p>
            </div>
        @endif

        @if($transaction->description)
            <div class="mt-8 p-4 bg-gray-50 border-l-4 border-slate-700">
                <h4 class="text-sm font-semibold text-slate-700 mb-2">Notes:</h4>
                <p class="text-sm text-gray-600 leading-relaxed">{{ $transaction->description }}</p>
            </div>
        @endif

        <div class="mt-12 pt-5 border-t border-gray-200 text-center text-gray-500 text-xs">
            <p>Thank you for your business!</p>
            <p>Generated on {{ now()->format('F d, Y \a\t h:i A') }}</p>
        </div>
    </div>
</body>
</html>
