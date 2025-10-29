<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('daily_weekly_applications', function (Blueprint $table) {
            // Integer type with default value 0
            $table->tinyInteger('status')->default(0)->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('daily_weekly_applications', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
