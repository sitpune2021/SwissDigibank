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
        Schema::table('dds_accounts', function (Blueprint $table) {
            // Drop the existing 'status' column if it exists
            $table->dropColumn('status');

            // Add the new 'status' column with ENUM type
            $table->enum('status', ['approved', 'pending'])->default('pending');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dds_accounts', function (Blueprint $table) {
            // Drop the ENUM column
            $table->dropColumn('status');
            
            // Revert back to an integer (or whatever was the original type)
            $table->integer('status')->default(0);
        });
    }
};
