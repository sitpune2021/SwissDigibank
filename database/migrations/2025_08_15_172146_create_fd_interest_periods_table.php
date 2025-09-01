<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    public function up(): void
    {
        Schema::create('fd_interest_periods', function (Blueprint $table) {
            $table->id();
            // Link to maturity statement
            $table->foreignId('maturity_statement_id')
                ->constrained('fd_maturity_statements')
                ->cascadeOnDelete();
            // Period details

            $table->date('period_from');
            $table->date('period_to');
            $table->unsignedInteger('days');                   // e.g., 230
            $table->decimal('principal', 15, 2);               // e.g., 11111.00
            $table->decimal('interest', 15, 2);                // e.g., 770.16
            $table->decimal('tds', 15, 2)->default(0);
            $table->decimal('net_interest', 15, 2);            // interest - tds
            $table->decimal('cumulative_net_interest', 15, 2)->nullable();
            $table->decimal('principal_at_eoy', 15, 2)->nullable();
            $table->decimal('due_by', 15, 2)->nullable();
            $table->boolean('is_due_date_row')->default(false);
            $table->string('note', 255)->nullable();
            $table->timestamps();
            $table->index(['maturity_statement_id', 'period_from', 'period_to'], 'fd_ip_maturity_period_index');
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('fd_interest_periods');
    }
};
