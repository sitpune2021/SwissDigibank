<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_againsst_disbursement_fees', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('loanagainsst_disbursement_id');

            $table->enum('fee_type', [
                'stamp_duty',
                'issuer_fee',
                'processing_fee'
            ]);

            $table->enum('payment_mode', ['cash', 'cheque', 'online']);

            $table->unsignedBigInteger('bank_id')->nullable();

            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->enum('transfer_mode', ['imps', 'vpa', 'neft_rtgs'])->nullable();

            $table->string('credited_account')->nullable();

            $table->timestamps();

            // ✅ SHORT FOREIGN KEY NAME
            $table->foreign('loanagainsst_disbursement_id', 'fk_ladf_disb')
                  ->references('id')
                  ->on('loanagainsst_disbursements')
                  ->onDelete('cascade');

            $table->foreign('bank_id', 'fk_ladf_bank')
                  ->references('id')
                  ->on('banks')
                  ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_againsst_disbursement_fees');
    }
};
