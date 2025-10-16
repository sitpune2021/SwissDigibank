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
        Schema::table('business_loan_schemes', function (Blueprint $table) {
            // Boolean type (0 = On Principal, 1 = On EMI)
            $table->boolean('charge_per_emi')
                ->default(1)
                ->comment('1 = On EMI, 0 = On Principal')
                ->after('collection');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_loan_schemes', function (Blueprint $table) {
            $table->dropColumn('charge_per_emi');
        });
    }
};
