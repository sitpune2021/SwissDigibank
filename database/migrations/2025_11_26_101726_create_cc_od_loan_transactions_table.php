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
        Schema::create('cc_od_loan_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id'); 
            $table->integer('emi_no')->nullable();
            $table->date('transaction_date')->nullable();
            $table->decimal('current_debt', 15, 2)->default(0);
            $table->decimal('other_charges', 15, 2)->default(0);
            $table->decimal('total_payable', 15, 2)->default(0);
            $table->decimal('amount_collected', 15, 2)->default(0);
            $table->text('remarks')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->string('status')->default('pending');
            $table->date('paid_date')->nullable();
            $table->string('fee_mode')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('flag')->nullable();
            $table->string('transfer_mode')->nullable();
            $table->boolean('credited_to_company')->default(false);
            $table->timestamps();

            // Foreign key
            $table->foreign('loan_id')->references('id')->on('cc_od_loan_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cc_od_loan_transactions');
    }
};
