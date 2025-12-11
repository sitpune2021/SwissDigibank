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
        Schema::table('fd_accounts', function (Blueprint $table) {

            $table->unsignedBigInteger('saving_account_id')->nullable()->after('member_id');
            $table->foreign('saving_account_id')
                ->references('id')
                ->on('accounts')
                ->onDelete('set null');

            $table->string('link_status')->default('unlink')->after('saving_account_id');
        });
    }

    public function down(): void
    {
        Schema::table('fd_accounts', function (Blueprint $table) {

            $table->dropForeign(['saving_account_id']);
            $table->dropColumn(['saving_account_id', 'link_status']);
        });
    }
};
