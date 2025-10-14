<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::dropIfExists('mortgage_loan_applications'); // <- Add this line

        Schema::create('mortgage_loan_applications', function (Blueprint $table) {
            $table->id();

            // Basic info
            $table->date('application_date');
            $table->unsignedBigInteger('member_id');

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
            $table->integer('tenure_value');

            // Collection & Loan Details
            $table->string('emi_collection')->nullable();
            $table->integer('credit_period')->default(0);
            $table->decimal('loan_amount', 15, 2);
            $table->decimal('insurance_amount', 15, 2)->nullable();
            $table->decimal('net_loan_amount', 15, 2);
            $table->string('purpose_of_loan');

            // Processing Fee
            $table->decimal('processing_fee_value', 15, 2)->default(0);
            $table->decimal('processing_fee_gst', 5, 2)->default(18.0);
            $table->decimal('processing_fee_sgst', 15, 2)->default(0);
            $table->decimal('processing_fee_cgst', 15, 2)->default(0);
            $table->decimal('processing_fee_igst', 15, 2)->default(0);
            $table->decimal('processing_fee_total', 15, 2)->default(0);

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

    public function down(): void
    {
        Schema::dropIfExists('mortgage_loan_applications'); // <- Proper rollback
    }
};
