<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('bussiness_loan_applications', function (Blueprint $table) {
            $table->decimal('processing_fee_value', 15, 2)->nullable()->change();
            $table->decimal('processing_fee_gst', 15, 2)->nullable()->change();
            $table->decimal('processing_fee_sgst', 15, 2)->nullable()->change();
            $table->decimal('processing_fee_cgst', 15, 2)->nullable()->change();
            $table->decimal('processing_fee_igst', 15, 2)->nullable()->change();
            $table->decimal('processing_fee_total', 15, 2)->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('bussiness_loan_applications', function (Blueprint $table) {
            $table->decimal('processing_fee_value', 5, 2)->default(0)->change();
            $table->decimal('processing_fee_gst', 5, 2)->default(0)->change();
            $table->decimal('processing_fee_sgst', 5, 2)->default(0)->change();
            $table->decimal('processing_fee_cgst', 5, 2)->default(0)->change();
            $table->decimal('processing_fee_igst', 5, 2)->default(0)->change();
            $table->decimal('processing_fee_total', 5, 2)->nullable()->change();
        });
    }
};
