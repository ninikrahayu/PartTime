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
        Schema::table('users', function (Blueprint $table) {
            $table->index('name');
            $table->index('email');
            $table->index('role');
            $table->index('status');
        });

        Schema::table('lowongans', function (Blueprint $table) {
            $table->index('judul');
            $table->index('category');
            $table->index('status');
        });

        Schema::table('lamarans', function (Blueprint $table) {
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lamarans', function (Blueprint $table) {
            $table->dropIndex(['status']);
        });

        Schema::table('lowongans', function (Blueprint $table) {
            $table->dropIndex(['judul']);
            $table->dropIndex(['category']);
            $table->dropIndex(['status']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['email']);
            $table->dropIndex(['role']);
            $table->dropIndex(['status']);
        });
    }
};
