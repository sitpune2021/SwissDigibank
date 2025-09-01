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
        Schema::create('fd_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fd_account_id');

            $table->date('transaction_date');
            $table->decimal('amount', 15, 2)->nullable();
            $table->string('mode', 50)->nullable(); // cash, cheque, transfer, etc.
            $table->string('bank', 100)->nullable();
            $table->string('cheque_no', 50)->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('transaction_no', 100)->nullable();
            $table->string('transfer_mode', 50)->nullable(); // NEFT, RTGS, IMPS, UPI
            $table->boolean('credited')->default(false);
            $table->string('saving_account', 100)->nullable();
            $table->string('status')->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fd_transactions');
    }
};
