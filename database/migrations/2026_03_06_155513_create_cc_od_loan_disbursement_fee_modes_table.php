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
        Schema::create('cc_od_loan_disbursement_fee_modes', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('cc_od_disbursement_id');

            $table->enum('fee_type', [
                'stamp_duty',
                'issuer_fee',
                'processing_fee'
            ]);

            $table->enum('payment_mode', ['cash', 'cheque', 'online']);

            // Cheque Details
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

            // Online Details
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->enum('transfer_mode', ['imps', 'vpa', 'neft_rtgs'])->nullable();

            $table->string('credited_account')->nullable();

            $table->timestamps();
            $table->foreign('cc_od_disbursement_id')
                ->references('id')
                ->on('cc_od_loan_disbursments')
                ->onDelete('cascade');

            $table->foreign('bank_id')
                ->references('id')
                ->on('banks')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cc_od_loan_disbursement_fee_modes');
    }
};
