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
        Schema::create('loan_against_schemes', function (Blueprint $table) {
            $table->id();
              $table->string('scheme_name', 191);
            // make scheme_code shorter to avoid "key too long" issue on older MySQL
            $table->string('scheme_code', 100)->unique();

            // money fields
            $table->decimal('max_loan_amount', 14, 2)->default(0);
            $table->decimal('min_loan_amount', 14, 2)->default(0);
            // If "max_loan_limit" is textual (like "50% of value"), keep string, else decimal:
            $table->decimal('max_loan_limit', 14, 2)->nullable();

            // rates / tenure
            $table->decimal('overdue_interest_rate', 5, 2)->nullable(); // percent
            $table->integer('tenure')->comment('tenure in months')->default(0);
            $table->decimal('annual_interest_rate', 5, 2)->default(0.00);

            // charges & fees (use decimal where possible)
            $table->decimal('penalty_charge', 10, 2)->nullable();
            $table->decimal('processing_fee', 10, 2)->nullable();
            $table->decimal('stamp_duty_charge', 10, 2)->nullable();
            $table->decimal('insurance_fee', 10, 2)->nullable();
            $table->decimal('fore_closer_charge', 10, 2)->nullable();

            $table->integer('credit_period')->nullable(); // days maybe
            $table->string('gold_loan_setting', 50)->nullable();
            $table->string('charge_floting', 50)->nullable(); // keep as string if descriptive

            $table->decimal('sms_charge', 10, 2)->nullable();
            $table->decimal('fuel_charge', 10, 2)->nullable();
            $table->decimal('stationary_charge', 10, 2)->nullable();
            $table->decimal('maintenance_charge', 10, 2)->nullable();

            $table->string('collection', 100)->nullable();

            // date fields
            $table->string('from_date')->nullable();
            $table->string('to_date')->nullable();

            // penal/annual rates (normalized names)
            $table->decimal('penal_rate_interest', 5, 2)->nullable();
            $table->decimal('annual_rate_interest', 5, 2)->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_against_schemes');
    }
};
