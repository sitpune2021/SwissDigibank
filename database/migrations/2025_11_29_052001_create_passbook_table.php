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
        Schema::create('passbook', function (Blueprint $table) {
            $table->id();
            
            $table->enum('account_type', ['Saving', 'Current', 'RD Accounts','DD Accounts','FD Accounts','MIS Accounts','DDS Accounts'])->nullable()->comment('Type of account');
            // $table->unsignedBigInteger('savings_id')->nullable();
            // $table->unsignedBigInteger('current_id')->nullable();
            // $table->unsignedBigInteger('mis_account_id')->nullable();
            // $table->unsignedBigInteger('fd_account_id')->nullable();
            // $table->unsignedBigInteger('dds_account_id')->nullable();
            // $table->unsignedBigInteger('rd_account_id')->nullable();
            $table->string('account_no')->nullable()->comment('Account number');
            $table->string('passbook_no')->unique()->nullable()->comment('Passbook number');
            $table->date('issue_date')->nullable()->comment('Passbook issue date');
            $table->integer('pages')->nullable()->comment('Number of pages in passbook');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('passbook');
    }
};
