<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('goldloan_processing_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('application_id')->index();
            $table->decimal('value', 10, 2)->default(0);
            $table->decimal('gst_percent', 5, 2)->default(0);
            $table->decimal('sgst', 10, 2)->default(0);
            $table->decimal('cgst', 10, 2)->default(0);
            $table->decimal('igst', 10, 2)->default(0);
            $table->decimal('total', 10, 2)->default(0);
            $table->string('fee_mode')->nullable(); // e.g. cash, cheque, transfer
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();
            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable(); // e.g. NEFT, RTGS, IMPS
            $table->boolean('credited')->default(false);

            $table->timestamps();

            // optional foreign key if you have a loan_applications table
            // $table->foreign('application_id')->references('id')->on('loan_applications')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('goldloan_processing_fees');
    }
};
