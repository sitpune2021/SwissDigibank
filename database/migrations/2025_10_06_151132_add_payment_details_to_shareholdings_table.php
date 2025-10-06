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
        Schema::table('shareholdings', function (Blueprint $table) {
            $table->unsignedBigInteger('saving_account_id')->nullable()->after('pay_mode');
            $table->date('transfer_date')->nullable()->after('saving_account_id');
            $table->string('urt_no')->nullable()->after('transfer_date');
            $table->enum('transfer_mode', ['IMPS', 'VPA', 'NEFT/RTGS'])->nullable()->after('urt_no');
            $table->unsignedBigInteger('bank_id')->nullable()->after('transfer_mode');
            $table->string('bank_name')->nullable()->after('bank_id');
            $table->string('cheque_no')->nullable()->after('bank_name');
            $table->date('cheque_date')->nullable()->after('cheque_no');

            $table->foreign('saving_account_id')->references('id')->on('accounts')->nullOnDelete();
            $table->foreign('bank_id')->references('id')->on('banks')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('shareholdings', function (Blueprint $table) {

        });
    }
};
