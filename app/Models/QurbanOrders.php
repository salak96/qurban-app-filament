<?php

// Model QurbanOrders
namespace App\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QurbanOrders extends Model
{
    use HasFactory;

    // Menambahkan kolom yang dapat di-assign secara massal
    protected $fillable = [
        'user_id',
        'animal_id',
        'savings_id',
        'order_status',
        'order_date',
    ];

    // Relasi dengan model User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Relasi dengan model Animal
    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }

    // Relasi dengan model Saving
    public function savings()
    {
        return $this->belongsTo(Saving::class);
    }
}
