<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class saving extends Model
{
    protected $table = 'savings';  

    protected $fillable = ['user_id', 'animal_id', 'total_savings', 'status'];
}
