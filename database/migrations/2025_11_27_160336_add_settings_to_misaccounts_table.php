<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->boolean('sms')->default(0)->after('remarks');
            $table->boolean('tds')->default(0)->after('sms');
            $table->boolean('hold')->default(0)->after('tds');
        });
    }

    public function down()
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->dropColumn(['sms', 'tds', 'hold']);
        });
    }
};
