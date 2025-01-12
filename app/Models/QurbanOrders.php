<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QurbanOrders extends Model
{
    protected $table = 'qurban_orders';  

    protected $fillable = ['user_id', 'animal_id', 'savings_id', 'order_status', 'order_date', ];
}
