@use('App\Models\SalesOrder')
<tr class="hover:bg-slate-600 transition cursor-pointer data-row" data-order-id="{{ $order->id }}" data-status="{{ $order->status }}" data-payment="{{ $order->payment_status }}">
    <td class="px-3 py-3 font-mono text-slate-300">{{ $order->order_number }}</td>
    <td class="px-3 py-3">
        <div class="font-medium text-slate-300">{{ $order->customer?->name }}</div>
        @php $ct = $order->customer?->customer_type; $ctBg = $customerTypeBg[$ct] ?? '#e5e7eb'; @endphp
        <span class="mt-1 inline-block text-xs font-semibold text-white px-2 py-0.5 rounded" style="background: {{ $ctBg }};">{{ $ct }}</span>
    </td>
    <td class="px-3 py-3 text-slate-300">{{ \Illuminate\Support\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
    @php
        $delivery = \Illuminate\Support\Carbon::parse($order->delivery_date);
        $due = $order->due_date ? \Illuminate\Support\Carbon::parse($order->due_date) : $delivery;
        $today = \Illuminate\Support\Carbon::today();
        $isDueToday = $due->isToday();
        $isOverdue = $due->lt($today);
        $diff = $due->diffInDays($today);
    @endphp
    <td class="px-3 py-3 text-slate-300">
        @if ($isDueToday)
            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-red-600 text-white">Due Today</span>
        @elseif ($isOverdue)
            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-red-600 text-white">Overdue {{ $diff == 1 ? '1 day' : $diff . ' days' }}</span>
        @else
            @php $ahead = $today->diffInDays($due); @endphp
            <span class="text-[10px] font-semibold px-2 py-0.5 rounded bg-amber-500 text-white">Due in {{ $ahead == 1 ? '1 day' : $ahead . ' days' }}</span>
        @endif
    </td>
    <td class="px-3 py-3 text-slate-300">
        {{ $delivery->format('M d, Y') }}
    </td>
    <td class="px-3 py-3">
        @php
        $sb = $order->status === 'Pending' ? '#ffffff' : ($statusBg[$order->status] ?? '#e5e7eb');
        $stText = $order->status === 'Pending' ? 'text-gray-900' : 'text-white';
        // Add specific color for Cancelled
        if ($order->status === 'Cancelled') {
            $sb = '#ef4444'; // Red-500
            $stText = 'text-white';
        }
        @endphp
        <span class="text-[10px] font-bold px-2 py-0.5 rounded {{ $stText }}" style="background: {{ $sb }};">{{ $order->status }}</span>
    </td>


    <td class="px-3 py-3 font-bold text-slate-300">₱{{ number_format($order->total_amount, 2) }}</td>
    @php
    $pb = $paymentBg[$order->payment_status] ?? '#ffffff';
    $ptText = $order->payment_status === 'Pending' ? 'text-gray-900' : 'text-white';
    $pendingBorder = $order->payment_status==='Pending' ? 'border border-gray-300' : '';
    @endphp
    <td class="px-3 py-3">
        @if($order->payment_status === 'Paid')
        <span class="text-xs font-semibold text-green-400">{{ $order->payment_status }}</span>
        @elseif($order->payment_status === 'Partial')
        <span class="text-xs font-semibold text-yellow-400">{{ $order->payment_status }}</span>
        @else
        <span class="text-xs font-semibold text-slate-400">{{ $order->payment_status }}</span>
        @endif
    </td>
    <td class="px-3 py-3">
        <div class="flex space-x-2">
            <button onclick="openModal('viewOrderModal-{{ $order->id }}')" class="p-1 hover:bg-slate-500 rounded" title="View">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            </button>
            @if($order->status !== 'Cancelled')
            <button onclick="openModal('editOrderModal-{{ $order->id }}')" class="p-1 hover:bg-slate-500 rounded" title="Edit">
                <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
            </button>
            @if(!in_array($order->payment_status, ['Paid', 'Partial']))
            <button type="button" onclick="openCancelSalesOrderModal({{ $order->id }}, '{{ $order->order_number }}')" class="p-1 hover:bg-slate-500 rounded" title="Cancel">
                <svg class="w-3 h-3 text-red-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
            @endif
            @endif
        </div>


    </td>
</tr>

