<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fixed_loan_applications', function (Blueprint $table) {
            $table->decimal('total_recovered_amount', 15, 2)->default(0)->change();
            $table->decimal('net_emi_with_charges', 15, 2)->default(0)->change();
            $table->decimal('charge_per_emi', 15, 2)->default(0)->change();
        });
    }

    public function down(): void
    {
        Schema::table('fixed_loan_applications', function (Blueprint $table) {
            $table->boolean('total_recovered_amount')->default(0)->change();
            $table->boolean('net_emi_with_charges')->default(0)->change();
            $table->boolean('charge_per_emi')->default(0)->change();
        });
    }
};
