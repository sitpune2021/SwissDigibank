<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gold_loan_emi_status', function (Blueprint $table) {
            $table->date('emi_due_date')->nullable()->after('paid_date');
        });
    }

    public function down()
    {
        Schema::table('gold_loan_emi_status', function (Blueprint $table) {
            $table->dropColumn('emi_due_date');
        });
    }
};
