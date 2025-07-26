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
        Schema::create('marital_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('status')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('marital_statuses')->insert([
            ['status' => 'SINGLE'],
            ['status' => 'MARRIED'],
            ['status' => 'SEPARATED'],
            ['status' => 'DIVORCED'],
            ['status' => 'WIDOWED'],
            ['status' => 'UNMARRIED'],
            ['status' => 'UNTAGGED'],
        ]);


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('marital_statuses');
    }
};
