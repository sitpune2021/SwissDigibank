<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('fd_transactions', function (Blueprint $table) {
            $table->tinyInteger('transaction_type')
                ->comment('1 = Credit, 0 = Debit')
                ->after('transaction_date');
        });
    }

    public function down()
    {
        Schema::table('fd_transactions', function (Blueprint $table) {
            $table->dropColumn('transaction_type');
        });
    }
};
