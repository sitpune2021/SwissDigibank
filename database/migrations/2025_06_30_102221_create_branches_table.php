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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('branch_name')->nullable();
            $table->string('branch_code')->unique();
            $table->date('open_date');
            $table->string('ifsc_code');
            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->unsignedBigInteger('state');
            $table->string('pincode');
            $table->string('country');
            $table->string('contact_email')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('landline_no')->nullable();
            $table->string('gst_no')->nullable();
            $table->enum('disable_recharge', ['yes', 'no']);
            $table->enum('disable_neft', ['yes', 'no']);
            $table->string('active')->nullable()->default('Yes');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
