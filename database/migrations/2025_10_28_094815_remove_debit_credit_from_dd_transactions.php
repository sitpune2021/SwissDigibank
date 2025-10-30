<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            $table->dropColumn(['debit', 'credit']);
        });
    }
 
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            $table->decimal('debit', 10, 2);
            $table->decimal('credit', 10, 2);
        });
    }
};
