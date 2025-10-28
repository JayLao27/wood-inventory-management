<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'product_name',
        'quantity',
        'completion_quantity',
        'status',
        'due_date',
        'assigned_to',
        'priority',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'date',
    ];

    public function getStatusColorAttribute()
    {
        return match($this->status) {
            'pending' => 'text-gray-500',
            'in_progress' => 'text-blue-500',
            'quality_check' => 'text-yellow-500',
            'completed' => 'text-green-500',
            'overdue' => 'text-red-500',
            default => 'text-gray-500'
        };
    }

    public function getPriorityColorAttribute()
    {
        return match($this->priority) {
            'low' => 'text-green-500',
            'medium' => 'text-yellow-500',
            'high' => 'text-red-500',
            default => 'text-gray-500'
        };
    }

    public function isOverdue()
    {
        return $this->due_date < now() && $this->status !== 'completed';
    }
}