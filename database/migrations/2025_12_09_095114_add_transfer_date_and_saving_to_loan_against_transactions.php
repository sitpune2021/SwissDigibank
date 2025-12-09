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
        Schema::table('loan_against_transactions', function (Blueprint $table) {
            $table->string('transfer_date')->nullable()->after('transfer_mode');
            $table->string('saving')->nullable()->after('transfer_date');
         });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_against_transactions', function (Blueprint $table) {
            $table->dropColumn(['transfer_date', 'saving']);
        });
    }
};
