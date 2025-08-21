<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up()
{
    Schema::table('calculators', function (Blueprint $table) {
        $table->decimal('maturity_amount', 15, 2)->change(); // Ensure it’s decimal
    });
}

public function down()
{
    Schema::table('calculators', function (Blueprint $table) {
        $table->decimal('maturity_amount', 10, 0)->change(); // Revert if needed
    });
}

};
