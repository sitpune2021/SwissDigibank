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
        Schema::create('cc_od_loan_applications', function (Blueprint $table) {
            $table->id();
            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('co_applicant_1_id')->nullable();
            $table->unsignedBigInteger('co_applicant_2_id')->nullable();
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('advisor_id')->nullable();
            $table->string('securety_type')->nullable();
            $table->decimal('security_amount', 15, 2)->nullable();
            $table->unsignedBigInteger('guarantor_1_id')->nullable();
            $table->unsignedBigInteger('guarantor_2_id')->nullable();
            $table->unsignedBigInteger('guarantor_3_id')->nullable();
            $table->unsignedBigInteger('guarantor_4_id')->nullable();
            $table->unsignedBigInteger('scheme_id')->nullable();
            $table->string('tenure_type')->nullable();
            $table->integer('tenure_value')->nullable();
            $table->string('emi_collection')->nullable();
            $table->integer('credit_period')->nullable();
            $table->decimal('loan_amount', 15, 2)->nullable();
            $table->decimal('insurance_amount', 15, 2)->nullable();
            $table->decimal('net_loan_amount', 15, 2)->nullable();
            $table->text('purpose_of_loan')->nullable();
            $table->decimal('charge_per_emi', 15, 2)->nullable();

            // Processing fee details
            $table->decimal('processing_fee_value', 15, 2)->nullable();
            $table->decimal('processing_fee_gst', 15, 2)->nullable();
            $table->decimal('processing_fee_sgst', 15, 2)->nullable();
            $table->decimal('processing_fee_cgst', 15, 2)->nullable();
            $table->decimal('processing_fee_igst', 15, 2)->nullable();
            $table->decimal('processing_fee_total', 15, 2)->nullable();

            // Fee mode & payment details
            $table->string('fee_mode')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable();

            // Other flags
            $table->boolean('credited')->default(false);
            $table->boolean('collect_principal_as_emi')->default(false);
            $table->boolean('collect_advance_processing_fee')->default(false);

            // Loan limits
            $table->decimal('security_value', 15, 2)->nullable();
            $table->decimal('max_loan_amount', 15, 2)->nullable();
            $table->decimal('max_loan_limit', 15, 2)->nullable();
            $table->decimal('maximum_approvable_amount', 15, 2)->nullable();
            $table->decimal('approved_loan_amount', 15, 2)->nullable();

            $table->string('status')->default(0);

            $table->timestamps();

            // (Optional) Foreign Keys – Uncomment if related tables exist
            // $table->foreign('member_id')->references('id')->on('members')->onDelete('set null');
            // $table->foreign('scheme_id')->references('id')->on('cc_od_loan_schemes')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cc_od_loan_applications');
    }
};
