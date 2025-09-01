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
        Schema::create('fd_schemes', function (Blueprint $table) {
            $table->id();
            $table->string('scheme_name');
            $table->string('scheme_code')->unique();
            $table->decimal('min_amount', 12, 2);
            $table->integer('lock_in_period'); 
            $table->integer('interest_lock_in'); 
            $table->decimal('bonus_rate', 5, 2)->nullable();
            $table->string('bonus_type')->nullable();
            $table->decimal('cancellation_charge', 5, 2)->nullable();
            $table->string('cancellation_type')->nullable(); 
            $table->decimal('penal_charge', 5, 2)->nullable();
            $table->date('effective_date');
            $table->decimal('stationary_fee', 8, 2)->nullable();
            $table->integer('admin')->nullable(); 
            $table->integer('associate')->nullable();
            $table->integer('member')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fd_schemes');
    }
};
