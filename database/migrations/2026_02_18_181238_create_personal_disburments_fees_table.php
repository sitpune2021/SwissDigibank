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
        Schema::create('personal_disburments_fees', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('loan_id');

            $table->enum('fee_type', [
                'stamp_duty',
                'issuer_fee',
                'processing_fee'
            ]);

            $table->enum('payment_mode', ['cash', 'cheque', 'online']);

            $table->unsignedBigInteger('bank_id')->nullable();

            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->enum('transfer_mode', ['imps', 'vpa', 'neft_rtgs'])->nullable();

            $table->string('credited_account')->nullable();

            $table->timestamps();

            // ✅ SHORT FOREIGN KEY NAME
            $table->foreign('loan_id')
                ->references('id')
                ->on('personal_disburments')
                ->onDelete('cascade');

            $table->foreign('bank_id',)
                ->references('id')
                ->on('banks')
                ->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_disburments_fees');
    }
};
