<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('fixe_loan_disburments', function (Blueprint $table) {
            $table->id();

            /* ===============================
             |  Core Loan Info
             ===============================*/
            $table->unsignedBigInteger('loan_application_id')->index();
            $table->date('disbursal_date');
            $table->date('emi_date');
            $table->decimal('loan_amount', 15, 2)->default(0);

            /* ===============================
             |  Processing Fee (GST)
             ===============================*/
            $table->decimal('processing_fee', 15, 2)->default(0);
            $table->decimal('processing_fee_gst_percent', 5, 2)->default(0);
            $table->decimal('processing_fee_sgst', 15, 2)->default(0);
            $table->decimal('processing_fee_cgst', 15, 2)->default(0);
            $table->decimal('processing_fee_igst', 15, 2)->default(0);
            $table->decimal('processing_fee_total', 15, 2)->default(0);

            // $table->string('processingfee_payment_mode')->nullable();
             $table->enum('processingfee_payment_mode', ['cash', 'cheque', 'online', 'saving'])->nullable();
            $table->unsignedBigInteger('processing_fee_bank_id')->nullable();
            $table->string('processing_fee_cheque_no')->nullable();
            $table->date('processing_fee_cheque_date')->nullable();
            $table->date('processing_fee_transfer_date')->nullable();
            $table->string('processing_fee_utr_no')->nullable();
            $table->string('processing_fee_transfer_mode')->nullable();

            /* ===============================
             |  Stamp Duty Fee (GST)
             ===============================*/
            $table->decimal('stamp_duty_fee', 15, 2)->default(0);
            $table->decimal('stamp_gst_percent', 5, 2)->default(0);
            $table->decimal('stamp_duty_fee_sgst', 15, 2)->default(0);
            $table->decimal('stamp_duty_fee_cgst', 15, 2)->default(0);
            $table->decimal('stamp_duty_fee_igst', 15, 2)->default(0);
            $table->decimal('stamp_duty_total', 15, 2)->default(0);

            // $table->string('stamp_duty_fee_payment_mode')->nullable();
             $table->enum('stamp_duty_fee_payment_mode', ['cash', 'cheque', 'online', 'saving'])->nullable();
            $table->unsignedBigInteger('stamp_duty_fee_bank_id')->nullable();
            $table->string('stamp_duty_fee_cheque_no')->nullable();
            $table->date('stamp_duty_fee_cheque_date')->nullable();
            $table->date('stamp_duty_fee_transfer_date')->nullable();
            $table->string('stamp_duty_fee_utr_no')->nullable();
            $table->string('stamp_duty_fee_transfer_mode')->nullable();

            /* ===============================
             |  Insurance Fee (GST)
             ===============================*/
            $table->decimal('insurance_fee', 15, 2)->default(0);
            $table->decimal('insurance_gst_percent', 5, 2)->default(0);
            $table->decimal('insurance_fee_sgst', 15, 2)->default(0);
            $table->decimal('insurance_fee_cgst', 15, 2)->default(0);
            $table->decimal('insurance_fee_igst', 15, 2)->default(0);
            $table->decimal('insurance_total', 15, 2)->default(0);

            // $table->string('insurance_fee_payment_mode')->nullable();
             $table->enum('insurance_fee_payment_mode', ['cash', 'cheque', 'online', 'saving'])->nullable();
            $table->unsignedBigInteger('insurance_fee_bank_id')->nullable();
            $table->string('insurance_fee_cheque_no')->nullable();
            $table->date('insurance_fee_cheque_date')->nullable();
            $table->date('insurance_fee_transfer_date')->nullable();
            $table->string('insurance_fee_utr_no')->nullable();
            $table->string('insurance_fee_transfer_mode')->nullable();

            /* ===============================
             |  Fitness Fee (GST)
             ===============================*/
            $table->decimal('fitness_fee', 15, 2)->default(0);
            $table->decimal('fitness_fee_gst_percent', 5, 2)->default(0);
            $table->decimal('fitness_fee_sgst', 15, 2)->default(0);
            $table->decimal('fitness_fee_cgst', 15, 2)->default(0);
            $table->decimal('fitness_fee_igst', 15, 2)->default(0);
            $table->decimal('fitness_fee_total', 15, 2)->default(0);

            // $table->string('fitness_fee_payment_mode')->nullable();
            $table->enum('fitness_fee_payment_mode', ['cash', 'cheque', 'online', 'saving'])->nullable();
            $table->unsignedBigInteger('fitness_fee_bank_id')->nullable();
            $table->string('fitness_fee_cheque_no')->nullable();
            $table->date('fitness_fee_cheque_date')->nullable();
            $table->date('fitness_fee_transfer_date')->nullable();
            $table->string('fitness_fee_utr_no')->nullable();
            $table->string('fitness_fee_transfer_mode')->nullable();

            /* ===============================
             |  Final Amount
             ===============================*/
            $table->decimal('final_amount', 15, 2)->default(0);

            /* ===============================
             |  Disbursement Mode 1
             ===============================*/
            //   $table->decimal('disburse_mode1_amount', 15, 2)->default(0);
           
            $table->decimal('D_mode_1', 15, 2)->default(0);
             $table->enum('payment_mode', ['cash', 'cheque', 'online', 'saving'])->nullable();
            // $table->string('payment_mode')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable();
            $table->string('saving')->nullable();

            /* ===============================
             |  Disbursement Mode 2
             ===============================*/
            $table->decimal('D_mode_2', 15, 2)->default(0);
              $table->enum('payment_mode2', ['cash', 'cheque', 'online', 'saving'])->nullable();
            // $table->string('payment_mode2')->nullable();
            $table->unsignedBigInteger('bank_id2')->nullable();
            $table->string('cheque_no2')->nullable();
            $table->date('cheque_date2')->nullable();
            $table->date('transfer_date2')->nullable();
            $table->string('utr_no2')->nullable();
            $table->string('transfer_mode2')->nullable();
            $table->string('saving2')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('loan_application_id')
                ->references('id')
                ->on('fixed_loan_applications')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixed_loan_disbursements');
    }
};
