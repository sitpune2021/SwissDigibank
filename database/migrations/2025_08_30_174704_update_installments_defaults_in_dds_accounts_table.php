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
               $table->integer('paid_installments')->default(0)->change();
        $table->integer('due_installments')->default(0)->change();
        $table->integer('overdue_installments')->default(0)->change();
        $table->integer('canceled_installments')->default(0)->change();
        $table->integer('not_due_installments')->default(0)->change();
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
