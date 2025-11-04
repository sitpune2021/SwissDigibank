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
        Schema::table('membership_charges_transaction', function (Blueprint $table) {
            $table->decimal('net_fee_to_collect', 10, 2)->nullable()->change();
            $table->enum('charges_pay_mode', ['cash', 'online', 'cheque', 'saving'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_charges_transaction', function (Blueprint $table) {
            $table->dropColumn('membership_fee', 'charges_pay_mode');
        });
    }
};
