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
        Schema::table('share_transfer', function (Blueprint $table) {
            $table->unsignedInteger('from_share_no')->nullable()->after('shares');
            $table->unsignedInteger('to_share_no')->nullable()->after('from_share_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('share_transfer', function (Blueprint $table) {
            $table->dropColumn('from_share_no');
            $table->dropColumn('to_share_no');
        });
    }
};
