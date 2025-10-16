<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('mortgage_loan_applications')) {
            Schema::table('mortgage_loan_applications', function ($table) {
                if (!Schema::hasColumn('mortgage_loan_applications', 'status')) {
                    $table->string('status')->default('0')->after('id');
                }
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('mortgage_loan_applications')) {
            Schema::table('mortgage_loan_applications', function ($table) {
                if (Schema::hasColumn('mortgage_loan_applications', 'status')) {
                    $table->dropColumn('status');
                }
            });
        }
    }
};
