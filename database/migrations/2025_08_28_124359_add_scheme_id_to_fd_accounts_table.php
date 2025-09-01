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
        Schema::table('fd_accounts', function (Blueprint $table) {
            if (!Schema::hasColumn('fd_accounts', 'scheme_id')) {
                $table->unsignedBigInteger('scheme_id')->after('branch_id')->nullable();

                $table->foreign('scheme_id')
                    ->references('id')
                    ->on('fd_schemes')
                    ->onDelete('cascade');
            }
        });
    }

    public function down(): void
    {
        Schema::table('fd_accounts', function (Blueprint $table) {
            if (Schema::hasColumn('fd_accounts', 'scheme_id')) {
                $table->dropForeign(['scheme_id']); // drop constraint
                $table->dropColumn('scheme_id');    // drop column
            }
        });
    }
};
