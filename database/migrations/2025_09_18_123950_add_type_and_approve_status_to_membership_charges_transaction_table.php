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
        $table->boolean('approve_status')->default(0)->after('type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('membership_charges_transaction', function (Blueprint $table) {
            $table->dropColumn('approve_status');

        });
    }
};
