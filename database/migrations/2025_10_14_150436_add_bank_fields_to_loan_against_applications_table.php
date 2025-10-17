<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('loan_against_applications', function (Blueprint $table) {
            // Banking related fields
            $table->unsignedBigInteger('bank_id')->nullable()->after('member_id');
            $table->string('cheque_no')->nullable()->after('bank_id');
            $table->date('cheque_date')->nullable()->after('cheque_no');
            $table->date('transfer_date')->nullable()->after('cheque_date');
            $table->string('utr_no')->nullable()->after('transfer_date');
            $table->string('transfer_mode')->nullable()->after('utr_no');
            $table->boolean('credited')->default(0)->after('transfer_mode'); // 0 = No, 1 = Yes
        });
    }

    public function down(): void
    {
        Schema::table('loan_against_applications', function (Blueprint $table) {
            $table->dropColumn([
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
