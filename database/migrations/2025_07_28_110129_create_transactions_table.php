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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id'); // Or wherever you want
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->enum('payment_mode', ['cash', 'online', 'cheque']);
            $table->decimal('amount', 12, 2);
            $table->enum('transaction_type', ['credit', 'debit']);
            $table->timestamp('transaction_date')->useCurrent()->useCurrentOnUpdate();

            $table->string('transfer_date')->nullable();
            $table->string('utr_number')->nullable();
            $table->enum('transfer_mode', ['IMPS', 'VPA', 'NEFT/RTGS'])->nullable();
            $table->boolean('credited_in')->nullable();

            $table->string('bank_name')->nullable();
            $table->string('cheque_no')->nullable();
            $table->string('cheque_date')->nullable();

            $table->enum('approve_status', ['approved', 'disapproved', 'pending'])->default('pending');
            $table->string('comment');
            $table->integer('reverse_status')->nullable();
            $table->string('remarks')->nullable();
            $table->string('payment_rev_rel')->nullable();

            $table->softDeletes();
            $table->timestamps(); 

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
