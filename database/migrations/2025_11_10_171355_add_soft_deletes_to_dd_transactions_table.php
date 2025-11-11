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
        Schema::table('dd_transactions', function (Blueprint $table) {
            $table->softDeletes()->after('updated_at');
            $table->decimal('amount', 15, 2)->after('saving_account_id')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            $table->dropSoftDeletes(); // drops deleted_at column
            $table->decimal('amount', 15, 2)->change();
        });
    }
};
