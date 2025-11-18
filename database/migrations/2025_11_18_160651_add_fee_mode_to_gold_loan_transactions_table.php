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
        Schema::table('gold_loan_transactions', function (Blueprint $table) {
            $table->string('fee_mode', 50)->after('amount_collected')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_loan_transactions', function (Blueprint $table) {
            $table->dropColumn('fee_mode');
        });
    }
};
