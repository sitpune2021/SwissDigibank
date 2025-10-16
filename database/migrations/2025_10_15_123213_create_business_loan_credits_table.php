<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('business_loan_credits', function (Blueprint $table) {
            $table->id();
            
            // Foreign key reference to business_loan_applications table
            $table->unsignedBigInteger('loan_application_id');

            $table->string('cibil_type')->nullable(); // e.g., CIBIL / Experian
            $table->integer('cibil_score')->nullable(); // numeric score
            $table->date('report_date')->nullable();   // CIBIL report date
            $table->string('report_file_path')->nullable(); // file storage path
            
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('bussiness_loan_applications') // ✅ your actual table name
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('business_loan_credits');
    }
};
