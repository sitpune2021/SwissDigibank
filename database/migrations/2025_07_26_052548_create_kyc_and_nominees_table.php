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
        Schema::create('kyc_and_nominees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');
                    // KYC fields
        $table->string('member_kyc_aadhaar_no')->nullable();
        $table->string('member_kyc_voter_id_no')->nullable();
        $table->string('member_kyc_pan_no')->nullable();
        $table->string('member_kyc_ration_card_no')->nullable();
        $table->string('member_kyc_meter_no')->nullable();
        $table->string('member_kyc_ci_no')->nullable();
        $table->string('member_kyc_ci_relation')->nullable();
        $table->string('member_kyc_dl_no')->nullable();
        $table->string('member_kyc_passport_no')->nullable();

        // KYC documents
        $table->string('member_kyc_photo')->nullable();
        $table->string('member_kyc_signature')->nullable();
        $table->string('member_kyc_id_proof')->nullable();
        $table->string('member_kyc_id_proof_back')->nullable();
        $table->string('member_kyc_address_proof')->nullable();
        $table->string('member_kyc_address_proof_back')->nullable();
        $table->string('member_kyc_pan_number')->nullable();

        // Nominee fields
        $table->string('nominee_name')->nullable();
        $table->string('nominee_relation')->nullable();
        $table->string('nominee_mobile_no')->nullable();
        $table->string('nominee_gender')->nullable();
        $table->string('nominee_dob');
        $table->string('nominee_aadhaar_no')->nullable();
        $table->string('nominee_voter_id_no')->nullable();
        $table->string('nominee_pan_no')->nullable();
        $table->string('nominee_ration_card_no')->nullable();
        $table->string('nominee_address')->nullable();

        // Extra
        $table->boolean('extra_sms')->default(false);
        $table->date('charges_transaction_date');
        $table->decimal('charges_membership_fee', 10, 2)->nullable();
        $table->decimal('charges_net_fee', 10, 2);
        $table->string('charges_remarks')->nullable();
        $table->string('charges_pay_mode');
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_and_nominees');
    }
};
