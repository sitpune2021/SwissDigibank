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
        Schema::table('companies', function (Blueprint $table) {
            $table->string('incorporation_country', 255)->nullable()->change();
            $table->decimal('authorized_capital', 15, 2)->nullable()->change();
            $table->decimal('paid_up_capital', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->string('incorporation_country', 255)->nullable(false)->change();
            $table->decimal('authorized_capital', 15, 2)->nullable(false)->change();
            $table->decimal('paid_up_capital', 15, 2)->nullable(false)->change();
        });
    }
};
