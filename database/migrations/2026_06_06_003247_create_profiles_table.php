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
        
        $table->string('universitas')->nullable();
        $table->integer('semester')->nullable();
        $table->string('jurusan')->nullable();
        $table->string('cv_path')->nullable(); // FR-009: Tempat simpan link file PDF CV
        
        $table->string('nama_toko')->nullable();
        $table->text('deskripsi_usaha')->nullable();
        $table->text('alamat_lengkap')->nullable();
        $table->string('jam_operasional')->nullable();
        $table->string('foto_usaha_path')->nullable(); 
        
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
