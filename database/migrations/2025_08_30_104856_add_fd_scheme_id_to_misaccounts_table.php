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
           $table->unsignedBigInteger('fd_scheme_id')->nullable()->after('branch_id');

            // Add foreign key constraint
            $table->foreign('fd_scheme_id')
                  ->references('id')
                  ->on('fd_schemes')
                  ->onDelete('set null'); // optional: set null if fd_scheme deleted
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
              $table->dropForeign(['fd_scheme_id']);
            $table->dropColumn('fd_scheme_id');
        });
    }
};
