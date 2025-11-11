<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('commission_charts', function (Blueprint $table) {
        $table->id();

        $table->string('chart_type');         // rd, dd, fd_one, fd_payout, mis_one, mis_payout, saving
        $table->string('chart_name')->nullable();
        $table->string('payout_type')->nullable();       // RD / DD
        $table->string('commission_type')->nullable();   // INR / Percent
        $table->integer('tenure_months');     // Tenure months (1–99)

        $table->json('rank_month_values')->nullable(); 
        // Example:
        // {
        //   "1": { "1": 2, "2": 5, "3": 8 },
        //   "2": { "1": 3, "2": 6 }
        // }

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commission_charts');
    }
};
