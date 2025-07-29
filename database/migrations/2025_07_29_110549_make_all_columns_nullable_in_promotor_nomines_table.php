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
        Schema::table('promotor_nomines', function (Blueprint $table) {
                     $table->string('name')->nullable()->change();
            $table->string('relation')->nullable()->change();
            $table->string('mobile_no')->nullable()->change();
            $table->string('aadhaar_no')->nullable()->change();
            $table->string('voter_id_no')->nullable()->change();
            $table->string('pan_no')->nullable()->change();
            $table->text('address')->nullable()->change(); // use text() if it's a text column
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('promotor_nomines', function (Blueprint $table) {
                        $table->string('name')->nullable(false)->change();
            $table->string('relation')->nullable(false)->change();
            $table->string('mobile_no')->nullable(false)->change();
            $table->string('aadhaar_no')->nullable(false)->change();
            $table->string('voter_id_no')->nullable(false)->change();
            $table->string('pan_no')->nullable(false)->change();
            $table->text('address')->nullable(false)->change(); // match the up() type

        });
    }
};
