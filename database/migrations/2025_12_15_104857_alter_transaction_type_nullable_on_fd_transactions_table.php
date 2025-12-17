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
        Schema::table('fd_transactions', function (Blueprint $table) {
            $table->tinyInteger('transaction_type')
                ->nullable()
                ->comment('1 = Credit, 0 = Debit')
                ->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fd_transactions', function (Blueprint $table) {

            $table->dropColumn('transaction_type');
        });
    }
};
