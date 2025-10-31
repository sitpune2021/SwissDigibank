<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_weekly_applications', function (Blueprint $table) {
            $table->decimal('charges_per_emi', 12, 2)->nullable()->after('emi_amount');
            $table->decimal('net_emi_with_charges', 12, 2)->nullable()->after('charges_per_emi');
            $table->decimal('total_recovered_amount', 14, 2)->nullable()->after('net_emi_with_charges');
        });
    }

    public function down(): void
    {
        Schema::table('daily_weekly_applications', function (Blueprint $table) {
            $table->dropColumn(['charges_per_emi', 'net_emi_with_charges', 'total_recovered_amount']);
        });
    }
};
