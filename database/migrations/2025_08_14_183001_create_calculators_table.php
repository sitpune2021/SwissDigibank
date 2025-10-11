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
        Schema::create('calculators', function (Blueprint $table) {
            $table->id();
            $table->date('open_date');
            $table->decimal('amount', 15, 2);
            $table->string('interest_payout_type'); // e.g., Monthly, Quarterly, etc.
            $table->decimal('annual_interest_rate', 5, 2);
            $table->integer('tenure_year')->nullable();
            $table->integer('tenure_month')->nullable();
            $table->integer('tenure_day')->nullable();
            $table->decimal('bonus', 5, 2)->default(0.00);
            $table->boolean('tds_deduction')->default(false);
            $table->boolean('is_senior_citizen')->default(false);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('calculators');
    }
};
