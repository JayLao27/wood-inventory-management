<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    protected $fillable = [
        'order_number', 'customer_id', 'order_date',
        'delivery_date', 'total_amount', 'status',
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

    public function hasWorkOrders()
    {
        return $this->workOrders()->exists();
    }
}

