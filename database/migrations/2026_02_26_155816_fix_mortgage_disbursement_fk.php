<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mortgage_loan_disbursements', function (Blueprint $table) {

            // Drop old foreign key
            $table->dropForeign(['loan_application_id']);

            // Add correct foreign key
            $table->foreign('loan_application_id')
                ->references('id')
                ->on('mortgage_loan_applications')
                ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('mortgage_loan_disbursements', function (Blueprint $table) {

            $table->dropForeign(['loan_application_id']);

            // revert to old (optional)
            $table->foreign('loan_application_id')
                ->references('id')
                ->on('loan_applications')
                ->onDelete('cascade');
        });
    }
};
