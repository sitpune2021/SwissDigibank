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
        Schema::table('branches', function (Blueprint $table) {
            $table->string('branch_code')->nullable()->change();
            $table->string('ifsc_code')->nullable()->change();
            $table->string('address_line1')->nullable()->change();
            $table->string('city')->nullable()->change();
            $table->unsignedBigInteger('state')->nullable()->change();
            $table->string('pincode')->nullable()->change();
            $table->enum('disable_recharge', ['yes', 'no'])->nullable()->change();
            $table->enum('disable_neft', ['yes', 'no'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('branches', function (Blueprint $table) {
            $table->string('branch_code')->nullable(false)->change();
            $table->string('ifsc_code')->nullable(false)->change();
            $table->string('address_line1')->nullable(false)->change();
            $table->string('city')->nullable(false)->change();
            $table->unsignedBigInteger('state')->nullable(false)->change();
            $table->string('pincode')->nullable(false)->change();
            $table->enum('disable_recharge', ['yes', 'no'])->nullable(false)->change();
            $table->enum('disable_neft', ['yes', 'no'])->nullable(false)->change();
        });
    }
};
