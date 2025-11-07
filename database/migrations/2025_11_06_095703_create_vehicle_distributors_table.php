<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('vehicle_distributors', function (Blueprint $table) {
            $table->id();
            $table->string('distributor_name');
            $table->string('distributor_code')->unique();
            $table->string('distributor_type')->nullable();
            $table->string('contact_no', 15);
            $table->string('email')->unique();
            $table->text('address');
            $table->string('city');
            $table->string('state');
            $table->string('country')->default('India');
            $table->string('pincode', 10);
            $table->string('gst_no')->nullable();
            $table->string('license_no')->nullable();
            $table->boolean('active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('vehicle_distributors');
    }
};
