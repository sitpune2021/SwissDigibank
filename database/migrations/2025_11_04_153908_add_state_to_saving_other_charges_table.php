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
        Schema::table('saving_other_charges', function (Blueprint $table) {
            $table->enum('state', ['PARTIAL_WAIVED', 'WAIVED'])
                ->nullable()
                ->after('status'); // you can change position if needed

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('saving_other_charges', function (Blueprint $table) {
            $table->dropColumn('state');
        });
    }
};
