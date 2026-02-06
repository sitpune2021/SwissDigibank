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
        Schema::create('notices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('branch_id')->constrained('branches')->onDelete('cascade'); // Foreign key
            $table->string('notice_title');
            $table->text('notice_body');
            $table->string('images')->nullable(); // Store file path
            $table->date('start_date');
            $table->date('end_date');
            $table->enum('app_type', ['Admin App', 'Agent App', 'Both App']);
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notices');
    }
};
