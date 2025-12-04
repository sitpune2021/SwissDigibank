<?php

use Illuminate\Database\Migrations\Migration;

use Illuminate\Database\Schema\Blueprint;

use Illuminate\Support\Facades\Schema;

return new class extends Migration

{

    public function up(): void

    {

        Schema::table('comments', function (Blueprint $table) {

            // Adding columns after mis_account_id (optional)

            $table->unsignedBigInteger('rd_account_id')->nullable()->after('misaccount_id');

            $table->unsignedBigInteger('dds_account_id')->nullable()->after('rd_account_id');

            $table->unsignedBigInteger('fd_account_id')->nullable()->after('dds_account_id');

            // Optional foreign keys (uncomment if required)

            $table->foreign('rd_account_id')->references('id')->on('rd_accounts')->onDelete('cascade');

            $table->foreign('dds_account_id')->references('id')->on('dds_accounts')->onDelete('cascade');

            $table->foreign('fd_account_id')->references('id')->on('fd_accounts')->onDelete('cascade');
        });
    }

    public function down(): void

    {

        Schema::table('comments', function (Blueprint $table) {

            // Drop columns safely

            $table->dropColumn('rd_account_id');

            $table->dropColumn('dds_account_id');

            $table->dropColumn('fd_account_id');
        });
    }
};
