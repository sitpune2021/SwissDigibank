<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('webauthn_credentials', function (Blueprint $table) {

            $table->string('device_name')->nullable();

            $table->string('browser')->nullable();

            $table->string('ip_address')->nullable();

            $table->timestamp('last_used_at')->nullable();

        });
    }

    public function down(): void
    {
        Schema::table('webauthn_credentials', function (Blueprint $table) {

            $table->dropColumn([
                'device_name',
                'browser',
                'ip_address',
                'last_used_at'
            ]);

        });
    }
};