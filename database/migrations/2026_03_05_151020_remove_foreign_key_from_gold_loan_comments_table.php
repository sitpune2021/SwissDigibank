<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('gold_loan_comments', function (Blueprint $table) {
            $table->dropForeign(['gold_loan_id']);
        });
    }

    public function down()
    {
        Schema::table('gold_loan_comments', function (Blueprint $table) {
            $table->foreign('gold_loan_id')
                ->references('id')
                ->on('gold_loan_disbursements')
                ->onDelete('cascade');
        });
    }
};
