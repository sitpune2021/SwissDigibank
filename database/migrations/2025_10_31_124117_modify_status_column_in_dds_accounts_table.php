<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE dds_accounts
            MODIFY status TINYINT(1) DEFAULT 0 COMMENT '0 = Pending, 1 = Approved, 2 = Rejected';
        ");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("
            ALTER TABLE dds_accounts
            MODIFY status TINYINT(1) DEFAULT 0 COMMENT 'Previous status column definition';
        ");
    }
};
