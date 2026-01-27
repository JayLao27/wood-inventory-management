<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accounting extends Model
{
    protected $table = 'accountings';

    protected $fillable = [
        'transaction_type',
        'amount',
        'date',
        'description',
        'sales_order_id',
        'purchase_order_id',
    ];

    protected $casts = [
        'date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Relationships
    public function salesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}
