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
        Schema::create('cheque_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('account_id'); // Or wherever you want
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->string('bank_name');
            $table->string('cheque_number')->unique();
            $table->date('cheque_date');
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cheque_transactions');
    }
};
