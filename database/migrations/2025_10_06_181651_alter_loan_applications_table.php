<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_value DECIMAL(10,2) NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_gst DECIMAL(10,2) NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_sgst DECIMAL(10,2) NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_cgst DECIMAL(10,2) NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_igst DECIMAL(10,2) NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_total DECIMAL(10,2) NULL");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            // Revert columns back to NOT NULL
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_value DECIMAL(10,2) NOT NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_gst DECIMAL(10,2) NOT NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_sgst DECIMAL(10,2) NOT NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_cgst DECIMAL(10,2) NOT NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_igst DECIMAL(10,2) NOT NULL");
            DB::statement("ALTER TABLE loan_applications MODIFY processing_fee_total DECIMAL(10,2) NOT NULL");
        });
    }
};
