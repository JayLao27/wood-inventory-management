<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $primaryKey = 'customer_id';

    protected $fillable = [
        'customer_name',
        'contact_person',
        'phone',
        'email',
        'address',
        'customer_type',
        'total_orders',
        'total_spent'
    ];

    protected $casts = [
        'total_orders' => 'integer',
        'total_spent' => 'decimal:2'
    ];

    public function salesOrders()
    {
        return $this->hasMany(SalesOrder::class, 'customer_id', 'customer_id');
    }
}