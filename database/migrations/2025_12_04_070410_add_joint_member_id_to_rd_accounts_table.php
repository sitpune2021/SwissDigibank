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
        Schema::table('rd_accounts', function (Blueprint $table) {
          $table->unsignedBigInteger('joint_member_id')
                  ->nullable()
                  ->after('member_id');

        $table->foreign('joint_member_id')->references('id')->on('members')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rd_accounts', function (Blueprint $table) {
            $table->dropColumn('joint_member_id');
        });
    }
};
