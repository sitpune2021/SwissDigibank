<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('personal_schemes', function (Blueprint $table) {
            // Add new column for overdue type
            $table->string('overdue_type', 50)->nullable()->after('overdue_interest_rate')->comment('TYPE_1 or TYPE_2');
        });
    }

    public function down(): void
    {
        Schema::table('personal_schemes', function (Blueprint $table) {
            $table->dropColumn('overdue_type');
        });
    }
};
