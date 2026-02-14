<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('promotor_membership_charges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('promotor_id')->constrained()->cascadeOnDelete();

            $table->date('transaction_date')->nullable();

            $table->decimal('amount', 10, 2)->nullable();
            $table->decimal('gst_rate', 5, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->nullable();
            $table->decimal('net_fee', 10, 2)->nullable();

            $table->string('remarks')->nullable();

            // payment info
            $table->enum('pay_mode', ['cash', 'cheque', 'online'])->default('cash');
            $table->foreignId('bank_id')->nullable()->constrained()->nullOnDelete();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
           $table->enum('transfer_mode', ['imps', 'vpa', 'neft_rtgs'])->nullable();
            $table->boolean('credited')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotor_membership_charges');
    }
};
