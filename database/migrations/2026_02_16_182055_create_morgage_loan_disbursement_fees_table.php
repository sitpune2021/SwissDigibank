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
        Schema::create('mortgage_loan_disbursement_fee_modes', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('morg_disbursement_id');

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

            // ✅ SHORT FOREIGN KEY NAME
            $table->foreign('morg_disbursement_id', 'fk_mldfm_disbursement')
                ->references('id')
                ->on('mortgage_loan_disbursements')
                ->onDelete('cascade');

            $table->foreign('bank_id', 'fk_mldfm_bank')
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
        Schema::dropIfExists('mortgage_loan_disbursement_fee_modes');
    }
};
