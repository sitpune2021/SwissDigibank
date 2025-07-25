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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable(); // For linking profile if needed
            $table->unsignedBigInteger('branch_id')->nullable();
            $table->date('joining_date')->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('dob')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile_no');
            $table->text('address')->nullable();
            $table->string('father_name')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('aadhar_no')->nullable();
            $table->string('blood_group')->nullable();
            $table->decimal('monthly_salary', 10, 2)->nullable();
            $table->string('location')->nullable();

            // Bank Info
            $table->string('account_holder')->nullable();
            $table->string('bank_name')->nullable();
            $table->string('account_no')->nullable();
            $table->string('ifsc')->nullable();

            // Nominee Info
            $table->string('nominee_name')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->text('nominee_address')->nullable();

            // Accounting Link
            $table->boolean('auto_generate')->default(false);
            $table->unsignedBigInteger('payable_ledger_id')->nullable();
            $table->unsignedBigInteger('expense_ledger_id')->nullable();

            $table->string('designation')->nullable();
            $table->string('name')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
