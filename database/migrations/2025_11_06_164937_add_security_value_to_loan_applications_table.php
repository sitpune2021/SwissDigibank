<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // ✅ Add column only if it does NOT exist
        if (!Schema::hasColumn('loan_applications', 'security_value')) {
            Schema::table('loan_applications', function (Blueprint $table) {
                $table->decimal('security_value', 10, 2)
                      ->nullable()
                      ->after('collect_advance_processing_fee');
            });
        }
    }

    public function down(): void
    {
        // ✅ Drop column only if it exists
        if (Schema::hasColumn('loan_applications', 'security_value')) {
            Schema::table('loan_applications', function (Blueprint $table) {
                $table->dropColumn('security_value');
            });
        }
    }
};
