<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Change table name if your table is "bussiness_loan_schemes"
        Schema::table('bussiness_loan_applications', function (Blueprint $table) {
            // tinyInteger (0 or 1) with default 1 => ON EMI
            $table->tinyInteger('charge_per_emi')->default(1)->after('purpose_of_loan')->comment('0 = ON PRINCIPAL, 1 = ON EMI');
        });
    }

    public function down(): void
    {
        Schema::table('bussiness_loan_applications', function (Blueprint $table) {
            $table->dropColumn('charge_per_emi');
        });
    }
};
