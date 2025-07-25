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
        Schema::create('religions', function (Blueprint $table) {
            $table->id();
             $table->string('name')->unique();
            $table->softDeletes();
            $table->timestamps();
        });

        DB::table('religions')->insert([
            ['name' => 'HINDU'],
            ['name' => 'MUSLIM'],
            ['name' => 'CHRISTIAN'],
            ['name' => 'SIKH'],
            ['name' => 'BUDDHIST'],
            ['name' => 'JAIN'],
            ['name' => 'ZOROASTRIAN'],
            ['name' => 'JEWISH'],
            ['name' => 'BAHÁ\'Í'],
            ['name' => 'OTHER'],
            ['name' => 'PREFER NOT TO SAY'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('religions');
    }
};
