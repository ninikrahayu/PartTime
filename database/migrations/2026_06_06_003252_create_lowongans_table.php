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

        $table->foreignId('penyedia_id')->constrained('users')->onDelete('cascade');
        
        $table->string('judul');
        $table->text('deskripsi');
        $table->string('kriteria')->nullable();
        $table->string('shift'); // Shift Jadwal Kerja
        $table->decimal('gaji', 15, 2)->nullable(); // Menyimpan nominal gaji
        $table->string('lokasi');
        
        $table->enum('status', ['aktif', 'closed'])->default('aktif');
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
