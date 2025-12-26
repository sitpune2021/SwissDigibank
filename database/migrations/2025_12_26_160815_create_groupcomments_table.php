<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
    {
        Schema::create('groupcomments', function (Blueprint $table) {
            $table->id();

            // If comment belongs to a group
            $table->foreignId('group_id')
                  ->constrained('groups')
                  ->cascadeOnDelete();

            // Logged-in user who commented
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            // Comment text
            $table->string('comment');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groupcomments');
    }
};
