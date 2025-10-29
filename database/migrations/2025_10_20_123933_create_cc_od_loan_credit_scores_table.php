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
        Schema::create('cc_od_loan_credit_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_application_id')->nullable();
            $table->string('cibil_type')->nullable(); // e.g. CIBIL, EXPERIAN, etc.
            $table->integer('cibil_score')->nullable();
            $table->date('report_date')->nullable();
            $table->string('report_file_path')->nullable(); // File storage path
            $table->timestamps();

            // (Optional) Foreign key relationship
            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('cc_od_loan_applications')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cc_od_loan_credit_scores');
    }
};
