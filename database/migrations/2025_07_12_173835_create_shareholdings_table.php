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
        Schema::create('shareholdings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('promoter'); 
            $table->date('allotment_date');
            $table->integer('first_share');
            $table->integer('share_no');
            $table->string('nominal_value');
            $table->integer('total_share_held');
            $table->decimal('total_share_value', 15, 2);
            $table->string('certificate_no')->nullable();
            $table->date('transaction_date');
            $table->decimal('amount', 15, 2);
            $table->text('remarks')->nullable();
            $table->enum('pay_mode', ['cash', 'online_tr', 'cheque', 'saving_ac']);

            $table->timestamps();
        });
      
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shareholdings');
    }
};
