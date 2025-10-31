<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('daily_weekly_credit_scores', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('loan_application_id');
            $table->string('cibil_type')->nullable();
            $table->string('cibil_score')->nullable();
            $table->date('report_date')->nullable();
            $table->string('report_file_path')->nullable();

            $table->timestamps();

            // Foreign Key Constraint
            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('daily_weekly_applications')
                  ->onDelete('cascade'); // delete application → deletes credit scores
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('daily_weekly_credit_scores');
    }
};
