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
        Schema::table('promotors', function (Blueprint $table) {
            $table->unsignedBigInteger('member_id')->nullable()->after('branch_id');
            $table->unsignedBigInteger('account_id')->nullable()->after('member_id');
            $table->unsignedBigInteger('bank_id')->nullable()->after('account_id');

            // Add foreign keys
            $table->foreign('member_id')
                ->references('id')->on('members')
                ->onDelete('set null');

            $table->foreign('account_id')
                ->references('id')->on('accounts')
                ->onDelete('set null');

            $table->foreign('bank_id')
                ->references('id')->on('banks')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotors', function (Blueprint $table) {
                        // Drop foreign keys first
            $table->dropForeign(['member_id']);
            $table->dropForeign(['account_id']);
            $table->dropForeign(['bank_id']);

            // Drop columns
            $table->dropColumn(['member_id', 'account_id', 'bank_id']);

        });
    }
};
