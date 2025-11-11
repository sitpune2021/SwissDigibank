<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::table('gold_loan_schemes', function (Blueprint $table) {
            $table->string('overdue_interest_type')->nullable()->after('overdue_interest_rate');
        });
    }

    public function down()
    {
        Schema::table('gold_loan_schemes', function (Blueprint $table) {
            $table->dropColumn('overdue_interest_type');
        });
    }

};
