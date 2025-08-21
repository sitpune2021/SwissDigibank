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
        Schema::table('fd_maturity_statements', function (Blueprint $table) {
            $table->decimal('maturity_amount', 10, 2)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fd_maturity_statements', function (Blueprint $table) {
                        $table->integer('maturity_amount')->change();  // Revert back if needed

        });
    }
};
