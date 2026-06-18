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
        Schema::table('lowongans', function (Blueprint $table) {
            $table->string('category')->nullable()->after('judul');
            $table->string('salary_type')->nullable()->after('gaji');
            $table->date('start_date')->nullable()->after('status');
            $table->date('end_date')->nullable()->after('start_date');
            $table->integer('quota')->nullable()->after('end_date');
            $table->date('deadline')->nullable()->after('quota');
            $table->string('contact')->nullable()->after('deadline');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lowongans', function (Blueprint $table) {
            $table->dropColumn(['category', 'salary_type', 'start_date', 'end_date', 'quota', 'deadline', 'contact']);
        });
    }
};
