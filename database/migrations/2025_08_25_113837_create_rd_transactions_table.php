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
        Schema::create('rd_transactions', function (Blueprint $table) {
            $table->id();
            // General payment info
            $table->foreignId('rd_account_id')->constrained('rd_accounts');;
            $table->enum('payment_mode', ['cash', 'onlineTr', 'cheque', 'savingAcc'])->comment('Mode of payment');
            $table->date('t_date')->comment('Transaction date');
            $table->decimal('amount', 12, 2)->comment('Transaction amount');
            $table->enum('transaction_type', ['credit', 'debit'])->comment('Trasfer type');
            // Online transfer fields
            $table->date('transfer_date')->nullable()->comment('Date of online transfer');
            $table->string('transaction_no')->nullable()->comment('UTR or transaction number');
            $table->enum('transfer_mode', ['IMPS', 'VPA', 'NEFT/RTGS'])->nullable()->comment('Mode of transfer');
            $table->enum('credited', ['yes', 'no'])->nullable()->comment('Whether credited in company account');
            // Cheque fields
            $table->string('cheque_bank_name')->nullable()->comment('Bank name for cheque');
            $table->string('cheque_no')->nullable()->comment('Cheque number');
            $table->date('cheque_date')->nullable()->comment('Cheque date');
            $table->enum('approve_status', ['approved', 'disapproved', 'pending'])->comment('cheque approvel status');
            // Saving account selection
            $table->string('savings_account')->nullable()->comment('Selected saving account');
            $table->integer('reverse_status')->nullable()->comment('Reverse status code');
            $table->string('payment_rev_rel', 255)->nullable()->default('')->comment('...');
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rd_transactions');
    }
};
