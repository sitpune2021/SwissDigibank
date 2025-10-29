<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('daily_weekly_processing_fees', function (Blueprint $table) {
        $table->id();

        $table->unsignedBigInteger('application_id');
        $table->decimal('value', 10, 2)->nullable();
        $table->decimal('gst_percent', 5, 2)->default(18.00);
        $table->decimal('sgst', 10, 2)->nullable();
        $table->decimal('cgst', 10, 2)->nullable();
        $table->decimal('igst', 10, 2)->nullable();
        $table->decimal('total', 10, 2)->nullable();

        $table->enum('fee_mode', ['cash', 'cheque', 'online'])->default('cash');

        $table->unsignedBigInteger('bank_id')->nullable(); 
        $table->string('cheque_no')->nullable();
        $table->date('cheque_date')->nullable();

        $table->date('transfer_date')->nullable();
        $table->string('utr_no')->nullable();
        $table->string('transfer_mode')->nullable();

        $table->boolean('credited')->default(false);

        $table->timestamps();

        $table->foreign('application_id')
              ->references('id')
              ->on('daily_weekly_applications')
              ->onDelete('cascade');
    });
}

public function down()
{
    Schema::dropIfExists('daily_weekly_processing_fees');
}

};
