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
                 // Drop the foreign key first
            $table->dropForeign(['incorporation_state']);

            // Make column nullable
            $table->unsignedBigInteger('incorporation_state')->nullable()->change();

            // Re-add foreign key
            $table->foreign('incorporation_state')
                  ->references('id')
                  ->on('states')
                  ->nullOnDelete(); // Optional: sets NULL if state is deleted
        });
    }

   
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
             $table->dropForeign(['incorporation_state']);
            $table->unsignedBigInteger('incorporation_state')->nullable(false)->change();

            $table->foreign('incorporation_state')
                  ->references('id')
                  ->on('states');
        });
    }
};
