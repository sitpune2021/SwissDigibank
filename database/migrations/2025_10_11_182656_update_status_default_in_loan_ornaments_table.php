<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loan_ornaments', function (Blueprint $table) {
            $table->string('status')->default('1')->change(); // ✅ default value add
        });
    }

    public function down(): void
    {
        Schema::table('loan_ornaments', function (Blueprint $table) {
            $table->string('status')->change(); // rollback ke liye default hata do
        });
    }
};
