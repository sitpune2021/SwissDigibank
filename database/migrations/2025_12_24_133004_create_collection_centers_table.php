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
        
        Schema::create('collection_centers', function (Blueprint $table) {
            $table->id();

            // 1. Branch (Required)
            $table->foreignId('branch_id')
                  ->constrained('branches')
                  ->cascadeOnDelete();

            // 2. Center No (Required)
            $table->string('center_no');

            // 3. Center Name (Required)
            $table->string('center_name');

            // 4. Center Head (Member OR Employee | Nullable)
            $table->foreignId('center_head_member_id')
                  ->nullable()
                  ->constrained('members')
                  ->nullOnDelete();

            $table->foreignId('center_head_employee_id')
                  ->nullable()
                  ->constrained('employees')
                  ->nullOnDelete();

            // 5. Center Cashier (Member OR Employee | Nullable)
            $table->foreignId('center_cashier_member_id')
                  ->nullable()
                  ->constrained('members')
                  ->nullOnDelete();

            $table->foreignId('center_cashier_employee_id')
                  ->nullable()
                  ->constrained('employees')
                  ->nullOnDelete();

            // 6. Collection Day (Nullable)
            $table->string('collection_day')->nullable();

            // 7. Collection Time (Nullable)
            $table->string('collection_time')->nullable();

            // 8. Center Active (Required)
            $table->boolean('is_active');

            // 9–10. Location (Nullable)
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();

            // 11. Group (Nullable)
            $table->integer('group_id')->nullable();

            $table->timestamps();
        });
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::dropIfExists('collection_centers');
    }
};
