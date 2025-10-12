<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = ['name', 'customer_type', 'phone', 'email'];

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class);
    }

    public function totalOrders()
    {
        return $this->salesOrders()->count();
    }

    public function totalSpent()
    {
        return $this->salesOrders()->sum('total_amount');
    }
}
