<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('member_other_charges', function (Blueprint $table) {
                    DB::statement("ALTER TABLE member_other_charges MODIFY credited_in_account TINYINT(1) DEFAULT 0");

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_other_charges', function (Blueprint $table) {
                    DB::statement("ALTER TABLE member_other_charges MODIFY credited_in_account VARCHAR(255) NULL");

        });
    }
};
