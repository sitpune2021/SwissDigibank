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
        Schema::table('kyc_and_nominees', function (Blueprint $table) {
         $table->date('member_info_dob')->nullable()->after('member_kyc_pan_no');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kyc_and_nominees', function (Blueprint $table) {
                    $table->dropColumn('member_info_dob');

        });
    }
};
