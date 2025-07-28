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
        Schema::create('schemes', function (Blueprint $table) {
            $table->id();
            $table->string('scheme_name')->comment('Scheme Name ');
            $table->string('scheme_code')->comment('Scheme Code');
            $table->decimal('min_opening_balance', 12, 2)->comment('Min. Opening Balance');
            $table->decimal('min_monthly_avg_balance', 12, 2)->comment('Min. Monthly Avg. Balance');
            $table->decimal('annual_int_rate', 5, 2)->comment('Annual Interest Rate (%)');
            $table->decimal('sr_citizen_add_on_int_rate', 5, 2)->default(0.00)->comment('Sr. Citizen Add-on Interest Rate (%)');
            $table->enum('interest_pay_cycle', ['Monthly', 'Quarterly', 'Half-Yearly', 'Annually'])->comment('Interest Payout');
            $table->decimal('lock_in_amount', 12, 2)->comment('Lock In Amount');
            $table->decimal('min_monthly_avg_bal_charge', 12, 2)->comment('Min. Monthly Avg. Balance Charge');
            $table->string('service_charge_freq')->nullable()->comment('Charge Frequency');
            $table->decimal('service_charges', 10, 2)->nullable()->comment('Service Charges');
            $table->string('sms_charge_freq')->nullable()->comment('Charge Frequency');
            $table->decimal('sms_charges', 10, 2)->nullable()->comment('SMS Charges');
            $table->string('free_ifsc_collect_per_month')->nullable()->comment('Free IFSC Collection per Month');
            $table->string('free_imps_neft_transactions')->nullable()->comment('Free Transfers per Month');
            $table->decimal('single_transaction_limit', 15, 2)->nullable()->comment('Single Transaction Limit');
            $table->decimal('imps_neft_daily_limit', 15, 2)->nullable()->comment('Daily transaction limit for IMPS/NEFT');
            $table->decimal('imps_neft_weekly_limit', 15, 2)->nullable()->comment('Weekly transaction limit for IMPS/NEFT');
            $table->decimal('imps_neft_monthly_limit', 15, 2)->nullable()->comment('Monthly transaction limit for IMPS/NEFT');
            $table->boolean('active')->default(true)->comment('Status of the scheme: 1 = Active, 0 = Inactive');
             $table->integer('app_type')->nullable();
             $table->integer('app_type_associate')->nullable();
              $table->integer('app_type_member')->nullable();
              $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schemes');
    }
};
