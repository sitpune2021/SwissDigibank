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
        Schema::create('master_settings_edit', function (Blueprint $table) {
            $table->id();

    $table->string('member_playstore_url')->nullable();
    $table->string('member_ios_url')->nullable();

    $table->decimal('tax_deduction_limit', 10, 2)->default(0);
    $table->decimal('tax_deduction_limit_senior', 10, 2)->default(0);

    $table->boolean('membership_fee_enabled')->default(false);
    $table->decimal('membership_fee', 10, 2)->default(0);

    $table->boolean('associate_fee_enabled')->default(false);
    $table->decimal('associate_fee', 10, 2)->default(0);

    $table->enum('share_transfer_mode', ['split','allocate'])->default('split');
    $table->boolean('disable_share_selection')->default(false);
    $table->integer('default_shares')->nullable();

    $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('master_settings_edit');
    }
};
