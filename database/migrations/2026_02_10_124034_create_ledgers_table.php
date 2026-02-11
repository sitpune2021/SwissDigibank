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
    Schema::create('ledgers', function (Blueprint $table) {
        $table->id();

        $table->string('code')->unique();

        $table->string('display_name');
        $table->string('system_name');

        $table->enum('type', [
            'Asset',
            'Liability',
            'Equity',
            'Expense',
            'Revenue'
        ]);

        $table->foreignId('group_id')
              ->constrained('ledger_groups')
              ->cascadeOnDelete();

        $table->boolean('is_bank_acc')->default(false);
        $table->boolean('show_in_day')->default(false);

        $table->decimal('opening_balance', 15, 2)->default(0);

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ledgers');
    }
};
