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
        Schema::create('vehical_credit_scores', function (Blueprint $table) {
            $table->id();

            // Foreign key reference to VehicalApplication
            $table->unsignedBigInteger('loan_application_id')->index();
            $table->foreign('loan_application_id')
                ->references('id')
                ->on('vehical_applications')
                ->onDelete('cascade');

            // Credit Score Details
            $table->string('cibil_type')->nullable(); // e.g., Individual, Commercial
            $table->integer('cibil_score')->nullable();
            $table->date('report_date')->nullable();
            $table->string('report_file_path')->nullable(); // file path of report

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehical_credit_scores');
    }
};
