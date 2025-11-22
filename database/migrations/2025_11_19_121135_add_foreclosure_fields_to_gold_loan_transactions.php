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
        Schema::table('gold_loan_transactions', function (Blueprint $table) {
            $table->decimal('foreclosure_amount', 12, 2)->nullable();
            $table->date('foreclosure_date')->nullable();
            $table->decimal('penalty_amount', 12, 2)->default(0);
            $table->decimal('discount', 12, 2)->default(0);
            $table->string('closing_remarks')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('gold_loan_transactions', function (Blueprint $table) {
            $table->dropColumn([
                'foreclosure_amount',
                'foreclosure_date',
                'penalty_amount',
                'discount',
                'closing_remarks'
            ]);
        });
    }
};
