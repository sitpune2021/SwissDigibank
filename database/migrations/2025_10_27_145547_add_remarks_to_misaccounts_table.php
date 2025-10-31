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
        Schema::table('misaccounts', function (Blueprint $table) {
            if (!Schema::hasColumn('misaccounts', 'remarks')) {
                $table->string('remarks')->nullable()->after('status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->dropColumn('remarks');
        });
    }
};
