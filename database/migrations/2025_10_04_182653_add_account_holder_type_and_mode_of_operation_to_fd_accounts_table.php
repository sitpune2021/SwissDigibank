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
            $table->string('account_holder_type')->nullable()->after('payment_mode');
            $table->string('mode_of_operation')->nullable()->after('account_holder_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('fd_accounts', function (Blueprint $table) {
            $table->dropColumn(['account_holder_type', 'mode_of_operation']);
        });
    }
};
