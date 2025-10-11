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
        Schema::table('membership_charges_transaction', function (Blueprint $table) {
            DB::statement("ALTER TABLE membership_charges_transaction CHANGE charges_pay_mode charges_pay_mode ENUM('cash', 'online', 'cheque', 'saving') NOT NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_charges_transaction', function (Blueprint $table) {
            DB::statement("ALTER TABLE membership_charges_transaction CHANGE charges_pay_mode charges_pay_mode ENUM('cash', 'online', 'cheque') NOT NULL");
        });
    }
};
