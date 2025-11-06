<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('vehical_applications', function (Blueprint $table) {
            $table->unsignedBigInteger('distributor_id')->nullable()->after('credited');
            $table->string('vehicle_type')->nullable();
            $table->string('vehicle_segment')->nullable();
            $table->string('vehicle_category')->nullable();
            $table->string('vehicle_brand')->nullable();
            $table->string('vehicle_model')->nullable();
            $table->string('vehicle_color')->nullable();
            $table->string('manufacture_year')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('chassis_no')->nullable();
            $table->string('engine_no')->nullable();
            $table->string('registration_no')->nullable();
            $table->date('vehicle_delivery_date')->nullable();
            $table->string('insurance_policy_no')->nullable();
            $table->date('insurance_expiry_date')->nullable();
            $table->string('motor_power')->nullable();
            $table->string('battery_capacity')->nullable();
            $table->string('battery_warranty')->nullable();
            $table->decimal('current_valuation', 15, 2)->nullable();
            $table->decimal('vehicle_price', 15, 2)->nullable();
            $table->decimal('down_payment', 15, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('vehical_applications', function (Blueprint $table) {
            $table->dropColumn([
                'distributor_id',
                'vehicle_type',
                'vehicle_segment',
                'vehicle_category',
                'vehicle_brand',
                'vehicle_model',
                'vehicle_color',
                'manufacture_year',
                'vehicle_no',
                'chassis_no',
                'engine_no',
                'registration_no',
                'vehicle_delivery_date',
                'insurance_policy_no',
                'insurance_expiry_date',
                'motor_power',
                'battery_capacity',
                'battery_warranty',
                'current_valuation',
                'vehicle_price',
                'down_payment',
            ]);
        });
    }
};
