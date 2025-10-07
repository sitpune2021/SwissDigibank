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
        Schema::create('loan_ornaments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')
                ->constrained('loan_applications')
                ->onDelete('cascade');

            $table->string('item_type');       // Gold, Silver, Platinum, etc.
            $table->string('item_name');       // Ring, Coin, Chain, etc.
            $table->integer('no_of_items')->default(1);
            $table->decimal('value_per_gram', 10, 2)->nullable();
            $table->decimal('gross_weight', 10, 3)->nullable();
            $table->decimal('net_weight', 10, 3)->nullable();
            $table->decimal('tunch', 5, 2)->nullable();        // Purity in percentage
            $table->decimal('fine_weight', 10, 3)->nullable();
            $table->decimal('total_value', 15, 2)->nullable();
            $table->string('status');
            $table->text('remark')->nullable();

            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loan_ornaments');
    }
};
