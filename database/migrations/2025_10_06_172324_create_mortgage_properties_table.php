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
        Schema::create('mortgage_properties', function (Blueprint $table) {
            $table->id();

            // Basic property details
            $table->string('property_type')->nullable(); // agriculture_land, urban_land, plot, etc.
            $table->string('doc_number')->nullable();
            $table->string('registrar_name')->nullable();
            $table->string('owner_name')->nullable();
            $table->string('parent_name')->nullable();
            $table->string('plot_no')->nullable();
            $table->string('tehsil')->nullable();
            $table->string('district')->nullable();
            $table->string('area_sqft')->nullable();

            // Boundaries as per Sale Deed
            $table->string('boundary_sale_east')->nullable();
            $table->string('boundary_sale_west')->nullable();
            $table->string('boundary_sale_north')->nullable();
            $table->string('boundary_sale_south')->nullable();

            // Boundaries as per Technical
            $table->string('boundary_tech_east')->nullable();
            $table->string('boundary_tech_west')->nullable();
            $table->string('boundary_tech_north')->nullable();
            $table->string('boundary_tech_south')->nullable();

            // Other info
            $table->decimal('expected_value', 15, 2)->nullable();
            $table->enum('registered', ['yes', 'no'])->default('no');

            // For relation (optional)
            $table->unsignedBigInteger('loan_application_id')->nullable();
            $table->foreign('loan_application_id')->references('id')->on('loan_applications')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mortgage_properties');
    }
};
