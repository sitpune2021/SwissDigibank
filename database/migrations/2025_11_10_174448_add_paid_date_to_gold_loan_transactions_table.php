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
            $table->dateTime('paid_date')->nullable()->after('transaction_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_loan_transactions', function (Blueprint $table) {
            $table->dropColumn('paid_date');
        });
    }
};
