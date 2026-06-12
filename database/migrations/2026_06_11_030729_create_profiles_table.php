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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            
            // --- KOLOM KHUSUS MAHASISWA ---
            $table->string('nim')->nullable();
            $table->string('universitas')->nullable();
            $table->string('fakultas')->nullable();
            $table->string('jurusan')->nullable();
            $table->integer('semester')->nullable();
            $table->text('alamat')->nullable(); // Bisa dipakai sebagai alamat mahasiswa
            $table->string('ktm_path')->nullable(); // Path file PDF/JPG KTM
            
            // --- KOLOM KHUSUS PENYEDIA (UMKM) ---
            $table->string('business_name')->nullable();
            $table->string('business_type')->nullable();
            $table->string('business_email')->nullable();
            $table->string('business_phone')->nullable();
            $table->text('business_address')->nullable();
            $table->text('description')->nullable();
            $table->string('logo_path')->nullable(); // Path logo usaha
            $table->string('document_path')->nullable(); // Path dokumen verifikasi usaha
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
