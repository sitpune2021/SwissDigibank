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
    Schema::table('locker_lists', function (Blueprint $table) {
        $table->string('member_id')->nullable()->change();
         $table->text('assign_date')->nullable()->change();
        $table->text('release_date')->nullable()->change();
    });
}

public function down()
{
    Schema::table('locker_lists', function (Blueprint $table) {
        $table->integer('member_id')->nullable()->change();
    });
}


};
