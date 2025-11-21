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
            $table->boolean('is_linked')
                ->default(0)
                ->after('saving_account_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            $table->dropColumn('is_linked');
        });
    }
};
