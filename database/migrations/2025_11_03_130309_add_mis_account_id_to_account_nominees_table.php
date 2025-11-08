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
             $table->unsignedBigInteger('mis_account_id')->after('id')->nullable();

            // Add foreign key constraint
            $table->foreign('mis_account_id')
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
        Schema::table('account_nominees', function (Blueprint $table) {
            // Drop foreign key first, then the column
            $table->dropForeign(['mis_account_id']);
            $table->dropColumn('mis_account_id');
        });
    }
};
