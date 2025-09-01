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
            $table->decimal('total_deposit', 15, 2)->nullable()->change();
        });
        // Remove the default value
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
