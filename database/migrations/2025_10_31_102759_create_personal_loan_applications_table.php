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
        Schema::create('personal_loan_applications', function (Blueprint $table) {
            $table->id();
            $table->date('application_date')->nullable();

            // Foreign keys
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

            // Loan details
            $table->string('tenure_type')->nullable();
            $table->integer('tenure_value')->nullable();
            $table->string('emi_collection')->nullable();
            $table->integer('credit_period')->nullable();
            $table->decimal('loan_amount', 15, 2)->nullable();
            $table->decimal('insurance_amount', 15, 2)->nullable();
            $table->decimal('net_loan_amount', 15, 2)->nullable();
            $table->string('purpose_of_loan')->nullable();

            // Processing fee details
            $table->decimal('processing_fee_value', 10, 2)->nullable();
            $table->decimal('processing_fee_gst', 10, 2)->nullable();
            $table->decimal('processing_fee_sgst', 10, 2)->nullable();
            $table->decimal('processing_fee_cgst', 10, 2)->nullable();
            $table->decimal('processing_fee_igst', 10, 2)->nullable();
            $table->decimal('processing_fee_total', 10, 2)->nullable();

            $table->string('fee_mode')->nullable();

            // Bank / Payment info
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable();
            $table->boolean('credited')->default(false);

            // Security and limits
            $table->decimal('security_value', 15, 2)->nullable();
            $table->decimal('max_loan_amount', 15, 2)->nullable();
            $table->decimal('max_loan_limit', 15, 2)->nullable();
            $table->decimal('maximum_approvable_amount', 15, 2)->nullable();
            $table->decimal('approved_loan_amount', 15, 2)->nullable();

            // Options
            $table->boolean('collect_principal_as_emi')->default(false);
            $table->boolean('collect_advance_processing_fee')->default(false);

            // Status (0=pending, 1=approved, 2=disbursed, 3=cancelled)
            $table->tinyInteger('status')->default(0);

            $table->timestamps();

            // Foreign key constraints (optional, if tables exist)
            $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('co_applicant_1_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('co_applicant_2_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('guarantor_1_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('guarantor_2_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('guarantor_3_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('guarantor_4_id')->references('id')->on('members')->onDelete('set null');
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('set null');
            $table->foreign('scheme_id')->references('id')->on('personal_schemes')->onDelete('set null');
            $table->foreign('bank_id')->references('id')->on('banks')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_loan_applications');
    }
};
