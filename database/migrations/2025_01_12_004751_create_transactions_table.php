<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Secara otomatis akan merujuk ke tabel 'users' dan kolom 'id'
            $table->foreignId('saving_id')->constrained()->onDelete('cascade'); // Secara otomatis akan merujuk ke tabel 'savings' dan kolom 'id'
            $table->decimal('amount', 12, 2)->default(0.00); // Menggunakan default untuk amount
            $table->timestamp('transaction_date')->useCurrent(); // Menggunakan waktu sekarang sebagai default
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending'); // Menggunakan enum untuk status
            $table->timestamps(); // Menambahkan created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
