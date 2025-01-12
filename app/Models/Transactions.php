<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $table = 'transactions';

    protected $fillable = [
        'user_id',
        'saving_id',
        'amount',
        'transaction_date',
        'status',
    ];

    protected $casts = [
        'amount' => 'float',
        'transaction_date' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function saving() 
    {
        return $this->belongsTo(Saving::class, 'saving_id'); 
    }

    public static function boot()
    {
        parent::boot();

        // Registering the saving event
        self::saving(function ($transaction) {
           
            // For example, modify attributes before saving
            $transaction->field = strtoupper($transaction->field);
        });
    }
}