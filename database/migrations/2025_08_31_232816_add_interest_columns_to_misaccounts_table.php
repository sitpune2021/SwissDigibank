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
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->decimal('monthly_interest', 15, 2)->nullable()->after('maturity_date');
            $table->decimal('total_interest', 15, 2)->nullable()->after('monthly_interest');
            $table->decimal('maturity_amount', 15, 2)->nullable()->after('total_interest');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->dropColumn(['monthly_interest', 'total_interest', 'maturity_amount']);
        });
    }
};
