<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_weekly_schemes', function (Blueprint $table) {
            // Add after annual_interest_rate column
            $table->string('overdue_type')->nullable()->after('annual_interest_rate');
            $table->decimal('overdue_rate', 8, 2)->nullable()->after('overdue_type');
            $table->decimal('fitness_fee', 8, 2)->nullable()->after('overdue_rate');
            $table->decimal('credit_period', 8, 2)->nullable()->after('fitness_fee');
        });
    }

    public function down(): void
    {
        Schema::table('daily_weekly_schemes', function (Blueprint $table) {
            $table->dropColumn(['overdue_type', 'overdue_rate', 'fitness_fee', 'credit_period']);
        });
    }
};
