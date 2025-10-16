<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bussiness_loan_applications', function (Blueprint $table) {
            $table->id();

            // Status column added after id
            $table->string('status')->default('0');

            // Basic info
            $table->date('application_date');
            $table->unsignedBigInteger('member_id'); // FK -> members table

            // Co-applicants
            $table->unsignedBigInteger('co_applicant_1_id')->nullable();
            $table->unsignedBigInteger('co_applicant_2_id')->nullable();

            // Branch & Staff
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('advisor_id')->nullable();

            // Guarantors
            $table->unsignedBigInteger('guarantor_1_id')->nullable();
            $table->unsignedBigInteger('guarantor_2_id')->nullable();
            $table->unsignedBigInteger('guarantor_3_id')->nullable();
            $table->unsignedBigInteger('guarantor_4_id')->nullable();

            // Scheme
            $table->unsignedBigInteger('scheme_id');

            // Tenure
            $table->enum('tenure_type', ['days', 'weeks', 'months'])->default('months');
            $table->integer('tenure_value'); // e.g. 12, 24

            // Collection & Loan Details
            $table->string('emi_collection')->nullable(); // daily, monthly, etc.
            $table->integer('credit_period')->default(0); // grace period (days)
            $table->decimal('loan_amount', 15, 2);
            $table->decimal('insurance_amount', 15, 2)->nullable();
            $table->decimal('net_loan_amount', 15, 2);
            $table->string('purpose_of_loan');
            $table->string('securety_type')->nullable();
            $table->string('security_amount')->nullable();

            // Processing Fee
            $table->decimal('processing_fee_value', 15, 2)->default(0);
            $table->decimal('processing_fee_gst', 5, 2)->default(18.0);
            $table->decimal('processing_fee_sgst', 15, 2)->default(0);
            $table->decimal('processing_fee_cgst', 15, 2)->default(0);
            $table->decimal('processing_fee_igst', 15, 2)->default(0);
            $table->decimal('processing_fee_total', 15, 2)->nullable();
            $table->string('fee_mode')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable();
            $table->boolean('credited')->default(0);

            // Flags
            $table->boolean('collect_principal_as_emi')->default(false);
            $table->boolean('collect_advance_processing_fee')->default(false);

            // Calculation 
            $table->decimal('security_value', 15, 2)->nullable();
            $table->decimal('max_loan_amount', 15, 2)->nullable();
            $table->decimal('max_loan_limit', 15, 2)->nullable();
            $table->decimal('maximum_approvable_amount', 15, 2)->nullable();
            $table->decimal('approved_loan_amount', 15, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('bussiness_loan_applications');
    }
};
