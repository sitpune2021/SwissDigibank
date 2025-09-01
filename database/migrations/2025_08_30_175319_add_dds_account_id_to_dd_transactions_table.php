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
        Schema::table('dd_transactions', function (Blueprint $table) 
    {
              if (!Schema::hasColumn('dd_transactions', 'dds_account_id')) 
                {
                $table->unsignedBigInteger('dds_account_id')->after('id');

                // Foreign key constraint
                $table->foreign('dds_account_id')
                      ->references('id')->on('dds_accounts')
           
                                   
                      ->onDelete('cascade');
                }
        });
    
    
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dd_transactions', function (Blueprint $table) {
            //
        });
    }
};
