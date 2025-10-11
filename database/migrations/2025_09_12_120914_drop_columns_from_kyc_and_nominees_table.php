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
        Schema::table('kyc_and_nominees', function (Blueprint $table) {

            $table->dropColumn([
                'charges_transaction_date',
                'charges_membership_fee',
                'charges_net_fee',
                'charges_remarks',
                'charges_pay_mode',
                'transfer_date',
                'online_utr_no',
                'transfer_mode',
                'cheque_bank_name',
                'cheque_no',
                'cheque_date',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kyc_and_nominees', function (Blueprint $table) {
            //
        });
    }
};
