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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            
                $table->string('membership_type');
                $table->string('general_advisor_staff');
                $table->string('general_group');
                $table->unsignedBigInteger('general_branch');
                $table->string('general_enrollment_date');

                $table->string('member_info_title');
                $table->string('member_info_gender');
                $table->string('member_info_first_name');
                $table->string('member_info_middle_name')->nullable();
                $table->string('member_info_last_name');
                $table->string('member_info_dob');
                $table->string('member_info_qualification')->nullable();
                $table->string('member_info_occupation')->nullable();
                $table->decimal('member_info_monthly_income', 10, 2)->nullable();
                $table->string('member_info_old_member_no')->nullable();
                $table->string('member_info_father_name')->nullable();
                $table->string('member_info_mother_name')->nullable();
                $table->string('member_info_spouse_name')->nullable();
                $table->string('member_info_spouse_dob');
                $table->string('member_info_mobile_no');
                $table->string('member_info_collection_time')->nullable();
                $table->string('member_info_marital_status')->nullable();
                $table->string('member_info_religion')->nullable();
                $table->string('member_info_email')->nullable();
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('general_branch')->references('id')->on('branches')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
