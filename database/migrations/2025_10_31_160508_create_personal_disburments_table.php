<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personal_disburments', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('loan_application_id');
            $table->date('disbursal_date')->nullable();
            $table->date('emi_date')->nullable();

            $table->decimal('loan_amount', 15, 2)->default(0);
            $table->decimal('processing_fee', 15, 2)->default(0);
            $table->decimal('gst_percent', 5, 2)->default(0);
            $table->decimal('sgst', 15, 2)->default(0);
            $table->decimal('cgst', 15, 2)->default(0);
            $table->decimal('igst', 15, 2)->default(0);
            $table->decimal('processing_fee_total', 15, 2)->default(0);
            $table->decimal('stamp_duty_fee', 15, 2)->default(0);
            $table->decimal('insurance_fee', 15, 2)->default(0);
            $table->decimal('advance_interest', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);

            // Payment 1
            $table->string('disburse_mode1')->nullable();
            $table->string('payment_mode1')->nullable();
            $table->unsignedBigInteger('bank_id1')->nullable();
            $table->string('cheque_no1')->nullable();
            $table->date('cheque_date1')->nullable();
            $table->date('transfer_date1')->nullable();
            $table->string('utr_no1')->nullable();
            $table->string('transfer_mode1')->nullable();
            $table->string('saving_acc1')->nullable();

            // Payment 2
            $table->string('disburse_mode2')->nullable();
            $table->string('payment_mode2')->nullable();
            $table->unsignedBigInteger('bank_id2')->nullable();
            $table->string('cheque_no2')->nullable();
            $table->date('cheque_date2')->nullable();
            $table->date('transfer_date2')->nullable();
            $table->string('utr_no2')->nullable();
            $table->string('transfer_mode2')->nullable();
            $table->string('saving_acc2')->nullable();

            $table->string('status')->default('pending');

            $table->timestamps();

            // Foreign key
            $table->foreign('loan_application_id')
                ->references('id')
                ->on('personal_loan_applications')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personal_disburments');
    }
};
