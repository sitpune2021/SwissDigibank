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
           $table->string('overdue_type')->nullable()->after('overdue_interest_rate');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_loan_schemes', function (Blueprint $table) {
            $table->dropColumn('overdue_type');
        });
    }
};
