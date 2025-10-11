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
        Schema::create('mortgage_loan_credit_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_application_id')
                ->constrained('mortgage_loan_applications')
                ->onDelete('cascade');
            $table->string('cibil_type')->nullable();
            $table->integer('cibil_score')->nullable();
            $table->date('report_date')->nullable();
            $table->string('report_file_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortgage_loan_credit_scores');
    }
};
