<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rd_transactions', function (Blueprint $table) {

            // 1. Modify payment_mode ENUM
            $table->enum('payment_mode', [
                'cash',
                'onlineTr',
                'cheque',
                'savingAcc',
                'System'
            ])->comment('Mode of payment')->change();

            // 2. Drop balance column if exists
            if (Schema::hasColumn('rd_transactions', 'balance')) {
                $table->dropColumn('balance');
            }

            // 3. Drop received_amount column if exists
            if (Schema::hasColumn('rd_transactions', 'received_amount')) {
                $table->dropColumn('received_amount');
            }
        });
    }

    public function down(): void
    {
        Schema::table('rd_transactions', function (Blueprint $table) {

            // Reverse ENUM (back to original)
            $table->enum('payment_mode', [
                'cash',
                'onlineTr',
                'cheque',
                'savingAcc'
            ])->change();

            // Recreate deleted columns
            if (!Schema::hasColumn('rd_transactions', 'balance')) {
                $table->decimal('balance', 12, 2)->nullable();
            }

            if (!Schema::hasColumn('rd_transactions', 'received_amount')) {
                $table->decimal('received_amount', 12, 2)->nullable();
            }
        });
    }
};
