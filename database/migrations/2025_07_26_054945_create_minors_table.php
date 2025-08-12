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
        Schema::create('minors', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id')->nullable(); // Or wherever you want
            $table->unsignedBigInteger('promotor_id')->nullable();
            $table->date('enrollment_date');
            $table->enum('title', ['md', 'mr', 'ms', 'mrs']);
            $table->enum('gender', ['male', 'female', 'other']);
            $table->string('first_name', 255);
            $table->string('last_name', 255)->nullable();
            $table->date('dob');
            $table->string('father_name', 255);
            $table->string('aadhaar_no', 20)->nullable();
            $table->string('address', 500);
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('promotor_id')->references('id')->on('promotors')->onDelete('cascade');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('minors');
    }
};
