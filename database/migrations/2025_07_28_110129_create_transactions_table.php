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
            // Foreign key to accounts
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');

            // Required fields
            $table->enum('payment_mode', ['cash', 'online', 'cheque']);
            $table->decimal('amount', 12, 2);
            $table->enum('transaction_type', ['credit', 'debit']);
            $table->timestamp('transaction_date')->useCurrent()->useCurrentOnUpdate();

            // Online transfer fields
            $table->date('transfer_date')->nullable();
            $table->string('utr_number')->nullable();
            $table->enum('transfer_mode', ['IMPS', 'VPA', 'NEFT/RTGS'])->nullable();
            $table->boolean('credited_in')->nullable(); // tinyint(1)

            // Cheque fields
            $table->string('bank_name')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

            // Approval and remarks
            $table->enum('approve_status', ['approved', 'disapproved', 'pending'])->default('pending');
            $table->string('comment');
            $table->string('remarks')->nullable();

            $table->softDeletes();
            // Timestamps
            $table->timestamps(); // created_at and updated_at (nullable)

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
