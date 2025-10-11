<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('loanagainst_disbursements', function (Blueprint $table) {
            $table->id();

            // Relation with loan application
            $table->unsignedBigInteger('loan_application_id')->index();

            // Basic dates
            $table->date('disbursal_date')->nullable();
            $table->date('emi_date')->nullable();

            // Loan & Charges
            $table->decimal('loan_amount', 15, 2)->default(0);
            $table->decimal('final_amount', 15, 2)->default(0);
            $table->string('disburse_mode1');
            $table->string('payment_mode1');
            $table->string('disburse_mode2');
            $table->string('payment_mode2');

            // Processing Fee
            $table->decimal('processing_fee', 15, 2)->default(0);
            $table->decimal('gst_percent', 5, 2)->default(18.00);
            $table->decimal('sgst', 15, 2)->default(0);
            $table->decimal('cgst', 15, 2)->default(0);
            $table->decimal('igst', 15, 2)->default(0);
            $table->decimal('processing_fee_total', 15, 2)->default(0);
            $table->boolean('collect_processing_fee')->default(false);

            // Stamp Duty
            $table->decimal('stamp_duty_fee', 15, 2)->default(0);
            $table->decimal('stamp_duty_total', 15, 2)->default(0);
            $table->boolean('collect_stamp_duty_fee')->default(false);

            // Insurance
            $table->decimal('insurance_fee', 15, 2)->default(0);
            $table->decimal('insurance_total', 15, 2)->default(0);
            $table->boolean('collect_insurance_fee')->default(false);

            // Advance Interest
            $table->decimal('advance_interest', 15, 2)->default(0);
            $table->boolean('collect_advance_interest')->default(false);

            // Final Amount
            $table->decimal('final_amount_to_disburse', 15, 2)->default(0);

            // Disbursement Mode 1
            $table->decimal('disburse_mode1_amount', 15, 2)->default(0);
            $table->enum('disburse_mode1_type', ['cash', 'cheque', 'online', 'saving'])->nullable();

            $table->unsignedBigInteger('bank_id1')->nullable();
            $table->string('cheque_no1')->nullable();
            $table->date('cheque_date1')->nullable();

            $table->date('transfer_date1')->nullable();
            $table->string('utr_no1')->nullable();
            $table->enum('transfer_mode1', ['imps', 'vpa', 'neft_rtgs'])->nullable();

            $table->string('saving_acc1')->nullable();

            // Disbursement Mode 2
            $table->decimal('disburse_mode2_amount', 15, 2)->default(0);
            $table->enum('disburse_mode2_type', ['cash', 'cheque', 'online', 'saving'])->nullable();

            $table->unsignedBigInteger('bank_id2')->nullable();
            $table->string('cheque_no2')->nullable();
            $table->date('cheque_date2')->nullable();

            $table->date('transfer_date2')->nullable();
            $table->string('utr_no2')->nullable();
            $table->enum('transfer_mode2', ['imps', 'vpa', 'neft_rtgs'])->nullable();

            $table->string('saving_acc2')->nullable();

            // Meta
            $table->timestamps();
            $table->softDeletes();

            // Foreign Key
            $table->foreign('loan_application_id')
                ->references('id')
                ->on('loan_applications')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loanagainst_disbursements');
    }
};
