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
        Schema::create('gold_loan_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id');
            $table->date('transaction_date');
            $table->decimal('current_debt', 12, 2);
            $table->decimal('other_charges', 12, 2)->default(0);
            $table->decimal('total_payable', 12, 2);
            $table->decimal('amount_collected', 12, 2);
            $table->string('remarks')->nullable();
            $table->string('flag')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_loan_transactions');
    }
};
