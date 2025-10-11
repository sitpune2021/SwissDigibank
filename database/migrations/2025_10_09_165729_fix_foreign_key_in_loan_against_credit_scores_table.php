<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('loan_against_credit_scores', function (Blueprint $table) {
            // पहले पुराना foreign key हटाओ (अगर हो)
            $table->dropForeign(['loan_application_id']);

            // फिर सही वाला जोड़ो
            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('loan_against_applications')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('loan_against_credit_scores', function (Blueprint $table) {
            $table->dropForeign(['loan_application_id']);

            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('loan_applications')
                  ->onDelete('cascade');
        });
    }
};
