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
            $table->unsignedBigInteger('fd_account_id')->nullable()->after('account_id');

            $table->foreign('fd_account_id')
                ->references('id')
                ->on('fd_accounts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_nominees', function (Blueprint $table) {
            $table->dropForeign(['fd_account_id']);
            $table->dropColumn('fd_account_id');
        });
    }
};
