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
            if (!Schema::hasColumn('fd_accounts', 'joint_member_id')) {
                $table->unsignedBigInteger('joint_member_id')->nullable()->after('member_id');
                $table->foreign('joint_member_id')->references('id')->on('members')->onDelete('set null');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fd_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('fd_accounts', 'joint_member_id')) {
                $table->dropForeign(['joint_member_id']);
                $table->dropColumn('joint_member_id');
            }
        });
    }
};
