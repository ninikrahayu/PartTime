<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            // Change enum to string so it can support all status types
            $table->string('status')->default('menunggu_review')->change();
        });
    }

    public function down(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            // Can't reliably revert to enum without risking data loss
            $table->string('status')->default('aktif')->change();
        });
    }
};
