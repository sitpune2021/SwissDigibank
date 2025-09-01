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
        Schema::create('promotors', function (Blueprint $table) {
            $table->id();

            $table->date('enrollment_date');
            $table->string('title');
            $table->string('gender');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->unsignedBigInteger('branch_id');
            $table->date('date_of_birth')->nullable();
            $table->string('occupation')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->unsignedBigInteger('marital_statuses_id')->nullable();
            $table->unsignedBigInteger('religions_id')->nullable();
            $table->string('husband_wife_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();
            $table->boolean('sms')->default(0);
            $table->string('folio_no')->unique();
            $table->string('active')->default('No');
            $table->string('form15g')->default('No');

            $table->softDeletes();
            $table->timestamps();

            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
            $table->foreign('marital_statuses_id')->references('id')->on('marital_statuses')->onDelete('cascade');
            $table->foreign('religions_id')->references('id')->on('religions')->onDelete('cascade');
        });
    }
    
    public function down(): void
    {
        Schema::dropIfExists('promotors');
    }
};
