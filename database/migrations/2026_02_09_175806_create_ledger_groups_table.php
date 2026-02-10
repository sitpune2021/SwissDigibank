<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::create('ledger_groups', function (Blueprint $table) {
        $table->id();

        $table->string('display_name');      // Current Assets
        $table->string('system_name');       // CURRENT ASSETS
        $table->enum('type', [
            'Asset',
            'Liability',
            'Equity',
            'Expense',
            'Revenue'
        ]);

        $table->boolean('is_system_group')->default(0); // Yes/No
        $table->integer('weightage')->default(1); // sorting

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledger_groups');
    }
};
