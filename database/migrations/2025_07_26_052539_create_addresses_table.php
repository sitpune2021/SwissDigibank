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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('member_id');

            $table->string('member_address_line_1')->nullable();
            $table->string('member_address_line_2')->nullable();
            $table->string('member_address_para')->nullable();
            $table->string('member_address_ward')->nullable();
            $table->string('member_address_panchayat')->nullable();
            $table->string('member_address_area')->nullable();
            $table->string('member_address_landmark')->nullable();
            $table->string('member_address_city_district')->nullable();
            $table->unsignedBigInteger('member_address_state');
            $table->integer('member_address_pincode');
            $table->string('member_address_country');
            $table->string('member_address_address')->nullable();

            $table->string('member_perm_address_city');
            $table->unsignedBigInteger('member_perm_address_state');
            $table->integer('member_perm_address_pincode');

            $table->string('member_gps_location_latitude');
            $table->decimal('member_gps_location_longitude', 10, 6);
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('member_address_state')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('member_perm_address_state')->references('id')->on('states')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
