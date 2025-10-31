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
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->string('mis_account_no')->nullable()->after('id')->comment('Unique MIS account number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->dropColumn('mis_account_no');
        });
    }
};
