<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehical_processing_fees', function (Blueprint $table) {
            $table->id();

            // Foreign Key (Loan Application ID)
            $table->unsignedBigInteger('application_id')->index();

            // Fee details
            $table->decimal('value', 10, 2)->default(0);
            $table->decimal('gst_percent', 5, 2)->default(0);
            $table->decimal('sgst', 10, 2)->default(0);
            $table->decimal('cgst', 10, 2)->default(0);
            $table->decimal('igst', 10, 2)->default(0);
            $table->decimal('total', 12, 2)->default(0);

            // Payment Mode Details
            $table->string('fee_mode')->nullable();          // cash / cheque / transfer
            $table->unsignedBigInteger('bank_id')->nullable();
            $table->string('cheque_no')->nullable();
            $table->date('cheque_date')->nullable();

            $table->date('transfer_date')->nullable();
            $table->string('utr_no')->nullable();
            $table->string('transfer_mode')->nullable();

            // Credited flag
            $table->boolean('credited')->default(0);         // ✅ Default Value 0

            $table->timestamps();

            // Optional: Add foreign key if loan table exists
            // $table->foreign('application_id')
            //       ->references('id')->on('vehical_applications')
            //       ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehical_processing_fees');
    }
};
