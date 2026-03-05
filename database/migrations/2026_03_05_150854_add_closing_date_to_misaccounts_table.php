<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {

            $table->date('closing_date')
                  ->nullable()
                  ->after('maturity_date'); // change position if needed
        });
    }

    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->dropColumn('closing_date');
        });
    }
};