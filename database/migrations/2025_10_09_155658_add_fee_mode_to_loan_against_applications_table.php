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
        $table->string('fee_mode', 50)->nullable()->after('processing_fee_total');
        $table->unsignedBigInteger('bank_id')->nullable()->after('fee_mode');
        $table->string('cheque_no', 100)->nullable()->after('bank_id');
        $table->date('cheque_date')->nullable()->after('cheque_no');
        $table->date('transfer_date')->nullable()->after('cheque_date');
        $table->string('utr_no', 100)->nullable()->after('transfer_date');
    });
}

public function down(): void
{
    Schema::table('loan_against_applications', function (Blueprint $table) {
        $table->dropColumn(['fee_mode', 'bank_id', 'cheque_no', 'cheque_date', 'transfer_date', 'utr_no']);
    });
}

};
