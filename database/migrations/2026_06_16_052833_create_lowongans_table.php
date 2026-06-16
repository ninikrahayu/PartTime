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
        Schema::create('lowongans', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users (Penyedia UMKM) dan categories
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade');
            
            // Informasi Pekerjaan
            $table->string('title');
            $table->text('description');
            $table->text('requirements');
            
            // Lokasi, Gaji, Jadwal
            $table->string('location');
            $table->integer('salary');
            $table->string('salary_type'); // misal: Per Jam, Per Hari, Per Bulan
            $table->string('schedule');
            
            // Tanggal dan Kuota
            $table->date('start_date');
            $table->date('end_date');
            $table->integer('quota');
            $table->date('deadline');
            
            // Tambahan
            $table->string('contact')->nullable();
            
            // Status: pending (menunggu review admin), active (disetujui), rejected, closed
            $table->enum('status', ['pending', 'active', 'rejected', 'closed'])->default('pending');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lowongans');
    }
};
