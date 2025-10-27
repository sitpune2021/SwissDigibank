<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('cc_od_loan_disbursments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('loan_application_id');
            $table->date('disbursal_date');
            $table->decimal('loan_amount', 15, 2);
            $table->decimal('final_amount', 15, 2);
            $table->timestamps();

            $table->foreign('loan_application_id')
                  ->references('id')
                  ->on('cc_od_loan_applications')
                  ->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cc_od_loan_disbursments');
    }
};
