<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            $table->enum('transaction_type', ['credit', 'reverse'])
                ->nullable()
                ->after('type');

            $table->decimal('interest_amount', 10, 2)
                ->nullable()
                ->after('transaction_type');
        });
    }

    public function down()
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            $table->dropColumn(['transaction_type', 'interest_amount']);
        });
    }
};
