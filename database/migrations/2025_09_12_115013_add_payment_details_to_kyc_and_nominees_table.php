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
        Schema::table('kyc_and_nominees', function (Blueprint $table) {
            $table->date('transfer_date')->nullable(); // Or use `default('2025-09-12')` for a default value
            $table->string('online_utr_no')->nullable();
            $table->enum('transfer_mode', ['IMPS', 'VPA', 'NEFT/RTGS'])->nullable();

            // Cheque Payment fields
            $table->string('cheque_bank_name')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kyc_and_nominees', function (Blueprint $table) {
            //
        });
    }
};
