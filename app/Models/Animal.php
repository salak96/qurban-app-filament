<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animal extends Model
{
    use HasFactory;

    // Jika Anda menggunakan tabel yang bukan 'animals', tentukan nama tabel
    protected $table = 'animals';  

    // Menentukan atribut yang dapat diisi mass-assignment
    protected $fillable = ['name', 'price', 'description'];
}
