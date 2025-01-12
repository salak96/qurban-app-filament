<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class transactions extends Model
{
    protected $table = 'transactions';  

    protected $fillable = ['user_id', 'saving_id', 'amount', 'transaction_date'];
}
