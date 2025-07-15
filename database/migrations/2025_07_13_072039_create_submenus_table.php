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
        Schema::create('submenus', function (Blueprint $table) {
            $table->id();
             $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade');
            $table->string('title');
            $table->string('route');
            $table->timestamps();
            $table->unique(['menu_id', 'title']); // submenu title unique per menu
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('submenus');
    }
};
