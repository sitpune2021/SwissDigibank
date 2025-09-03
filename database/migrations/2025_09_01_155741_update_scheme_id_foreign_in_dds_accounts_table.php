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
        Schema::table('dds_accounts', function (Blueprint $table) {
             $table->dropForeign(['scheme_id']);

            // नवीन rdschemes शी जोडून द्या
            $table->foreign('scheme_id')
                ->references('id')->on('rdschemes')
                ->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dds_accounts', function (Blueprint $table) {
                        $table->dropForeign(['scheme_id']);

            $table->foreign('scheme_id')
                ->references('id')->on('schemes')
                ->onDelete('cascade');

        });
    }
};
