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
        Schema::create('loan_credit_scores', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_application_id'); // foreign key
            $table->string('cibil_type')->nullable();
            $table->integer('cibil_score')->nullable();
            $table->date('report_date')->nullable();
            $table->string('report_file_path')->nullable();
            $table->timestamps();

            // Foreign Key Relation
            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('loan_applications')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_credit_scores');
    }
};
