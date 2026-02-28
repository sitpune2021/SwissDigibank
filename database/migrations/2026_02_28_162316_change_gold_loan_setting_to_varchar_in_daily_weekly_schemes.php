<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('daily_weekly_schemes', function (Blueprint $table) {
            $table->string('gold_loan_setting', 50)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('daily_weekly_schemes', function (Blueprint $table) {
            $table->enum('gold_loan_setting', [
                'daily',
                'weekly',
                'bi_weekly',
                '4_weekly',
                'monthly'
            ])->nullable()->change();
        });
    }
};
