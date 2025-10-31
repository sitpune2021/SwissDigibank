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
        Schema::create('personal_credit_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_application_id')->nullable();
            $table->string('cibil_type')->nullable();       // e.g., Individual, Joint, etc.
            $table->integer('cibil_score')->nullable();     // Numeric score
            $table->date('report_date')->nullable();        // Date of the CIBIL report
            $table->string('report_file_path')->nullable(); // Path to uploaded report
            $table->timestamps();

            // Foreign key relation
            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('personal_loan_applications')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_credit_scores');
    }
};
