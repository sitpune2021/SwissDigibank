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
        Schema::create('unencumbered_deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')
                ->nullable()
                ->constrained('banks')
                ->nullOnDelete();

            $table->decimal('fd_amount', 15, 2)->nullable();
            $table->string('fd_no')->nullable();
            $table->date('open_date')->nullable();
            $table->decimal('annual_interest_rate', 5, 2)->nullable();
            $table->date('maturity_date')->nullable();
            $table->string('receipt_scan_copy')->nullable();

            $table->boolean('fd_from_deposit_money')->nullable(); 

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('unencumbered_deposits');
    }
};
