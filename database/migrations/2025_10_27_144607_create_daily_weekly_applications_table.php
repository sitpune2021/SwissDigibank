<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_weekly_applications', function (Blueprint $table) {
            $table->id();

            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('co_applicant_1_id')->nullable();
            $table->unsignedBigInteger('co_applicant_2_id')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('advisor_id')->nullable();
            $table->unsignedBigInteger('guarantor_1_id')->nullable();
            $table->unsignedBigInteger('guarantor_2_id')->nullable();
            $table->unsignedBigInteger('guarantor_3_id')->nullable();
            $table->unsignedBigInteger('guarantor_4_id')->nullable();
            $table->unsignedBigInteger('scheme_id')->nullable();

            $table->integer('credit_period')->nullable();

            $table->decimal('net_loan_amount', 15, 2)->nullable();
            $table->string('purpose_of_loan')->nullable();

            $table->decimal('charge_per_emi', 10, 2)->nullable();

            $table->decimal('processing_fee_gst', 10, 2)->nullable();
            $table->decimal('processing_fee_sgst', 10, 2)->nullable();
            $table->decimal('processing_fee_cgst', 10, 2)->nullable();
            $table->decimal('processing_fee_igst', 10, 2)->nullable();
            $table->decimal('processing_fee_total', 10, 2)->nullable();

            $table->string('fee_mode')->nullable();

            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable();

            $table->boolean('credited')->default(0);

            $table->boolean('collect_principal_as_emi')->default(0);
            $table->boolean('collect_advance_processing_fee')->default(0);
            $table->decimal('max_loan_amount', 15, 2)->nullable();
            $table->decimal('maximum_approvable_amount', 15, 2)->nullable();
            $table->decimal('approved_loan_amount', 15, 2)->nullable();


            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_weekly_applications');
    }
};
