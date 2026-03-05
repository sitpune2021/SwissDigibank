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
        Schema::table('business_loan_emi_status', function (Blueprint $table) {
            $table->date('emi_due_date')->nullable()->after('paid_date');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('business_loan_emi_status', function (Blueprint $table) {
            $table->dropColumn('emi_due_date');
        });
    }
};
