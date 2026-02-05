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
        Schema::create('fixed_loan_emi_status', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('loan_id');
    $table->integer('emi_no');
    $table->string('status', 20);
    $table->decimal('remaining_amount', 12, 2)->default(0);
    $table->date('paid_date')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_loan_emi_status');
    }
};
