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
        Schema::create('promotors', function (Blueprint $table) {
            $table->id();
            $table->integer('branch')->nullable();
            $table->string('member_no')->nullable()->unique();
            $table->date('enrollment_date')->nullable();
            $table->string('title')->nullable();
            $table->string('gender')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('last_name')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('occupation')->nullable();
            $table->string('father_name')->nullable();
            $table->string('mother_name')->nullable();
            $table->string('marital_status')->nullable();
            $table->string('member_religion')->nullable();
            $table->string('husband_wife_name')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile', 20)->nullable();
            $table->string('aadhaar_no', 20)->nullable();
            $table->string('voter_id_no')->nullable();
            $table->string('pan_no')->nullable();
            $table->string('ration_card_no')->nullable();
            $table->string('meter_no')->nullable();
            $table->string('ci_no')->nullable();
            $table->string('ci_relation')->nullable();
            $table->string('dl_no')->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_relation')->nullable();
            $table->string('nominee_mobile_no', 20)->nullable();
            $table->string('nominee_aadhaar_no', 20)->nullable();
            $table->string('nominee_voter_id_no')->nullable();
            $table->string('nominee_pan_no')->nullable();
            $table->text('nominee_address')->nullable();
            $table->boolean('sms')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotors');
    }
};
