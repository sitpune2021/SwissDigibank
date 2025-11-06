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
        Schema::create('vehical_schemes', function (Blueprint $table) {
            $table->id();

            // Basic Info
            $table->string('scheme_name');
            $table->string('scheme_code')->unique();

            // Loan Limits
            $table->decimal('min_loan_amount', 15, 2)->default(0);
            $table->decimal('max_loan_amount', 15, 2)->default(0);
            $table->decimal('max_loan_limit', 15, 2)->nullable();

            // Scheme Config
            $table->integer('tenure')->nullable();
            $table->decimal('annual_interest_rate', 5, 2)->default(0);
            $table->decimal('processing_fee', 10, 2)->default(0);
            $table->decimal('stamp_duty_charge', 10, 2)->default(0);
            $table->decimal('insurance_fee', 10, 2)->default(0);

            // Additional Charges
            $table->decimal('penalty_charge', 10, 2)->default(0);
            $table->decimal('fore_closer_charge', 10, 2)->default(0);
            $table->decimal('overdue_interest_rate', 5, 2)->default(0);
            $table->decimal('penal_rate_interest', 5, 2)->default(0);
            $table->decimal('annual_rate_interest', 5, 2)->default(0);

            // Other Fees
            $table->decimal('sms_charge', 10, 2)->default(0);
            $table->decimal('fuel_charge', 10, 2)->default(0);
            $table->decimal('stationary_charge', 10, 2)->default(0);
            $table->decimal('maintenance_charge', 10, 2)->default(0);
            $table->decimal('collection', 10, 2)->default(0);

            // Misc
            $table->integer('credit_period')->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('gold_loan_setting')->nullable();

            // Validity
            $table->date('from_date')->nullable();
            $table->date('to_date')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehical_schemes');
    }
};
