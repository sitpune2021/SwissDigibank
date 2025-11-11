<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::table('mis_transactions', function (Blueprint $table) {
            $table->string('period_from')->nullable()->after('transaction_type');
            $table->string('period_to')->nullable()->after('period_from');
        });
    }

    public function down(): void
    {
        Schema::table('mis_transactions', function (Blueprint $table) {
            $table->dropColumn(['period_from', 'period_to']);
        });
    }
};
