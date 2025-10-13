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
        Schema::table('dd_transactions', function (Blueprint $table) {
                    $table->string('remarks')->nullable()->after('pay_mode');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            //
        });
    }
};
