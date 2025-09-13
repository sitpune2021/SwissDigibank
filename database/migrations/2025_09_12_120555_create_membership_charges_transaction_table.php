<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership_charges_transaction', function (Blueprint $table) {
            $table->id();
            $table->date('transaction_date')->nullable();
            $table->decimal('membership_fee', 10, 2);
            $table->decimal('net_fee_to_collect', 10, 2);
            $table->text('remarks')->nullable();
            $table->enum('charges_pay_mode', ['cash', 'online', 'cheque']);
            $table->date('transfer_date')->nullable();
            $table->string('online_utr_no')->nullable();
            $table->enum('transfer_mode', ['IMPS', 'VPA', 'NEFT/RTGS'])->nullable();
            $table->string('cheque_bank_name')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership_charges_transaction');
    }
};
