<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('mis_transactions', function (Blueprint $table) {
            // monetary fields
            $table->decimal('interest', 15, 2)->default(0)->after('amount');
            $table->decimal('tds', 15, 2)->default(0)->after('interest');
            $table->decimal('net_interest', 15, 2)->default(0)->after('tds');

            // date and processed flag
            $table->date('due_date')->nullable()->after('transaction_date');
            $table->boolean('processed')->default(0)->after('status');
        });
    }

    public function down(): void
    {
        Schema::table('mis_transactions', function (Blueprint $table) {
            $table->dropColumn(['interest', 'tds', 'net_interest', 'processed', 'due_date']);
        });
    }
};
