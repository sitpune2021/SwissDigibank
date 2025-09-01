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
        Schema::table('dds_accounts', function (Blueprint $table) {
            $table->decimal('total_deposit', 15, 2)->after('id'); // Adds 'total_deposit' column
            $table->decimal('interest_earned', 15, 2)->after('total_deposit'); // Adds 'interest_earned' column
            $table->decimal('bonus', 15, 2)->default(0)->after('interest_earned'); // Adds 'bonus' column
            $table->decimal('maturity', 15, 2)->after('bonus'); // Adds 'maturity' column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dds_accounts', function (Blueprint $table) {
            //
        });
    }
};
