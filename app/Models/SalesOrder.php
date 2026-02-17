<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SalesOrder extends Model
{
    protected $fillable = [
        'order_number', 'customer_id', 'order_date',
        'delivery_date', 'due_date', 'total_amount', 'status',
        'paid_amount', 'payment_status', 'note'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(SalesOrderItem::class);
    }

    public function workOrders()
    {
        return $this->hasMany(WorkOrder::class);
    }

    public function accountingTransactions(): HasMany
    {
        return $this->hasMany(Accounting::class, 'sales_order_id');
    }

    public function hasWorkOrders()
    {
        return $this->workOrders()->exists();
    }
}

