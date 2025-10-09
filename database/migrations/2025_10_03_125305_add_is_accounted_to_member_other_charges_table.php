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
        Schema::table('member_other_charges', function (Blueprint $table) {
            $table->boolean('is_accounted')->default(false)->after('status'); // or after any relevant column

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_other_charges', function (Blueprint $table) {
            $table->dropColumn('is_accounted');
        });
    }
};
