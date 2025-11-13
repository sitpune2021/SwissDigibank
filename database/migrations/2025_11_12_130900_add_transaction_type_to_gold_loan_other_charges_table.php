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
        Schema::table('gold_loan_other_charges', function (Blueprint $table) {
             $table->enum('transaction_type', ['debit', 'credit'])->default('debit')->after('loan_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_loan_other_charges', function (Blueprint $table) {
            $table->dropColumn('transaction_type');
        });
    }
};
