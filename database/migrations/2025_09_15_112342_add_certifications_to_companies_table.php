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
            $table->string('iso_certification')->nullable()->after('gst_no');
            $table->string('bis_certification')->nullable()->after('iso_certification');
            $table->string('pf_number')->nullable()->after('bis_certification');
            $table->string('esic_number')->nullable()->after('pf_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['iso_certification', 'bis_certification', 'pf_number', 'esic_number']);
        });
    }
};
