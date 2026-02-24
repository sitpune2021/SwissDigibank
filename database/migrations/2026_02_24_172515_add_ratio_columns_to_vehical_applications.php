<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('vehical_applications', function (Blueprint $table) {
            $table->enum('ratio_enabled', ['Yes', 'No'])
                ->default('No')
                ->after('approved_loan_amount');

            $table->integer('ratio_first_emi')
                ->nullable()
                ->after('ratio_enabled');

            $table->decimal('ratio_first_percentage', 5, 2)
                ->nullable()
                ->after('ratio_first_emi');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehical_applications', function (Blueprint $table) {
            $table->dropColumn([
                'ratio_enabled',
                'ratio_first_emi',
                'ratio_first_percentage'
            ]);
        });
    }
};
