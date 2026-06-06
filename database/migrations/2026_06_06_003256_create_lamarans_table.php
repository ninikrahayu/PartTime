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
    Schema::create('lamarans', function (Blueprint $table) {
        $table->id();
        $table->foreignId('pelamar_id')->constrained('users')->onDelete('cascade');
        $table->foreignId('lowongan_id')->constrained('lowongans')->onDelete('cascade');
        
        $table->text('catatan_tambahan')->nullable();
        
        $table->enum('status', ['pending', 'diproses', 'diterima', 'ditolak'])->default('pending');
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lamarans');
    }
};
