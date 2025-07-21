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
        Schema::create('schemes', function (Blueprint $table) {
            $table->id();
                   $table->string('scheme_name');
            $table->string('scheme_code')->unique();
            $table->decimal('min_opening_balance', 12, 2);
            $table->decimal('min_monthly_avg_balance', 12, 2);
            $table->decimal('annual_interest_rate', 5, 2);
            $table->decimal('sr_citizen_add_on_interest_rate', 5, 2)->default(0.0);
            $table->enum('interest_payout_cycle', ['Monthly', 'Quarterly', 'Half-Yearly', 'Annually']);
            $table->decimal('lock_in_amount', 12, 2);
            $table->decimal('min_monthly_avg_balance_charge', 12, 2);
        
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schemes');
        
    }
};
