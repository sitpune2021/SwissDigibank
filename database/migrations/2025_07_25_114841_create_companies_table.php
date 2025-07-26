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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');

            $table->string('company_website')->nullable();
            $table->string('company_name');
            $table->string('short_name');
            $table->text('about_company');

            $table->string('address_line1');
            $table->string('address_line2')->nullable();
            $table->string('city');
            $table->unsignedBigInteger('state');
            $table->string('pincode');
            $table->string('country');

            $table->string('mobile_no');
            $table->string('landline_no')->nullable();
            $table->string('contact_email');

            $table->string('cin_no');
            $table->string('pan_no')->nullable();
            $table->string('tan_no')->nullable();
            $table->string('gst_no')->nullable();

            $table->string('company_category');
            $table->string('company_class');
            $table->date('incorporation_date');
            $table->unsignedBigInteger('incorporation_state');
            $table->string('incorporation_country');

            $table->decimal('authorized_capital', 15, 2);
            $table->decimal('paid_up_capital', 15, 2);
            
            $table->softDeletes();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state')->references('id')->on('states')->onDelete('cascade');
            $table->foreign('incorporation_state')->references('id')->on('states')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};
