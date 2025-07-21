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

            // Correct foreign key column name (should be account_id, not account_no)
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');

            // Common fields
            $table->enum('payment_mode', ['cash', 'online', 'cheque']);
            $table->date('transaction_date');

            // Online Transfer fields
            $table->date('transfer_date')->nullable();
            $table->string('utr_number')->nullable();
            $table->enum('transfer_mode', ['IMPS', 'VPA', 'NEFT/RTGS'])->nullable();
            $table->boolean('credited_in')->nullable();

            // Cheque fields
            $table->string('bank_name')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

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
