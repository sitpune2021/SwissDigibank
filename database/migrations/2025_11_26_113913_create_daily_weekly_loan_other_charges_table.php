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
        Schema::create('daily_weekly_loan_other_charges', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id'); // FK to MortgageLoanApplication
            $table->string('transaction_type')->nullable();
            $table->string('charge_type')->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->date('charge_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('status')->default('pending');
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();

            // Foreign key to loans
            $table->foreign('loan_id')->references('id')->on('daily_weekly_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('daily_weekly_loan_other_charges');
    }
};
