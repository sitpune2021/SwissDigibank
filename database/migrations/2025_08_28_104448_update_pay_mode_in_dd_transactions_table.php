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

            // जर आधीचे online values असतील तर migrate मध्येच update करू
            DB::statement("UPDATE dd_transactions SET pay_mode = 'onlineTr' WHERE pay_mode = 'online'");

            // ENUM redefine करा
            DB::statement("ALTER TABLE dd_transactions MODIFY pay_mode ENUM('cash','onlineTr','cheque','saving') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            // Rollback करताना परत online ने बदल
            DB::statement("UPDATE dd_transactions SET pay_mode = 'online' WHERE pay_mode = 'onlineTr'");
            DB::statement("ALTER TABLE dd_transactions MODIFY pay_mode ENUM('cash','online','cheque','saving') NOT NULL");
        });
    }
};
