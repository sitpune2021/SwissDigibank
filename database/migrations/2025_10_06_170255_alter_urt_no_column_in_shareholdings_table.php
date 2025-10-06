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
        Schema::table('shareholdings', function (Blueprint $table) {
                        $table->renameColumn('urt_no', 'utr_no');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shareholdings', function (Blueprint $table) {
            //
        });
    }
};
