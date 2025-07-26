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
        Schema::create('directors', function (Blueprint $table) {
            $table->id();
                $table->unsignedBigInteger('member_id');
                $table->string('designation');
                $table->string('director_name');
                $table->string('din_no');
                $table->date('appointment_date');
                $table->date('resignation_date');
                $table->string('signature'); // path to image file
                $table->enum('authorized_signatory', ['Yes', 'No'])->default('No');
            $table->softDeletes();
            $table->timestamps();
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('directors');
    }
};
