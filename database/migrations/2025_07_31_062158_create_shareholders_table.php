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
        Schema::create('shareholders', function (Blueprint $table) {
            $table->id();
            $table->string('transferor')->nullable();
            $table->unsignedBigInteger('member_id');
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

            $table->unsignedBigInteger('shareholding_id')->nullable();
            $table->foreign('shareholding_id')->references('id')->on('shareholdings')->onDelete('cascade');

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');

            $table->string('business_type')->nullable();
            $table->date('transfer_date')->nullable();
            $table->integer('shares')->nullable();
            $table->decimal('face_value', 10, 2)->nullable();
            $table->decimal('total_consideration', 15, 2)->nullable();
            $table->string('share_range')->nullable();
            $table->integer('total_share_held')->nullable();
            $table->decimal('nominal_value', 10, 2)->nullable();
            $table->decimal('total_share_value', 15, 2)->nullable();
            $table->date('allotment_date')->nullable();
            $table->string('certificate_no')->nullable();
            $table->boolean('surrendered')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shareholders');
    }
};
