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
            $table->unsignedBigInteger('bank_id')->nullable()->after('cheque_date');

            $table->unsignedBigInteger('saving_account_id')->nullable()->after('bank_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_charges_transaction', function (Blueprint $table) {
            //
        });
    }
};
