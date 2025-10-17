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
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
             $table->unsignedBigInteger('role_id')->nullable();
            $table->integer('permission_id')->nullable();
            $table->string('role_position')->nullable();
            $table->string('permission_type')->nullable();
            $table->enum('active', ['Yes', 'No'])->default('Yes');
            $table->json('permissions')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
    }
};
