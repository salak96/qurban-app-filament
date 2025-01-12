<?php

// App\Models\Saving.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Saving extends Model
{
    use HasFactory;

    // Menambahkan kolom yang dapat diisi secara massal
    protected $fillable = [
        'user_id',      // Menambahkan user_id ke dalam fillable
        'animal_id',    // Menambahkan animal_id ke dalam fillable
        'total_savings', // Menambahkan total_savings ke dalam fillable
        'status',       // Menambahkan status ke dalam fillable
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function animal()
    {
        return $this->belongsTo(Animal::class);
    }
}