@php
    $statusColors = [
        'pending' => 'bg-yellow-500',
        'in_progress' => 'bg-blue-500',
        'completed' => 'bg-green-500',
        'overdue' => 'bg-red-500',
        'cancelled' => 'bg-gray-500'
    ];
    
    $statusColor = $statusColors[$workOrder->status] ?? 'bg-gray-500';
    $statusLabel = ucwords(str_replace('_', ' ', $workOrder->status));

    // Dynamic Overdue Check
    $today = \Illuminate\Support\Carbon::today();
    $isOverdue = $workOrder->due_date && $workOrder->due_date->lt($today) && !in_array($workOrder->status, ['completed', 'cancelled', 'overdue']);

    if ($isOverdue) {
        $statusColor = 'bg-red-500';
        $statusLabel = 'Overdue';
    }
@endphp

<tr class="table w-full table-fixed hover:bg-slate-700/50 transition-colors duration-200 cursor-pointer" onclick="viewWorkOrder({{ $workOrder->id }})">
    <td class="px-4 py-3 font-mono text-slate-300 w-[15%]">
        {{ $workOrder->order_number }}
    </td>
    <td class="px-4 py-3 font-medium text-white w-[20%] truncate" title="{{ $workOrder->product_name }}">
        {{ $workOrder->product_name }}
    </td>
    <td class="px-4 py-3 text-slate-300 w-[10%]">
        {{ $workOrder->quantity }}
    </td>
    <td class="px-4 py-3 text-slate-300 w-[15%] truncate" title="{{ $workOrder->assigned_to }}">
        {{ $workOrder->assigned_to }}
    </td>
    <td class="px-4 py-3 text-slate-300 w-[15%]">
        {{ $workOrder->due_date ? $workOrder->due_date->format('M d, Y') : '-' }}
    </td>
    <td class="px-4 py-3 w-[15%]">
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusColor }} text-white shadow-sm">
            {{ $statusLabel }}
        </span>
    </td>
    <td class="px-4 py-3 w-[10%] text-right">
        <div class="flex items-center justify-end space-x-2">
            @if(!in_array($workOrder->status, ['completed', 'cancelled']))
            <button onclick="event.stopPropagation(); openCompleteConfirmModal({{ $workOrder->id }}, '{{ $workOrder->order_number }}')" class="text-green-400 hover:text-green-300 transition-colors" title="Complete">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
            </button>
            <button onclick="event.stopPropagation(); openCancelConfirmModal({{ $workOrder->id }}, '{{ $workOrder->order_number }}')" class="text-red-400 hover:text-red-300 transition-colors" title="Cancel">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
            @endif
        </div>
    </td>
</tr>
