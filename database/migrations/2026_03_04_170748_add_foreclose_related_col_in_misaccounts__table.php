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
        Schema::table('misaccounts', function (Blueprint $table) {

            $table->date('foreclose_request_date')->nullable()->after('maturity_amount');

            $table->decimal('foreclose_interest_left', 15,2)->default(0)->after('foreclose_request_date');
            $table->decimal('foreclose_tds', 15,2)->default(0)->after('foreclose_interest_left');
            $table->decimal('foreclose_reverse_interest', 15,2)->default(0)->after('foreclose_tds');

            $table->decimal('foreclose_penal_charges', 15,2)->default(0)->after('foreclose_reverse_interest');
            $table->decimal('foreclose_cancellation_charges', 15,2)->default(0)->after('foreclose_penal_charges');

            $table->decimal('foreclose_total_amount', 15,2)->default(0)->after('foreclose_cancellation_charges');
            $table->decimal('foreclose_rounding', 10,2)->default(0)->after('foreclose_total_amount');
            $table->decimal('foreclose_final_amount', 15,2)->default(0)->after('foreclose_rounding');

            $table->tinyInteger('foreclose_status')->default(0)->after('foreclose_final_amount');
            /*
                0 = none
                1 = request raised
                2 = approved
                3 = rejected
            */
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {

            $table->dropColumn([
                'foreclose_request_date',
                'foreclose_interest_left',
                'foreclose_tds',
                'foreclose_reverse_interest',
                'foreclose_penal_charges',
                'foreclose_cancellation_charges',
                'foreclose_total_amount',
                'foreclose_rounding',
                'foreclose_final_amount',
                'foreclose_status'
            ]);

        });
    }
};