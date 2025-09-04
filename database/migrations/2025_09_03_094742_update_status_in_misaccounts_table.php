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
                 $table->integer('status')
              ->default(0)
              ->comment('0 = pending, 1 = approve, 2 = notapprove');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
          $table->dropColumn('status');
        });
    }
};
