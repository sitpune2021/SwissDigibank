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
      $table->decimal('imps_upto_1000', 10, 2)->nullable()->after('single_transaction_limit');
    $table->decimal('imps_upto_2500', 10, 2)->nullable()->after('imps_upto_1000');
    $table->decimal('imps_upto_5000', 10, 2)->nullable()->after('imps_upto_2500');
    $table->decimal('imps_upto_7500', 10, 2)->nullable()->after('imps_upto_5000');
    $table->decimal('imps_upto_10000', 10, 2)->nullable()->after('imps_upto_7500');
    $table->decimal('imps_upto_17500', 10, 2)->nullable()->after('imps_upto_10000');
    $table->decimal('imps_upto_25000', 10, 2)->nullable()->after('imps_upto_17500');
    $table->decimal('imps_upto_37500', 10, 2)->nullable()->after('imps_upto_25000');
    $table->decimal('imps_upto_50000', 10, 2)->nullable()->after('imps_upto_37500');
    $table->decimal('imps_upto_75000', 10, 2)->nullable()->after('imps_upto_50000');
    $table->decimal('imps_upto_100000', 10, 2)->nullable()->after('imps_upto_75000');
    $table->decimal('imps_upto_150000', 10, 2)->nullable()->after('imps_upto_100000');
    $table->decimal('imps_upto_200000', 10, 2)->nullable()->after('imps_upto_150000');
    $table->decimal('imps_upto_300000', 10, 2)->nullable()->after('imps_upto_200000');
    $table->decimal('imps_upto_400000', 10, 2)->nullable()->after('imps_upto_300000');
    $table->decimal('imps_upto_500000', 10, 2)->nullable()->after('imps_upto_400000');
    $table->decimal('imps_upto_1000000', 10, 2)->nullable()->after('imps_upto_500000');

    // NEFT Charges
    $table->decimal('neft_upto_1000', 10, 2)->nullable()->after('imps_upto_1000000');
    $table->decimal('neft_upto_2500', 10, 2)->nullable()->after('neft_upto_1000');
    $table->decimal('neft_upto_5000', 10, 2)->nullable()->after('neft_upto_2500');
    $table->decimal('neft_upto_7500', 10, 2)->nullable()->after('neft_upto_5000');
    $table->decimal('neft_upto_10000', 10, 2)->nullable()->after('neft_upto_7500');
    $table->decimal('neft_upto_17500', 10, 2)->nullable()->after('neft_upto_10000');
    $table->decimal('neft_upto_25000', 10, 2)->nullable()->after('neft_upto_17500');
    $table->decimal('neft_upto_37500', 10, 2)->nullable()->after('neft_upto_25000');
    $table->decimal('neft_upto_50000', 10, 2)->nullable()->after('neft_upto_37500');
    $table->decimal('neft_upto_75000', 10, 2)->nullable()->after('neft_upto_50000');
    $table->decimal('neft_upto_100000', 10, 2)->nullable()->after('neft_upto_75000');
    $table->decimal('neft_upto_150000', 10, 2)->nullable()->after('neft_upto_100000');
    $table->decimal('neft_upto_200000', 10, 2)->nullable()->after('neft_upto_150000');
    $table->decimal('neft_upto_300000', 10, 2)->nullable()->after('neft_upto_200000');
    $table->decimal('neft_upto_400000', 10, 2)->nullable()->after('neft_upto_300000');
    $table->decimal('neft_upto_500000', 10, 2)->nullable()->after('neft_upto_400000');
    $table->decimal('neft_upto_1000000', 10, 2)->nullable()->after('neft_upto_500000');

    // UPI Charges
    $table->decimal('upi_upto_1000', 10, 2)->nullable()->after('neft_upto_1000000');
    $table->decimal('upi_upto_2500', 10, 2)->nullable()->after('upi_upto_1000');
    $table->decimal('upi_upto_5000', 10, 2)->nullable()->after('upi_upto_2500');
    $table->decimal('upi_upto_7500', 10, 2)->nullable()->after('upi_upto_5000');
    $table->decimal('upi_upto_10000', 10, 2)->nullable()->after('upi_upto_7500');
    $table->decimal('upi_upto_17500', 10, 2)->nullable()->after('upi_upto_10000');
    $table->decimal('upi_upto_25000', 10, 2)->nullable()->after('upi_upto_17500');
    $table->decimal('upi_upto_37500', 10, 2)->nullable()->after('upi_upto_25000');
    $table->decimal('upi_upto_50000', 10, 2)->nullable()->after('upi_upto_37500');
    $table->decimal('upi_upto_75000', 10, 2)->nullable()->after('upi_upto_50000');
    $table->decimal('upi_upto_100000', 10, 2)->nullable()->after('upi_upto_75000');
    $table->decimal('upi_upto_150000', 10, 2)->nullable()->after('upi_upto_100000');
    $table->decimal('upi_upto_200000', 10, 2)->nullable()->after('upi_upto_150000');
    $table->decimal('upi_upto_300000', 10, 2)->nullable()->after('upi_upto_200000');
    $table->decimal('upi_upto_400000', 10, 2)->nullable()->after('upi_upto_300000');
    $table->decimal('upi_upto_500000', 10, 2)->nullable()->after('upi_upto_400000');
    $table->decimal('upi_upto_1000000', 10, 2)->nullable()->after('upi_upto_500000');
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
