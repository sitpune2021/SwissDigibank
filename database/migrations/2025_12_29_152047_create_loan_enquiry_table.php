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
        Schema::create('loan_enquiry', function (Blueprint $table) {
            $table->id();
          
            $table->string('residential_type');
            $table->string('occupation_type');
            $table->decimal('monthly_income', 10, 2);

            // Step 3
            $table->unsignedBigInteger('scheme_id')->nullable();
            $table->decimal('loan_amount', 10, 2)->nullable();
            $table->integer('tenure_months')->nullable();
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->string('margin')->nullable();

            // Step 4
            $table->string('credit_account')->nullable();

            // Step 5
            $table->string('branch_code')->nullable();

            $table->string('status')->default('draft');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_enquiry');
    }
};
