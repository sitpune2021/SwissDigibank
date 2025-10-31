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
        Schema::create('personal_schemes', function (Blueprint $table) {
            $table->id();
            $table->string('scheme_name');
            $table->string('scheme_code')->unique();
            $table->decimal('min_loan_amount', 15, 2)->nullable();
            $table->decimal('max_loan_amount', 15, 2)->nullable();
            $table->integer('tenure')->nullable(); // in months, for example
            $table->decimal('annual_interest_rate', 5, 2)->nullable();
            $table->decimal('processing_fee', 10, 2)->nullable();
            $table->decimal('stamp_duty_charge', 10, 2)->nullable();
            $table->decimal('insurance_fee', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('gold_loan_setting')->nullable();
            $table->decimal('max_loan_limit', 15, 2)->nullable();
            $table->decimal('overdue_interest_rate', 5, 2)->nullable();
            $table->decimal('penalty_charge', 10, 2)->nullable();
            $table->decimal('fore_closer_charge', 10, 2)->nullable();
            $table->integer('credit_period')->nullable();
            $table->decimal('sms_charge', 10, 2)->nullable();
            $table->decimal('fuel_charge', 10, 2)->nullable();
            $table->decimal('stationary_charge', 10, 2)->nullable();
            $table->decimal('maintenance_charge', 10, 2)->nullable();
            $table->decimal('collection', 10, 2)->nullable();
            $table->enum('charges_per_emi_type', ['ON EMI', 'ON PRINCIPAL'])->default('ON EMI');
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();
            $table->decimal('penal_rate_interest', 5, 2)->nullable();
            $table->decimal('annual_rate_interest', 5, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_schemes');
    }
};
