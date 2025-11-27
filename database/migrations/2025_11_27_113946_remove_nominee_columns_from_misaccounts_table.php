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
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->dropColumn([
                'nominee',
                'nominee_relation',
                'nominee_name',
                'nominee_address',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            $table->enum('nominee', ['yes', 'no'])->nullable();
            $table->string('nominee_relation')->nullable();
            $table->string('nominee_name')->nullable();
            $table->string('nominee_address')->nullable();
        });
    }
};
