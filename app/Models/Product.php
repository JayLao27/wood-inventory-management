<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
	protected $fillable = ['name', 'unit_price'];

	public function items()
	{
		return $this->hasMany(SalesOrderItem::class);
	}
}
