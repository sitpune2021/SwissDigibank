<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('rd_accounts', function (Blueprint $table) {
            $table->renameColumn('scheme', 'scheme_id');
        });
    }

    public function down(): void
    {
        Schema::table('rd_accounts', function (Blueprint $table) {
            $table->renameColumn('scheme_id', 'scheme');
        });
    }
};
