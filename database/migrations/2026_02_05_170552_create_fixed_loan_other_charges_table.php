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
        Schema::create('fixed_loan_other_charges', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('loan_id');

    $table->string('transaction_type')->nullable();
    $table->string('charge_type')->nullable();
    $table->decimal('amount',12,2)->default(0);
    $table->date('charge_date')->nullable();
    $table->text('remarks')->nullable();

    $table->tinyInteger('status')->default(1);
    $table->unsignedBigInteger('created_by')->nullable();
    $table->unsignedBigInteger('updated_by')->nullable();

    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_loan_other_charges');
    }
};
