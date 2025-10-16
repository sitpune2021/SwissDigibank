<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loan_against_schemes', function (Blueprint $table) {
            $table->string('security_type')->nullable()->after('max_loan_amount');
        });
    }

    public function down(): void
    {
        Schema::table('loan_against_schemes', function (Blueprint $table) {
            $table->dropColumn('security_type');
        });
    }
};
