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
        Schema::create('vehical_loan_fore_closures', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id'); 
            $table->decimal('remaining_amount', 15, 2)->default(0);
            $table->decimal('interest_accrued', 15, 2)->default(0);
            $table->decimal('overdue_interest', 15, 2)->default(0);
            $table->decimal('notice_charges', 15, 2)->default(0);
            $table->decimal('service_charges', 15, 2)->default(0);
            $table->decimal('other_charges', 15, 2)->default(0);
            $table->decimal('foreclosure_charges', 15, 2)->default(0);
            $table->decimal('total_amount_h', 15, 2)->default(0);
            $table->decimal('rounding_off_i', 15, 2)->default(0);
            $table->decimal('closure_discount_j', 15, 2)->default(0);
            $table->decimal('net_amount_k', 15, 2)->default(0);
            $table->date('transaction_date')->nullable();
            $table->text('remarks')->nullable();
            $table->string('payment_mode')->nullable();
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable();
            $table->boolean('credited')->default(false);
            $table->string('status')->default('pending');
            $table->timestamps();

            // Foreign key to loans
            $table->foreign('loan_id')->references('id')->on('vehical_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehical_loan_fore_closures');
    }
};
