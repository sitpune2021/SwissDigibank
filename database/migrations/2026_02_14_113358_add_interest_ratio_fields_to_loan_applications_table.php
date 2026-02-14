<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loan_applications', function (Blueprint $table) {

            // Interest configuration
            $table->string('interest_as_emi')
                  ->nullable()
                  ->after('emi_collection');

            $table->string('interest_as_first')
                  ->nullable()
                  ->after('interest_as_emi');

            // Ratio EMI settings
            $table->string('ratio_enabled')
                  ->default('No')
                  ->after('interest_as_first');

            $table->integer('ratio_first_emi')
                  ->nullable()
                  ->after('ratio_enabled');

            $table->decimal('ratio_first_percentage', 5, 2)
                  ->nullable()
                  ->after('ratio_first_emi');
            
                  $table->decimal('applied_interest',10,2)
                  ->nullable()
                  ->after('approved_loan_amount');
        });
    }

    public function down(): void
    {
        Schema::table('loan_applications', function (Blueprint $table) {
            $table->dropColumn([
                'interest_as_emi',
                'interest_as_first',
                'ratio_enabled',
                'ratio_first_emi',
                'ratio_first_percentage',
                'applied_interest',
            ]);
        });
    }
};