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
                    $table->dropForeign(['account_id']);
        // then make it nullable
        $table->unsignedBigInteger('account_id')->nullable()->change();
        // if you still want FK but nullable, recreate FK:
        $table->foreign('account_id')->references('id')->on('accounts')->onDelete('set null');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            //
        });
    }
};
