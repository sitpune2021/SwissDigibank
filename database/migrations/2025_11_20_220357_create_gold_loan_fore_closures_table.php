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
    Schema::create('gold_loan_fore_closures', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('loan_id');
        $table->tinyInteger('status')->default(0);

        // All fields from form
        $table->decimal('remaining_amount', 10, 2)->nullable();   // A
        $table->decimal('interest_accrued', 10, 2)->nullable();   // B
        $table->decimal('overdue_interest', 10, 2)->nullable();   // C

        $table->decimal('notice_charges', 10, 2)->nullable();     // D
        $table->decimal('service_charges', 10, 2)->nullable();    // E
        $table->decimal('other_charges', 10, 2)->nullable();      // F
        $table->decimal('foreclosure_charges', 10, 2)->nullable();// G

        $table->decimal('total_amount_h', 10, 2)->nullable();     // H
        $table->decimal('rounding_off_i', 10, 2)->nullable();     // I
        $table->decimal('closure_discount_j', 10, 2)->nullable(); // J
        $table->decimal('net_amount_k', 10, 2)->nullable();        // K

        $table->date('transaction_date')->nullable();
        $table->text('remarks')->nullable();

        $table->string('payment_mode')->nullable();
        $table->unsignedBigInteger('bank_id')->nullable(); // FK optional
        $table->string('cheque_no')->nullable();
        $table->date('cheque_date')->nullable();
        $table->date('transfer_date')->nullable();
        $table->string('utr_no')->nullable();
        $table->string('transfer_mode')->nullable(); // imps/vpa/neft_rtgs
        $table->boolean('credited')->nullable(); // 1/0

        $table->timestamps();

        $table->foreign('loan_id')->references('id')->on('loan_applications')->onDelete('cascade');
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gold_loan_fore_closures');
    }
};
