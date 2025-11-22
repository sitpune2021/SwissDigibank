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
        Schema::table('account_nominees', function (Blueprint $table) {
            $table->unsignedBigInteger('dds_account_id')->nullable()->after('rd_account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_nominees', function (Blueprint $table) {
            $table->dropColumn('dds_account_id');
        });
    }
};
