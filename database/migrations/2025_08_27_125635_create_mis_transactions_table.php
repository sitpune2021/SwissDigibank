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
        Schema::create('mis_transactions', function (Blueprint $table) {
            $table->id();
             // Basic fields
            $table->decimal('amount', 15, 2);
            $table->enum('pay_mode', ['cash', 'cheque', 'online', 'saving']);

            // Cheque fields
            $table->integer('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

            // Online transfer fields
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->enum('transfer_mode', ['imps', 'vpa', 'neft_rtgs'])->nullable();
            $table->string('credited')->nullable(); // yes/no

            // Saving account field
            $table->foreignId('saving_account_id')->nullable()->constrained('accounts');
              $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mis_transactions');
    }
};
