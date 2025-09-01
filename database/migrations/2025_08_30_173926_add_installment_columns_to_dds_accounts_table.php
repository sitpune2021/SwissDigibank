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
        Schema::table('dds_accounts', function (Blueprint $table) {
                    $table->integer('total_installments')->nullable();
        $table->integer('paid_installments')->default(0);
        $table->integer('due_installments')->default(0);
        $table->integer('overdue_installments')->default(0);
        $table->integer('canceled_installments')->default(0);
        $table->integer('not_due_installments')->default(0);
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dds_accounts', function (Blueprint $table) {
            //
        });
    }
};
