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
        Schema::create('scheme_charges', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('scheme_id');
            $table->foreign('scheme_id')->references('id')->on('schemes')->onDelete('cascade');
            $table->decimal('limit', 15, 2);
            $table->decimal('imps_charge', 10, 2)->nullable();
            $table->decimal('neft_charge', 10, 2)->nullable();
            $table->decimal('upi_charge', 10, 2)->nullable();
            $table->softDeletes();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('scheme_charges');
    }
};
