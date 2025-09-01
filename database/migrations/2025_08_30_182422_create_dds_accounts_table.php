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
        Schema::create('dds_accounts', function (Blueprint $table) {
            $table->id();
             $table->decimal('total_deposit', 15, 2);
            $table->decimal('interest_earned', 15, 2);
            $table->decimal('bonus', 15, 2)->default(0);
            $table->decimal('maturity', 15, 2);
            $table->date('maturity_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dds_accounts');
    }
};
