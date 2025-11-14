<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('account_nominees', function (Blueprint $table) {
            if (!Schema::hasColumn('account_nominees', 'mis_account_id')) {

                // Add the column
                $table->unsignedBigInteger('mis_account_id')
                    ->after('id')
                    ->nullable();

                // Add foreign key
                $table->foreign('mis_account_id')
                    ->references('id')
                    ->on('misaccounts')
                    ->onDelete('cascade');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('account_nominees', function (Blueprint $table) {
            if (Schema::hasColumn('account_nominees', 'mis_account_id')) {

                $foreignKeys = DB::select("
                SELECT CONSTRAINT_NAME 
                FROM information_schema.KEY_COLUMN_USAGE
                WHERE TABLE_NAME = 'account_nominees'
                  AND COLUMN_NAME = 'mis_account_id'
                  AND CONSTRAINT_NAME != 'PRIMARY';
            ");

                if (!empty($foreignKeys)) {
                    $table->dropForeign($foreignKeys[0]->CONSTRAINT_NAME);
                }

                $table->dropColumn('mis_account_id');
            }
        });
    }
};
