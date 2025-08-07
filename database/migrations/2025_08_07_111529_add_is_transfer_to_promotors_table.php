<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('promotors', function (Blueprint $table) {
             $table->boolean('is_transfer')->default(false)->after('form15g');
        });
    }

    public function down(): void
    {
        Schema::table('promotors', function (Blueprint $table) {
             $table->dropColumn('is_transfer');
        });
    }
};
