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
        Schema::table('schemes', function (Blueprint $table) {

                $table->string('charge_frequency')->nullable()->after('min_monthly_avg_balance_charge');
        $table->decimal('service_charges', 10, 2)->nullable()->after('charge_frequency');
        $table->decimal('sms_charges', 10, 2)->nullable()->after('service_charges');
        $table->string('free_ifsc_collection_per_month')->nullable()->after('sms_charges');
        $table->string('free_imps_neft_transactions')->nullable()->after('free_ifsc_collection_per_month');
        $table->string('free_transfers_per_month')->nullable()->after('free_imps_neft_transactions');
        $table->decimal('single_transaction_limit', 15, 2)->nullable()->after('free_transfers_per_month');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('schemes', function (Blueprint $table) {
            //
        });
    }
};
