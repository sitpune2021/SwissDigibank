<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('daily_weekly_applications', function (Blueprint $table) {
        $table->integer('tenure_value')->nullable();
        $table->decimal('loan_amount', 10, 2)->nullable();
        $table->string('emi_collection')->nullable();
        $table->decimal('emi_amount', 10, 2)->nullable();
        $table->decimal('processing_fee', 10, 2)->nullable();
        $table->decimal('stamp_duty', 10, 2)->nullable();
        $table->decimal('fitness_fee', 10, 2)->nullable();
        $table->decimal('insurance_fee', 10, 2)->nullable();
    });
}

public function down()
{
    Schema::table('daily_weekly_applications', function (Blueprint $table) {
        $table->dropColumn([
            'tenure_value',
            'loan_amount',
            'emi_collection',
            'emi_amount',
            'processing_fee',
            'stamp_duty',
            'fitness_fee',
            'insurance_fee'
        ]);
    });
}

};
