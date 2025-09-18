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
            $table->unsignedBigInteger('rd_account_id')->after('fd_account_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_nominees', function (Blueprint $table) {
            $table->dropColumn('rd_account_id');
        });
    }
};
