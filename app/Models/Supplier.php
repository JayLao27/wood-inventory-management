<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
        'payment_terms',
        'status',
        'total_orders',
        'total_spent'
    ];

    protected $casts = [
        'total_orders' => 'decimal:2',
        'total_spent' => 'decimal:2'
    ];

    public function materials(): HasMany
    {
        return $this->hasMany(Material::class);
    }

    public function purchaseOrders(): HasMany
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}