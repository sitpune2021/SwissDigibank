<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('fixed_loan_applications', function (Blueprint $table) {

            // EMI / Loan related
            $table->integer('status')->nullable()->after('id');
            $table->integer('tenure_value')->nullable()->after('credit_period');
            $table->decimal('loan_amount', 15, 2)->nullable()->after('tenure_value');
            $table->string('emi_collection', 50)->nullable()->after('loan_amount');
            $table->decimal('emi_amount', 15, 2)->nullable()->after('emi_collection');
           
        });
    }

    public function down(): void
    {
        Schema::table('fixed_loan_applications', function (Blueprint $table) {
            $table->dropColumn([
                'status',
                'tenure_value',
                'loan_amount',
                'emi_collection',
                'emi_amount',
            ]);
        });
    }
};
