<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cc_od_loan_schemes', function (Blueprint $table) {
            $table->id();
            $table->string('scheme_name');
            $table->string('scheme_code')->unique();
            $table->decimal('min_loan_amount', 15, 2)->default(0);
            $table->decimal('max_loan_amount', 15, 2)->default(0);
            $table->integer('tenure')->nullable(); // months
            $table->decimal('annual_interest_rate', 8, 2)->nullable();
            $table->decimal('processing_fee', 10, 2)->nullable();
            $table->decimal('stamp_duty_charge', 10, 2)->nullable();
            $table->decimal('insurance_fee', 10, 2)->nullable();
            $table->boolean('is_active')->default(true);
            $table->string('gold_loan_setting')->nullable();
            $table->decimal('max_loan_limit', 15, 2)->nullable();
            $table->decimal('overdue_interest_rate', 8, 2)->nullable();
            $table->decimal('penalty_charge', 10, 2)->nullable();
            $table->decimal('fore_closer_charge', 10, 2)->nullable();
            $table->integer('credit_period')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cc_od_loan_schemes');
    }
};
