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
            $table->string('transaction_type')->nullable()->after('transaction_date');
            $table->date('paid_on')->nullable()->after('transaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fd_transactions', function (Blueprint $table) {
            $table->dropColumn(['paid_on', 'transaction_type']);
        });
    }
};
