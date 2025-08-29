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
        Schema::create('dd_transactions', function (Blueprint $table) {
            $table->id();

            // Link to Accounts table (main account for this DD transaction)
            $table->unsignedBigInteger('account_id');

            // Common Fields
            $table->enum('pay_mode', ['cash', 'online', 'cheque', 'saving']);
            $table->date('transaction_date'); // T. Date
            $table->decimal('amount', 12, 2);

            // Online Transfer
            $table->date('transfer_date')->nullable();
            $table->enum('transfer_mode', ['IMPS', 'VPA', 'NEFT/RTGS'])->nullable();
            $table->string('utr_no')->nullable();
            $table->boolean('credited_in_company')->nullable(); // Yes / No

            // Cheque
            $table->unsignedBigInteger('bank_id')->nullable(); // FK to banks table
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

            // Saving A/c (also from accounts table)
            $table->unsignedBigInteger('saving_account_id')->nullable();

            $table->timestamps();

            // Foreign keys
            $table->foreign('account_id')
                ->references('id')->on('accounts')
                ->cascadeOnDelete();

            $table->foreign('bank_id')
                ->references('id')->on('banks')
                ->nullOnDelete();

            $table->foreign('saving_account_id')
                ->references('id')->on('accounts') // 🔥 corrected
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dd_transactions');
    }
};
