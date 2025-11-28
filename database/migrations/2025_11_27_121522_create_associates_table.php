<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('associates', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('employee_id')->nullable(); // from employees table

            $table->string('rank')->nullable();
            $table->unsignedBigInteger('supervisor_id')->nullable();

            $table->date('enrollment_date')->nullable();

            $table->string('first_name');
            $table->string('last_name')->nullable();

            $table->string('username');
            $table->string('email')->nullable();
            $table->string('mobile', 20);

            $table->date('dob')->nullable();
            $table->string('father_name')->nullable();
            $table->string('husband_wife_name')->nullable();

            $table->string('pan')->nullable();
            $table->string('aadhaar', 20)->nullable();

            $table->text('address')->nullable();

            $table->integer('back_date_days')->default(0);
            $table->string('role')->nullable();

            $table->unsignedBigInteger('branch_id')->nullable();

            $table->enum('access_type', ['admin', 'agent', 'both'])->default('admin');
            $table->enum('login_holiday', ['yes', 'no'])->default('no');
            $table->enum('searchable_accounts', ['yes', 'no'])->default('no');

            $table->enum('active', ['yes', 'no'])->default('yes');

            // Nominee Info
            $table->string('nominee_name')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->text('nominee_address')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('associates');
    }
};
