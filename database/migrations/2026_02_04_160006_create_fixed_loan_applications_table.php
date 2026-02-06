<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('fixed_loan_applications', function (Blueprint $table) {
            $table->id();

            $table->date('application_date')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('application_no');
            $table->unsignedBigInteger('co_applicant_1_id')->nullable();
            $table->string('relation_co_applicant_1')->nullable();
            $table->unsignedBigInteger('co_applicant_2_id')->nullable();
            $table->string('relation_co_applicant_2')->nullable();
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('advisor_id')->nullable();
            $table->unsignedBigInteger('guarantor_1_id')->nullable();
            $table->string('relation_guarantor_1')->nullable();
            $table->unsignedBigInteger('guarantor_2_id')->nullable();
            $table->string('relation_guarantor_2')->nullable();
            $table->unsignedBigInteger('guarantor_3_id')->nullable();
            $table->string('relation_guarantor_3')->nullable();
            $table->unsignedBigInteger('guarantor_4_id')->nullable();
            $table->string('relation_guarantor_4')->nullable();
            $table->unsignedBigInteger('scheme_id')->nullable();

            $table->integer('credit_period')->nullable();

            $table->decimal('net_loan_amount', 15, 2)->nullable();
            $table->string('purpose_of_loan')->nullable();
           
            $table->decimal('processing_fee', 10, 2)->nullable();
            $table->decimal('stamp_duty', 10, 2)->nullable();
            $table->decimal('fitness_fee', 10, 2)->nullable();
            $table->decimal('insurance_fee', 10, 2)->nullable();
            
            $table->boolean('credited')->default(0);
            
            $table->decimal('charge_per_emi', 10, 2)->nullable();
            $table->boolean('net_emi_with_charges')->default(0);
            $table->boolean('total_recovered_amount')->default(0);
            

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fixed_loan_applications');
    }
};
