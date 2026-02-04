<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('fixed_loan_scheme', function (Blueprint $table) {
            $table->id();

            $table->string('scheme_name');
            $table->string('scheme_code')->unique();

            $table->decimal('max_loan_amount', 15, 2)->default(0);
            $table->decimal('emi_amount', 15, 2)->default(0);

            $table->decimal('annual_interest_rate', 5, 2)->default(0);

            $table->string('overdue_type');
            $table->decimal('overdue_rate', 10, 2)->nullable();
            $table->decimal('penalty_charge', 10, 2)->nullable();
            $table->decimal('processing_fee', 10, 2)->nullable();
            $table->decimal('stamp_duty_charge', 10, 2)->nullable();
            $table->decimal('insurance_fee', 10, 2)->nullable();
            $table->decimal('fore_closer_charge', 10, 2)->nullable();

            $table->enum('gold_loan_setting', [
                'daily', 'weekly', 'bi_weekly', '4_weekly', 'Monthaly'
            ])->nullable();

            $table->integer('no_of_emi')->default(0);
            $table->integer('credit_period')->default(0);

            $table->boolean('is_active')->default(0);

            // Charges Per EMI Fields
            $table->decimal('sms_charge', 10, 2)->nullable();
            $table->decimal('fuel_charge', 10, 2)->nullable();
            $table->decimal('fitness_fee', 10, 2)->nullable();
            $table->decimal('stationary_charge', 10, 2)->nullable();
            $table->decimal('maintenance_charge', 10, 2)->nullable();
            $table->decimal('collection', 10, 2)->nullable();

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('fixed_loan_scheme');
    }
};
