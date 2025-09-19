<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('rdschemes', function (Blueprint $table) {
            DB::statement("ALTER TABLE rdschemes 
            MODIFY COLUMN cancellation_charges_type VARCHAR(191) NULL,
            MODIFY COLUMN cancellation_charges_value DECIMAL(10,2) NULL,
            MODIFY COLUMN stationary_charges DECIMAL(10,2) NULL,
            MODIFY COLUMN penalty_charges_type VARCHAR(191) NULL,
            MODIFY COLUMN penalty_charges_value DECIMAL(10,2) NULL,
            MODIFY COLUMN penal_charges DECIMAL(10,2) NULL
        ");
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rdschemes', function (Blueprint $table) {
            DB::statement("ALTER TABLE rdschemes 
            MODIFY COLUMN cancellation_charges_type VARCHAR(191) NOT NULL,
            MODIFY COLUMN cancellation_charges_value DECIMAL(10,2) NOT NULL,
            MODIFY COLUMN stationary_charges DECIMAL(10,2) NOT NULL,
            MODIFY COLUMN penalty_charges_type VARCHAR(191) NOT NULL,
            MODIFY COLUMN penalty_charges_value DECIMAL(10,2) NOT NULL,
            MODIFY COLUMN penal_charges DECIMAL(10,2) NOT NULL
        ");
        });
    }
};
