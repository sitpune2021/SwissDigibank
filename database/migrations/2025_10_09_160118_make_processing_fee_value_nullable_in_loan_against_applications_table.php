<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loan_against_applications', function (Blueprint $table) {
            $table->decimal('processing_fee_value', 10, 2)
                  ->nullable()
                  ->default(null)
                  ->change();
        });
    }

    public function down(): void
    {
        // Replace nulls with 0 before reverting
        DB::table('loan_against_applications')
            ->whereNull('processing_fee_value')
            ->update(['processing_fee_value' => 0]);

        Schema::table('loan_against_applications', function (Blueprint $table) {
            $table->decimal('processing_fee_value', 10, 2)
                  ->default(0)
                  ->change();
        });
    }
};

