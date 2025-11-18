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
            $table->unsignedBigInteger('bank_id')->nullable()->after('fee_mode');
            $table->string('cheque_no', 50)->nullable()->after('bank_id');
            $table->date('cheque_date')->nullable()->after('cheque_no');

            // Online Transfer Details
            $table->string('utr_no', 100)->nullable()->after('cheque_date');
            $table->string('transfer_mode', 50)->nullable()->after('utr_no');
            $table->string('credited_to_company', 10)->nullable()->after('transfer_mode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_loan_transactions', function (Blueprint $table) {
            $table->dropColumn([
                'bank_id',
                'cheque_no',
                'cheque_date',
                'utr_no',
                'transfer_mode',
                'credited_to_company',
            ]);
        });
    }
};
