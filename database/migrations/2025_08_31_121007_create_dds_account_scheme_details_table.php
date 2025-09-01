<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dds_account_scheme_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dds_account_id')->constrained()->onDelete('cascade');
            $table->string('scheme_code')->nullable();
            $table->string('scheme_name')->nullable();
            $table->integer('rd_dd_lock_in_period')->nullable();
            $table->integer('interest_lock_in_period')->nullable();
            $table->decimal('anuual_interest_rate', 5, 2)->nullable();
            $table->string('interest_compounding_interval')->nullable();
            $table->integer('tenure_of_rd_dd_value')->nullable();
            $table->decimal('cancellation_charges_value', 8, 2)->nullable();
            $table->decimal('bonus_rate_value', 8, 2)->nullable();
            $table->decimal('min_rd_dd_amount', 10, 2)->nullable();
            $table->string('rd_dd_frequency')->nullable(); 
            $table->text('commission_chart')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('dds_account_scheme_details');
    }
};
