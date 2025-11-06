<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::table('mortgage_properties', function (Blueprint $table) {
            $table->decimal('total_security_amount', 15, 2)->nullable()->after('expected_value');
        });
    }

    public function down(): void
    {
        Schema::table('mortgage_properties', function (Blueprint $table) {
            $table->dropColumn('total_security_amount');
        });
    }

};
