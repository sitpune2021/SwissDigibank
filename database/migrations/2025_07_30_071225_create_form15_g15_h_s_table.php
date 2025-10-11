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
        Schema::create('form15_g15_h_s', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
            $table->string('financial_year');
            $table->string('form_15_upload'); // path to uploaded file
            $table->timestamps();

            // Optional: foreign key constraint if members table exists
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        });
   
    }
    public function down(): void
    {
        Schema::dropIfExists('form15_g15_h_s');
    }
};
