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
        Schema::create('share_transfer', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('transferor_id');
            $table->unsignedBigInteger('member_id');
            $table->string('business_type');
            $table->date('transfer_date');
            $table->integer('shares');
            $table->decimal('face_value', 10, 2);
            $table->integer('total_consideration');
            $table->string('status')->default('pending');
            $table->string('remarks')->nullable();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('share_transfer');
    }
};
