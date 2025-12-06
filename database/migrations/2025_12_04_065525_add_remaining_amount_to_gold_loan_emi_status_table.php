<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gold_loan_emi_status', function (Blueprint $table) {
            $table->decimal('remaining_amount', 12, 2)->default(0)->after('status');
        });
    }

    public function down()
    {
        Schema::table('gold_loan_emi_status', function (Blueprint $table) {
            $table->dropColumn('remaining_amount');
        });
    }

};
