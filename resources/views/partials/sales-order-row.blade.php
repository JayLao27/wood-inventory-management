@use('App\Models\SalesOrder')
@php
    $isArchive = $isArchive ?? false;
    $rowTextColor = $isArchive ? 'text-gray-700' : 'text-slate-300';
    $rowHoverClass = $isArchive ? 'hover:bg-white/90' : 'hover:bg-slate-600';
@endphp
<tr class="{{ $rowHoverClass }} transition cursor-pointer data-row" 
    data-order-id="{{ $order->id }}" 
    data-status="{{ $order->status }}" 
    data-payment="{{ $order->payment_status }}"
    @if($isArchive) style="background-color: rgba(255,255,255,0.7);" @endif>
    <td class="px-3 py-3 font-mono {{ $rowTextColor }}">{{ $order->order_number }}</td>
    <td class="px-3 py-3">
        <div class="font-medium {{ $rowTextColor }}">{{ $order->customer?->name }}</div>
        @php $ct = $order->customer?->customer_type; $ctBg = $customerTypeBg[$ct] ?? '#e5e7eb'; @endphp
        <span class="mt-1 inline-block text-[10px] font-bold text-white px-2 py-0.5 rounded shadow-sm" style="background: {{ $ctBg }};">{{ strtoupper($ct) }}</span>
    </td>
    <td class="px-3 py-3 {{ $rowTextColor }}">{{ \Illuminate\Support\Carbon::parse($order->order_date)->format('M d, Y') }}</td>
    @php
        $delivery = \Illuminate\Support\Carbon::parse($order->delivery_date);
        $due = $order->due_date ? \Illuminate\Support\Carbon::parse($order->due_date) : $delivery;
        $today = \Illuminate\Support\Carbon::today();
        $isDueToday = $due->isToday();
        $isOverdue = $due->lt($today);
        $diff = $due->diffInDays($today);
    @endphp
    @if(!$isArchive)
    <td class="px-3 py-3 font-medium">
        @if ($isDueToday)
            <span class="text-xs text-red-400">Due Today</span>
        @elseif ($isOverdue)
            <span class="text-xs text-red-500 font-bold underline">Overdue {{ $diff == 1 ? '1 day' : $diff . ' days' }}</span>
        @else
            @php $ahead = $today->diffInDays($due); @endphp
            <span class="text-xs text-amber-400">Due in {{ $ahead == 1 ? '1 day' : $ahead . ' days' }}</span>
        @endif
    </td>
    @endif
    <td class="px-3 py-3 {{ $rowTextColor }}">
        {{ $delivery->format('M d, Y') }}
    </td>
    <td class="px-3 py-3">
        @php
        $statusColors = [
            'Pending' => $isArchive ? 'text-slate-500' : 'text-slate-400',
            'In production' => 'text-amber-600',
            'Confirmed' => 'text-blue-600',
            'Ready' => 'text-purple-600',
            'Delivered' => 'text-green-600',
            'Cancelled' => 'text-red-600 font-bold',
        ];
        $stColor = $statusColors[$order->status] ?? ($isArchive ? 'text-gray-700' : 'text-slate-300');
        @endphp
        <span class="text-xs font-bold {{ $stColor }}">{{ $order->status }}</span>
    </td>


    <td class="px-3 py-3 font-bold {{ $rowTextColor }}">₱{{ number_format($order->total_amount, 2) }}</td>
    <td class="px-3 py-3">
        @if($order->payment_status === 'Paid')
        <span class="text-xs font-bold text-green-600">{{ $order->payment_status }}</span>
        @elseif($order->payment_status === 'Partial')
        <span class="text-xs font-bold text-amber-600">{{ $order->payment_status }}</span>
        @else
        <span class="text-xs font-bold text-slate-500">{{ $order->payment_status }}</span>
        @endif
    </td>
    <td class="px-3 py-3">
        <div class="flex space-x-2 items-center justify-center">
            <button onclick="openModal('viewOrderModal-{{ $order->id }}')" class="p-1.5 {{ $isArchive ? 'hover:bg-gray-200 text-gray-600' : 'hover:bg-slate-500 text-white' }} rounded-lg transition-all" title="View">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                    <path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />
                </svg>
            </button>
            @if(!in_array($order->status, ['Cancelled', 'Delivered']))
            <button onclick="openModal('editOrderModal-{{ $order->id }}')" class="p-1.5 {{ $isArchive ? 'hover:bg-gray-200 text-gray-600' : 'hover:bg-slate-500 text-white' }} rounded-lg transition-all" title="Edit">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M13.586 3.586a2 2 0 112.828 2.828l-.793.793-2.828-2.828.793-.793zM11.379 5.793L3 14.172V17h2.828l8.38-8.379-2.83-2.828z" />
                </svg>
            </button>
            @if($order->status === 'Ready')
            <button type="button" onclick="openDeliverOrderModal({{ $order->id }}, '{{ $order->order_number }}')" class="p-1.5 {{ $isArchive ? 'hover:bg-gray-200 text-green-600' : 'hover:bg-slate-500 text-green-400' }} rounded-lg transition-all" title="Deliver Order">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17a2 2 0 11-4 0 2 2 0 014 0zM19 17a2 2 0 11-4 0 2 2 0 014 0z" />
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0" />
                </svg>
            </button>
            @endif
            @if(!in_array($order->payment_status, ['Paid', 'Partial']) && $order->status === 'Pending')
            <button type="button" onclick="openCancelSalesOrderModal({{ $order->id }}, '{{ $order->order_number }}')" class="p-1.5 {{ $isArchive ? 'hover:bg-gray-200 text-red-600' : 'hover:bg-slate-500 text-red-400' }} rounded-lg transition-all" title="Cancel">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l1-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z" clip-rule="evenodd" />
                </svg>
            </button>
            @endif
            @endif
        </div>
    </td>
</tr>

