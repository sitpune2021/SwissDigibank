<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('rdschemes', function (Blueprint $table) {
            $table->id();
            $table->string('scheme_name');
            $table->string('scheme_code');
            $table->integer('min_rd_dd_amount');
            $table->string('rd_dd_frequency');
            $table->integer('anuual_interest_rate');
            $table->decimal('sr_citizen_add_on_interest_rate', 8, 2)->nullable();
            $table->string('bonus_rate_type');
            $table->integer('bonus_rate_value');
            $table->string('interest_compounding_interval');
            $table->string('rd_dd_lock_in_period');
            $table->string('interest_lock_in_period');
            $table->string('tenure_of_rd_dd_type');
            $table->integer('tenure_of_rd_dd_value');
            $table->string('cancellation_charges_type');
            $table->integer('cancellation_charges_value');
            $table->integer('stationary_charges');
            $table->string('penalty_charges_type');
            $table->integer('penalty_charges_value');
            $table->string('penal_charges');
            $table->string('app_type_admin')->nullable();
            $table->string('app_type_associate')->nullable();
            $table->string('app_type_member')->nullable();
            $table->string('commission_chart')->nullable();
            $table->string('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rdschemes');
    }
};
