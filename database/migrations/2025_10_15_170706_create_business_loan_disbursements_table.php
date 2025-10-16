<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_loan_disbursements', function (Blueprint $table) {
            $table->id();

            // relations
            $table->unsignedBigInteger('loan_application_id')->nullable();

            // disbursement details
            $table->date('disbursal_date')->nullable();
            $table->date('emi_date')->nullable();
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

            // charges per emi type (radio: ON EMI / ON PRINCIPAL)
            $table->string('charges_per_emi_type')->nullable();

            // disbursement mode 1
            $table->string('disburse_mode1')->nullable();
            $table->string('payment_mode1')->nullable();
            $table->unsignedBigInteger('bank_id1')->nullable();
            $table->string('cheque_no1')->nullable();
            $table->date('cheque_date1')->nullable();
            $table->date('transfer_date1')->nullable();
            $table->string('utr_no1')->nullable();
            $table->string('transfer_mode1')->nullable();
            $table->string('saving_acc1')->nullable();

            // disbursement mode 2
            $table->string('disburse_mode2')->nullable();
            $table->string('payment_mode2')->nullable();
            $table->unsignedBigInteger('bank_id2')->nullable();
            $table->string('cheque_no2')->nullable();
            $table->date('cheque_date2')->nullable();
            $table->date('transfer_date2')->nullable();
            $table->string('utr_no2')->nullable();
            $table->string('transfer_mode2')->nullable();
            $table->string('saving_acc2')->nullable();

            // record status
            $table->string('status')->default('0');

            $table->timestamps();

            // foreign key relation (optional)
            // $table->foreign('loan_application_id')->references('id')->on('loan_applications')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_loan_disbursements');
    }
};
