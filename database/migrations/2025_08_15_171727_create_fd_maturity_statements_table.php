<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('fd_maturity_statements', function (Blueprint $table) {
            $table->id();
            // Link to users table (per user FD summary)
            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->decimal('principal_amount', 15, 2);        // A
            $table->decimal('interest_earned', 15, 2);         // B
            $table->decimal('tds_deducted', 15, 2)->default(0); // C
            $table->decimal('net_interest_earned', 15, 2);     // D = B - C
            $table->decimal('maturity_bonus_amount', 15, 2)->default(0); // E
            $table->decimal('maturity_amount', 15, 2);         // A + D + E
            $table->date('maturity_date');                     // e.g., 2026-09-15
            $table->date('statement_from')->nullable();
            $table->date('statement_to')->nullable();
            $table->string('currency', 8)->default('INR');
            $table->timestamps();
            $table->index(['user_id', 'maturity_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('fd_maturity_statements');
    }
};
