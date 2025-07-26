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
        Schema::create('promotor_nomines', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promotor_id');
            $table->string('name');
            $table->string('relation')->nullable();
            $table->string('mobile_no' );
            $table->string('aadhaar_no')->nullable();
            $table->string('voter_id_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->text('address')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('promotor_id')->references('id')->on('promotors')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotor_nomines');
    }
};
