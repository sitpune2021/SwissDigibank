<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            DB::statement("ALTER TABLE dd_transactions MODIFY COLUMN type ENUM('credit', 'debit') NOT NULL DEFAULT 'credit'");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            DB::statement("ALTER TABLE dd_transactions MODIFY COLUMN type VARCHAR(255) NOT NULL DEFAULT 'credit'");
        });
    }
};
