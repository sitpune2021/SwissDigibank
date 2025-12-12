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
    Schema::table('fd_transactions', function (Blueprint $table) {
        $table->dropColumn('transaction_type');
    });
}

public function down()
{
    Schema::table('fd_transactions', function (Blueprint $table) {
        $table->string('transaction_type')->nullable();
    });
}

};
