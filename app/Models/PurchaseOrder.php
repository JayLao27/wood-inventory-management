<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'order_number',
        'supplier_id',
        'order_date',
        'expected_delivery',
        'total_amount',
        'paid_amount',
        'notes',
        'status',
        'assigned_to',
        'quality_status',
        'approved_by',
        'approval_date',
        'updated_date'
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery' => 'date',
        'approval_date' => 'datetime',
        'updated_date' => 'datetime',
        'total_amount' => 'decimal:2',
        'paid_amount' => 'decimal:2'
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }
}