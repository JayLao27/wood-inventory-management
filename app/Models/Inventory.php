<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';
    protected $primaryKey = 'raw_material_id';

    protected $fillable = [
        'finished_product_id',
        'reference_id',
        'item_id',
        'item_type',
        'movement_type',
        'quantity',
        'reference_type',
        'notes'
    ];

    protected $casts = [
        'quantity' => 'decimal:2',
    ];
}
