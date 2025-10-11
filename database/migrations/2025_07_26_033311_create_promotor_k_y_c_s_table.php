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
        Schema::create('promotor_k_y_c_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promotor_id');
            $table->string('aadhaar_no')->nullable();
            $table->string('voter_id_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('ration_card_no')->nullable();
            $table->string('meter_no')->nullable();
            $table->string('ci_no')->nullable();
            $table->string('ci_relation')->nullable();
            $table->string('dl_no')->nullable();
            $table->enum('kyc_status',['pending', 'in_progress', 'completed', 'rejected'])->default('pending');
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
        Schema::dropIfExists('promotor_k_y_c_s');
    }
};
