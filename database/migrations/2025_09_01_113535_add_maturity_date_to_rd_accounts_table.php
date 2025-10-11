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
        Schema::table('rd_accounts', function (Blueprint $table) {
            $table->decimal('principal', 15, 2)->after('payment_mode')->nullable();
            $table->decimal('total_interest', 15, 2)->after('principal')->nullable();
            $table->decimal('maturity_amount', 15, 2)->after('total_interest')->nullable();
            $table->date('maturity_date')->after('maturity_amount')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rd_accounts', function (Blueprint $table) {
            $table->dropColumn(['principal', 'total_interest', 'maturity_amount', 'maturity_date']);
        });
    }
};
