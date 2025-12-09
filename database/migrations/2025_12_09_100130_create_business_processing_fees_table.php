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
        Schema::create('business_processing_fees', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('application_id');

            $table->decimal('value', 10, 2)->default(0);
            $table->decimal('gst_percent', 5, 2)->default(0);

            $table->decimal('sgst', 10, 2)->default(0);
            $table->decimal('cgst', 10, 2)->default(0);
            $table->decimal('igst', 10, 2)->default(0);

            $table->decimal('total', 10, 2)->default(0);

            $table->string('fee_mode')->nullable();       // Cash / Cheque / UPI / Transfer
            $table->unsignedBigInteger('bank_id')->nullable();

            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable();  // IMPS / NEFT / RTGS

            $table->boolean('credited')->default(false);

            $table->timestamps();

            // Optional foreign key
            // $table->foreign('application_id')->references('id')->on('loan_against_applications')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('business_processing_fees');
    }
};
