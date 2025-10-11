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
        Schema::table('mis_transactions', function (Blueprint $table) {

            if (!Schema::hasColumn('mis_transactions', 'misaccount_id')) {
                $table->unsignedBigInteger('misaccount_id');
            }

            $table->foreign('misaccount_id')
                ->references('id')
                ->on('misaccounts')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mis_transactions', function (Blueprint $table) {
            $table->dropForeign(['misaccount_id']);
        });
    }
};
