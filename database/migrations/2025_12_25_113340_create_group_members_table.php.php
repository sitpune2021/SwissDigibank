<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
     public function up(): void
    {
        Schema::create('group_members', function (Blueprint $table) {
            $table->id();

            // Group reference
            $table->foreignId('group_id')
                  ->constrained('groups')
                  ->cascadeOnDelete();

            // Member reference
            $table->foreignId('member_id')
                  ->constrained('members')
                  ->cascadeOnDelete();

            $table->timestamps();

            // Prevent same member from being added more than once to a group
            $table->unique(['group_id', 'member_id'], 'group_member_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('group_members');
    }
};
