<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('loan_applications', function (Blueprint $table) {

            if (!Schema::hasColumn('loan_applications', 'max_loan_amount')) {
                $table->decimal('max_loan_amount', 12, 2)->nullable();
            }

            if (!Schema::hasColumn('loan_applications', 'max_loan_limit')) {
                $table->decimal('max_loan_limit', 12, 2)->nullable();
            }

            if (!Schema::hasColumn('loan_applications', 'maximum_approvable_amount')) {
                $table->decimal('maximum_approvable_amount', 12, 2)->nullable();
            }

            if (!Schema::hasColumn('loan_applications', 'approved_loan_amount')) {
                $table->decimal('approved_loan_amount', 12, 2)->nullable();
            }
        });
    }

    public function down()
    {
        Schema::table('loan_applications', function (Blueprint $table) {

            if (Schema::hasColumn('loan_applications', 'max_loan_amount')) {
                $table->dropColumn('max_loan_amount');
            }

            if (Schema::hasColumn('loan_applications', 'max_loan_limit')) {
                $table->dropColumn('max_loan_limit');
            }

            if (Schema::hasColumn('loan_applications', 'maximum_approvable_amount')) {
                $table->dropColumn('maximum_approvable_amount');
            }

            if (Schema::hasColumn('loan_applications', 'approved_loan_amount')) {
                $table->dropColumn('approved_loan_amount');
            }
        });
    }
};
