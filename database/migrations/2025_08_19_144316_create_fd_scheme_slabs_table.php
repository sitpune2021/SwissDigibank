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
        Schema::create('fd_scheme_slabs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fd_scheme_id')->constrained()->onDelete('cascade');
            $table->integer('day_from');
            $table->integer('day_to');
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('sr_citizen_rate', 5, 2)->nullable();
            $table->string('payout_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fd_scheme_slabs');
    }
};
