<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loanagainsst_disbursements', function (Blueprint $table) {
            // drop old foreign key
            $table->dropForeign(['loan_application_id']);

            // add correct foreign key
            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('loan_against_applications')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('loanagainsst_disbursements', function (Blueprint $table) {
            // rollback to old FK (optional but safe)
            $table->dropForeign(['loan_application_id']);

            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('loan_applications')
                  ->onDelete('cascade');
        });
    }
};
