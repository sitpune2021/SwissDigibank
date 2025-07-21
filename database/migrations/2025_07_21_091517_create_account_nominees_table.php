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
        Schema::create('account_nominees', function (Blueprint $table) {
            $table->id();

            // Foreign key referencing 'accounts' table
            $table->foreignId('account_id')->constrained('accounts')->onDelete('cascade');

            // Nominee details
            $table->string('nominee_name');
            $table->string('nominee_relation');
            $table->text('nominee_address')->nullable();
            $table->decimal('share_percentage', 5, 2)->default(100.00); // e.g., 50.00, 25.00

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('account_nominees');
    }
};
