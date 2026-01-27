<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\type;

class Accounting extends Model
{
  
    protected $table = 'accountings';

    protected $fillable = [
        'transaction_type',
        'reference_id',
        'transaction_number',
        'type',
        'amount',
        'description',
        'transaction_date',
        'payment_method',
    ];
        

}
