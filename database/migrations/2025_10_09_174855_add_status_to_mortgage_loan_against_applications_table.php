<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
public function up(): void
    {
        Schema::table('loan_against_applications', function (Blueprint $table) {
            $table->string('status')->default('0')->after('id'); 
            // 'after' me aap wo column likh sakte ho jiske baad ye add ho
        });
    }

    public function down(): void
    {
        Schema::table('loan_against_applications', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
