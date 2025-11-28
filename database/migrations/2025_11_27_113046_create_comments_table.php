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
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('misaccount_id')->nullable();
            $table->date('date');
            $table->unsignedBigInteger('commented_by')->nullable(); // user/staff ID
            $table->text('comment');
            $table->timestamps();

            // Foreign key (optional)
            $table->foreign('misaccount_id')
                  ->references('id')->on('misaccounts')
                  ->onDelete('cascade');

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments');
    }
};
