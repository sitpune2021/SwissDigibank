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
        Schema::create('fixed_loan_extensions', function (Blueprint $table) {
    $table->id();
    $table->unsignedBigInteger('loan_id');

    $table->decimal('remaining_amount',12,2)->default(0);
    $table->decimal('interest_reverse',12,2)->default(0);
    $table->decimal('interest_accrued',12,2)->default(0);
    $table->decimal('overdue_total',12,2)->default(0);

    $table->decimal('penalty_amount',12,2)->default(0);
    $table->decimal('penalty_gst',12,2)->default(0);
    $table->decimal('penalty_total',12,2)->default(0);

    $table->decimal('notice_amount',12,2)->default(0);
    $table->decimal('notice_gst',12,2)->default(0);
    $table->decimal('notice_total',12,2)->default(0);

    $table->decimal('service_amount',12,2)->default(0);
    $table->decimal('service_gst',12,2)->default(0);
    $table->decimal('service_total',12,2)->default(0);

    $table->decimal('total_amount_h',12,2)->default(0);
    $table->decimal('rounding_off_i',12,2)->default(0);
    $table->decimal('closure_discount_j',12,2)->default(0);
    $table->decimal('net_amount_k',12,2)->default(0);

    $table->date('transaction_date')->nullable();
    $table->decimal('amount_paid',12,2)->default(0);

    $table->string('payment_mode')->nullable();
    $table->unsignedBigInteger('bank_id')->nullable();
    $table->string('cheque_no')->nullable();
    $table->date('cheque_date')->nullable();
    $table->date('transfer_date')->nullable();
    $table->string('utr_no')->nullable();
    $table->string('transfer_mode')->nullable();

    $table->boolean('credited')->default(false);

    $table->decimal('new_principal',12,2)->default(0);
    $table->date('reschedule_date')->nullable();
    $table->date('first_emi_date')->nullable();
    $table->decimal('interest_rate',5,2)->default(0);
    $table->string('emi_type')->nullable();
    $table->integer('tenure')->nullable();

    $table->text('reason')->nullable();
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fixed_loan_extensions');
    }
};
