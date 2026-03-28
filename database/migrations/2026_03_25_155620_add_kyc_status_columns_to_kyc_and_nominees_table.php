<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('kyc_and_nominees', function (Blueprint $table) {

            $table->boolean('pan_verified')->default(0)->after('member_kyc_pan_no');
            $table->boolean('aadhaar_submitted')->default(0)->after('pan_verified');
            $table->boolean('otp_verified')->default(0)->after('aadhaar_submitted');
            $table->boolean('selfie_uploaded')->default(0)->after('otp_verified');

            $table->string('aadhaar_ref_id')->nullable()->after('selfie_uploaded');
        });
    }

    public function down(): void
    {
        Schema::table('kyc_and_nominees', function (Blueprint $table) {

            $table->dropColumn([
                'pan_verified',
                'aadhaar_submitted',
                'otp_verified',
                'selfie_uploaded',
                'aadhaar_ref_id'
            ]);
        });
    }
};
