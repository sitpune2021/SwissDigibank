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
        Schema::table('loan_against_applications', function (Blueprint $table) {
            $table->string('fee_mode')->nullable()->after('processing_fee_total');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_against_applications', function (Blueprint $table) {
           $table->dropColumn('fee_mode');
        });
    }
};
