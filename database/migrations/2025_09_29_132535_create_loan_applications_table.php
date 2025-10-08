<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('loan_applications', function (Blueprint $table) {
            $table->id();

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
            $table->string('fee_mode');

            // Calculation 
            $table->decimal('security_value', 15, 2)->nullable();
            $table->decimal('max_loan_amount', 15, 2)->nullable();
            $table->decimal('max_loan_limit', 15, 2)->nullable();
            $table->decimal('maximum_approvable_amount', 15, 2)->nullable();
            $table->decimal('approved_loan_amount', 15, 2)->nullable();
            
            $table->timestamps();
        });

        // Separate table for Credit Scores
        Schema::create('loan_credit_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_application_id');
            $table->string('cibil_type');
            
            $table->integer('cibil_score')->nullable();
            $table->date('report_date')->nullable();
            $table->string('report_file_path')->nullable(); // file upload path
            $table->timestamps();

            $table->foreign('loan_application_id')
                ->references('id')
                ->on('loan_applications')
                ->onDelete('cascade');
        });
    }

    // public function down(): void
    // {
    //     Schema::dropIfExists('loan_credit_scores');
    //     Schema::dropIfExists('loan_applications');
    // }
    public function down()
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->dropColumn([
                'security_value',
                'max_loan_amount',
                'max_loan_limit',
                'maximum_approvable_amount',
                'approved_loan_amount'
            ]);
        });
    }
    
};
