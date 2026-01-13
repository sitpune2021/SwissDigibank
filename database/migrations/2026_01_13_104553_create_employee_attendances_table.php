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
        Schema::create('employee_attendances', function (Blueprint $table) {
            $table->id();

            // employee id (foreign key)
            $table->foreignId('employee_id')
                  ->constrained('employees')
                  ->cascadeOnDelete();

            // attendance date
            $table->date('attendance_date');

            // times
            $table->time('in_time')->nullable();
            $table->time('out_time')->nullable();

            // working time (store minutes, safer than string)
            $table->integer('working_minutes')->default(0);

            // status (NOT NULL)
            $table->string('status');

            // created by (current login user)
            $table->foreignId('created_by')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->timestamps();

            // one attendance per employee per day
            $table->unique(['employee_id', 'attendance_date']);
    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employee_attendances');
    }
};
