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
        Schema::create('vehical_applications', function (Blueprint $table) {
            $table->id();

            // Basic Details
            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('co_applicant_1_id')->nullable();
            $table->unsignedBigInteger('co_applicant_2_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('advisor_id')->nullable();
            $table->unsignedBigInteger('guarantor_1_id')->nullable();
            $table->unsignedBigInteger('guarantor_2_id')->nullable();
            $table->unsignedBigInteger('guarantor_3_id')->nullable();
            $table->unsignedBigInteger('guarantor_4_id')->nullable();
            $table->unsignedBigInteger('scheme_id')->nullable();

            // Loan Details
            $table->string('tenure_type')->nullable();
            $table->integer('tenure_value')->nullable();
            $table->string('emi_collection')->nullable();
            $table->integer('credit_period')->nullable();

            $table->decimal('loan_amount', 15, 2)->default(0);
            $table->decimal('insurance_amount', 15, 2)->default(0);
            $table->decimal('net_loan_amount', 15, 2)->default(0);
            $table->string('purpose_of_loan')->nullable();

            // Processing Fee Details
            $table->decimal('processing_fee_value', 10, 2)->default(0);
            $table->decimal('processing_fee_gst', 10, 2)->default(0);
            $table->decimal('processing_fee_sgst', 10, 2)->default(0);
            $table->decimal('processing_fee_cgst', 10, 2)->default(0);
            $table->decimal('processing_fee_igst', 10, 2)->default(0);
            $table->decimal('processing_fee_total', 10, 2)->default(0);
            $table->string('fee_mode')->nullable();

            // Payment Details
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable();
            $table->boolean('credited')->default(false);

            // Collection Details
            $table->boolean('collect_principal_as_emi')->default(false);
            $table->boolean('collect_advance_processing_fee')->default(false);

            // Security & Loan Limits
            $table->decimal('security_value', 15, 2)->default(0);
            $table->decimal('max_loan_amount', 15, 2)->default(0);
            $table->decimal('max_loan_limit', 15, 2)->default(0);
            $table->decimal('maximum_approvable_amount', 15, 2)->default(0);
            $table->decimal('approved_loan_amount', 15, 2)->default(0);

            // Status
            $table->string('status')->default('pending');

            // Audit Fields
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehical_applications');
    }
};
