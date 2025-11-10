<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('locker_lists', function (Blueprint $table) {
            $table->date('assign_date')->nullable()->after('assigned');
            $table->date('release_date')->nullable()->after('assign_date');
        });
    }

    public function down()
    {
        Schema::table('locker_lists', function (Blueprint $table) {
            $table->dropColumn(['assign_date', 'release_date']);
        });
    }
};
