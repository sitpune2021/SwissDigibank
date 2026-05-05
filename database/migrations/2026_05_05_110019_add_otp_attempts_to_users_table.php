<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('otp_attempts')->default(0);
            $table->timestamp('otp_blocked_until')->nullable();
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['otp_attempts', 'otp_blocked_until']);
        });
    }

};
