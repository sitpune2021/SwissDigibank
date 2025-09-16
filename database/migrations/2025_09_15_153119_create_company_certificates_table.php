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
        Schema::create('company_certificates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('company_id');
            $table->string('cin_certificate_path')->nullable();
            $table->string('pan_certificate_path')->nullable();
            $table->string('tan_certificate_path')->nullable();
            $table->string('gst_certificate_path')->nullable();
            $table->string('iso_certificate_path')->nullable();
            $table->string('bis_certificate_path')->nullable();
            $table->string('pf_certificate_path')->nullable();
            $table->string('esic_certificate_path')->nullable();
            $table->foreign('company_id')
                ->references('id')
                ->on('companies')
                ->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_certificates');
    }
};
