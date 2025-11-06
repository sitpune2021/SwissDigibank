<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('vehical_applications', function (Blueprint $table) {
            $table->tinyInteger('status')->default(0)->change();
        });
    }

    public function down()
    {
        Schema::table('vehical_applications', function (Blueprint $table) {
            $table->tinyInteger('status')->default(null)->change();
        });
    }
};
