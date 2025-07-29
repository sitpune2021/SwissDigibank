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
       Schema::table('addresses', function (Blueprint $table) {
            // First, drop the foreign key constraint
            $table->dropForeign(['member_perm_address_state']);

            // Then make the column nullable
            $table->unsignedBigInteger('member_perm_address_state')->nullable()->change();

            // Re-add the foreign key constraint (now it allows NULL)
            $table->foreign('member_perm_address_state')
                  ->references('id')->on('states')
                  ->onDelete('set null'); // Optional, useful if the related state is deleted
        });
    }

    public function down()
    {
        Schema::table('addresses', function (Blueprint $table) {
            $table->dropForeign(['member_perm_address_state']);
            $table->unsignedBigInteger('member_perm_address_state')->nullable(false)->change();
            $table->foreign('member_perm_address_state')
                  ->references('id')->on('states');
        });
    }
};
