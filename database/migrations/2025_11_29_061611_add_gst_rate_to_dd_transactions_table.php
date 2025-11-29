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
        Schema::table('dd_transactions', function (Blueprint $table) {
            $table->decimal('gst_rate', 5, 2)->default(18.00)->after('amount');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            $table->dropColumn('gst_rate');
        });
    }
};
