<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->string('payment_mode')->nullable()->after('id');
        });

        Schema::table('dds_accounts', function (Blueprint $table) {
            $table->string('payment_mode')->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->dropColumn('payment_mode');
        });

        Schema::table('dds_accounts', function (Blueprint $table) {
            $table->dropColumn('payment_mode');
        });
    }
};
