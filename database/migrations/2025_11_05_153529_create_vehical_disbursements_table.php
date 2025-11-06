<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehical_disbursements', function (Blueprint $table) {
            $table->id();

            // Foreign key reference (assuming loan_application_id refers to loan_applications table)
            $table->unsignedBigInteger('loan_application_id')->index();

            // Core fields
            $table->date('disbursal_date')->nullable();
            $table->date('emi_date')->nullable();

            // Amounts & Fees
            $table->decimal('loan_amount', 15, 2)->nullable();
            $table->decimal('processing_fee', 15, 2)->nullable();
            $table->decimal('gst_percent', 5, 2)->nullable();
            $table->decimal('sgst', 15, 2)->nullable();
            $table->decimal('cgst', 15, 2)->nullable();
            $table->decimal('igst', 15, 2)->nullable();
            $table->decimal('processing_fee_total', 15, 2)->nullable();
            $table->decimal('stamp_duty_fee', 15, 2)->nullable();
            $table->decimal('insurance_fee', 15, 2)->nullable();
            $table->decimal('advance_interest', 15, 2)->nullable();
            $table->decimal('final_amount', 15, 2)->nullable();

            // Disbursement mode 1
            $table->string('disburse_mode1', 50)->nullable();
            $table->string('payment_mode1', 50)->nullable();
            $table->unsignedBigInteger('bank_id1')->nullable();
            $table->string('cheque_no1', 50)->nullable();
            $table->date('cheque_date1')->nullable();
            $table->date('transfer_date1')->nullable();
            $table->string('utr_no1', 100)->nullable();
            $table->string('transfer_mode1', 50)->nullable();
            $table->string('saving_acc1', 100)->nullable();

            // Disbursement mode 2
            $table->string('disburse_mode2', 50)->nullable();
            $table->string('payment_mode2', 50)->nullable();
            $table->unsignedBigInteger('bank_id2')->nullable();
            $table->string('cheque_no2', 50)->nullable();
            $table->date('cheque_date2')->nullable();
            $table->date('transfer_date2')->nullable();
            $table->string('utr_no2', 100)->nullable();
            $table->string('transfer_mode2', 50)->nullable();
            $table->string('saving_acc2', 100)->nullable();

            $table->timestamps();

            // (Optional) Foreign key constraint
            // $table->foreign('loan_application_id')->references('id')->on('loan_applications')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehical_disbursements');
    }
};
