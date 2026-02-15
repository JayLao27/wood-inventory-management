<div onclick="viewWorkOrder({{ $workOrder->id }})" class="p-5 border-2 border-slate-600 rounded-xl hover:border-amber-500 hover:bg-slate-600/50 transition-all shadow-lg hover:shadow-xl backdrop-blur-sm cursor-pointer work-order-row" data-order-number="{{ $workOrder->order_number }}" data-product-name="{{ $workOrder->product_name }}" data-assigned-to="{{ $workOrder->assigned_to }}" data-status="{{ $workOrder->status }}">
    <div class="flex justify-between items-start">
        <div class="flex-1">
            <h3 class="font-bold text-white text-lg">{{ $workOrder->order_number }} • {{ $workOrder->product_name }}</h3>
            <p class="text-base text-slate-300 font-medium mt-1">Due: {{ $workOrder->due_date->format('m/d/Y') }} • Assigned: {{ $workOrder->assigned_to }}</p>
        </div>
        <div class="flex items-center space-x-3">
            @php
                $statusColors = [
                    'pending' => 'bg-yellow-500',
                    'in_progress' => 'bg-blue-500',
                    'quality_check' => 'bg-purple-500',
                    'completed' => 'bg-green-500',
                    'overdue' => 'bg-red-500',
                    'cancelled' => 'bg-gray-500'
                ];
                $statusColor = $statusColors[$workOrder->status] ?? 'bg-gray-500';
                $statusLabel = ucwords(str_replace('_', ' ', $workOrder->status));
            @endphp
            <span class="px-4 py-2 {{ $statusColor }} text-white text-xs font-bold rounded-xl shadow-lg">
                {{ $statusLabel }}
            </span>
        </div>
    </div>
    <div class="grid grid-cols-4 gap-4 mt-4 text-base">
        <div>
            <span class="text-slate-400 font-medium text-xs">Quantity</span>
            <p class="text-white font-bold text-lg mt-1">{{ $workOrder->quantity }} pcs</p>
        </div>
        <div>
            <span class="text-slate-400 font-medium text-xs">Starting Date</span>
            <p class="text-white font-bold text-lg mt-1">{{ $workOrder->created_at ? \Carbon\Carbon::parse($workOrder->created_at)->format('m/d/Y') : 'N/A' }}</p>
        </div>
        <div>
            <span class="text-slate-400 font-medium text-xs">Due Date</span>
            <p class="text-white font-bold text-lg mt-1">{{ $workOrder->due_date->format('m/d/Y') }}</p>
        </div>
        <div class="flex items-center space-x-2 justify-end">
            <button onclick="event.stopPropagation(); openCompleteConfirmModal({{ $workOrder->id }}, '{{ $workOrder->order_number }}')" class="p-2.5 hover:bg-slate-500 rounded-lg transition-all" title="Complete">
                <svg class="w-3.5 h-3.5 text-blue-400" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    </div>
</div>
