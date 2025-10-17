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
        Schema::table('mortgage_loan_applications', function (Blueprint $table) {
             $table->string('fee_mode')->nullable()->after('purpose_of_loan');
            $table->unsignedBigInteger('bank_id')->nullable()->after('fee_mode');
            $table->string('cheque_no')->nullable()->after('bank_id');
            $table->date('cheque_date')->nullable()->after('cheque_no');
            $table->date('transfer_date')->nullable()->after('cheque_date');
            $table->string('utr_no')->nullable()->after('transfer_date');
            $table->string('transfer_mode')->nullable()->after('utr_no');
            $table->boolean('credited')->default(0)->after('transfer_mode'); // 0 = No, 1 = Yes
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mortgage_loan_applications', function (Blueprint $table) {
             $table->dropColumn([
                'fee_mode',
                'bank_id',
                'cheque_no',
                'cheque_date',
                'transfer_date',
                'utr_no',
                'transfer_mode',
                'credited',
            ]);
        });
    }
};
