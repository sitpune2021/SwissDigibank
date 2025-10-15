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
        Schema::table('rdschemes', function (Blueprint $table) {
            $table->integer('tenure_of_rd')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rdschemes', function (Blueprint $table) {
            $table->integer('tenure_of_rd');
        });
    }
};
