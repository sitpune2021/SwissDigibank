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
        Schema::create('online_transactions', function (Blueprint $table) {
            $table->id();
                $table->unsignedBigInteger('account_id'); // Or wherever you want
            $table->foreign('account_id')->references('id')->on('accounts')->onDelete('cascade');
            $table->decimal('amount', 10, 2);
            $table->date('transfer_date');
            $table->string('utr_no')->unique(); 
            $table->string('transfer_mode');
            $table->boolean('credited'); 
            $table->string('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('online_transactions');
    }
};
