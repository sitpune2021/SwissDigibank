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
                    $table->dropColumn('member_kyc_photo');
        $table->dropColumn('member_kyc_signature');
        $table->dropColumn('member_kyc_id_proof');
        $table->dropColumn('member_kyc_id_proof_back');
        $table->dropColumn('member_kyc_address_proof');
        $table->dropColumn('member_kyc_address_proof_back');
        $table->dropColumn('member_kyc_pan_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('kyc_and_nominees', function (Blueprint $table) {
                    $table->string('member_kyc_photo')->nullable();
        $table->string('member_kyc_signature')->nullable();
        $table->string('member_kyc_id_proof')->nullable();
        $table->string('member_kyc_id_proof_back')->nullable();
        $table->string('member_kyc_address_proof')->nullable();
        $table->string('member_kyc_address_proof_back')->nullable();
        $table->string('member_kyc_pan_number')->nullable();
        });
    }
};
