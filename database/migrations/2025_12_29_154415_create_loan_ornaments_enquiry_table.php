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
        Schema::create('loan_ornaments_enquiry', function (Blueprint $table) {
            $table->id();
            $table->foreignId('loan_enquiry_id')
                ->constrained('loan_enquiry')->nullable()
                ->cascadeOnDelete();
            $table->string('type')->nullable();
            $table->integer('qty')->nullable();
            $table->integer('carat')->nullable();
            $table->decimal('net_weight', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_ornaments_enquiry');
    }
};
