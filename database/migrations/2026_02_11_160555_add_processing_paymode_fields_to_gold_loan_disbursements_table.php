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
        Schema::table('gold_loan_disbursements', function (Blueprint $table) {

            // ==========================
            // Processing Fee Paymode
            // ==========================

            $table->enum('processing_fee_mode', ['cash', 'cheque', 'online'])
                  ->nullable()
                  ->after('collect_processing_fee');

            // If cheque selected
            $table->unsignedBigInteger('p_bank_id')
                  ->nullable()
                  ->after('processing_fee_mode');

            $table->string('p_cheque_no')
                  ->nullable()
                  ->after('p_bank_id');

            $table->date('p_cheque_date')
                  ->nullable()
                  ->after('p_cheque_no');

            // If online selected
            $table->date('p_transfer_date')
                  ->nullable()
                  ->after('p_cheque_date');

            $table->string('p_utr_no')
                  ->nullable()
                  ->after('p_transfer_date');

            $table->enum('p_transfer_mode', ['imps', 'vpa', 'neft_rtgs'])
                  ->nullable()
                  ->after('p_utr_no');

            // Credited in Account (Yes/No)
            $table->boolean('processing_credited_account')
                  ->nullable()
                  ->after('p_transfer_mode');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_loan_disbursements', function (Blueprint $table) {

            $table->dropColumn([
                'processing_fee_mode',
                'p_bank_id',
                'p_cheque_no',
                'p_cheque_date',
                'p_transfer_date',
                'p_utr_no',
                'p_transfer_mode',
                'processing_credited_account',
            ]);

        });
    }
};
