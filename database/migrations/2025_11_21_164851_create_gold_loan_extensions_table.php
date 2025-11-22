<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('gold_loan_extensions', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('loan_id');

        // A,B,C,D,E,F,G,H,I,J,K Values
        $table->decimal('remaining_amount', 10, 2)->nullable();   // A
        $table->decimal('interest_reverse', 10, 2)->nullable();   // B
        $table->decimal('interest_accrued', 10, 2)->nullable();   // C
        $table->decimal('overdue_total', 10, 2)->nullable();      // D

        // Penalty / Overdue (E)
        $table->decimal('penalty_amount', 10, 2)->nullable();
        $table->decimal('penalty_gst', 10, 2)->nullable();
        $table->decimal('penalty_total', 10, 2)->nullable();

        // Notice (F)
        $table->decimal('notice_amount', 10, 2)->nullable();
        $table->decimal('notice_gst', 10, 2)->nullable();
        $table->decimal('notice_total', 10, 2)->nullable();

        // Service Charge (G)
        $table->decimal('service_amount', 10, 2)->nullable();
        $table->decimal('service_gst', 10, 2)->nullable();
        $table->decimal('service_total', 10, 2)->nullable();

        // Final Values
        $table->decimal('total_amount_h', 10, 2)->nullable();   // H
        $table->decimal('rounding_off_i', 10, 2)->nullable();   // I
        $table->decimal('closure_discount_j', 10, 2)->nullable(); // J
        $table->decimal('net_amount_k', 10, 2)->nullable();     // K

        // Payments & Remarks
        $table->date('transaction_date')->nullable();
        $table->decimal('amount_paid', 10, 2)->nullable();
        $table->string('payment_mode')->nullable();
        $table->string('bank_id')->nullable();
        $table->string('cheque_no')->nullable();
        $table->date('cheque_date')->nullable();
        $table->date('transfer_date')->nullable();
        $table->string('utr_no')->nullable();
        $table->string('transfer_mode')->nullable();
        $table->boolean('credited')->default(0);

        // Extension Details
        $table->decimal('new_principal', 10, 2)->nullable();
        $table->date('reschedule_date')->nullable();
        $table->date('first_emi_date')->nullable();
        $table->decimal('interest_rate', 10, 2);
        $table->string('emi_type')->nullable();
        $table->integer('tenure')->nullable();
        $table->text('reason')->nullable();

        $table->timestamps();

        $table->foreign('loan_id')->references('id')->on('gold_loans')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_loan_extensions');
    }
};
