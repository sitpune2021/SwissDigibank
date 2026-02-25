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
        Schema::create('vehical_loan_comments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_id')->nullable();
            $table->date('date')->nullable();
            $table->string('commented_by')->nullable();
            $table->text('comment')->nullable();
            $table->timestamps();

            // Optional Foreign Key (uncomment if needed)
            $table->foreign('loan_id')
                ->references('id')
                ->on('vehical_disbursements')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehical_loan_comments');
    }
};
