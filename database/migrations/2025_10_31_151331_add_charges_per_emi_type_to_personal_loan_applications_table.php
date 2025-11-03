<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_loan_applications', function (Blueprint $table) {
            $table->enum('charges_per_emi_type', ['ON EMI', 'ON PRINCIPAL'])
                  ->default('ON EMI')
                  ->after('credit_period');
        });
    }

    public function down(): void
    {
        Schema::table('personal_loan_applications', function (Blueprint $table) {
            $table->dropColumn('charges_per_emi_type');
        });
    }
};
