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
            $table->string('collected_by')->nullable()->after('amount');
            $table->string('t_receipt')->nullable()->after('collected_by');
            $table->string('member_sign')->nullable()->after('t_receipt');
            $table->string('member_photo')->nullable()->after('member_sign');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            //
        });
    }
};
