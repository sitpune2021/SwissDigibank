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
        Schema::table('rd_transactions', function (Blueprint $table) {
            $table->decimal('amount_received', 15, 2)->nullable()->after('payment_rev_rel');
            $table->string('remark')->nullable()->after('amount_received');
            $table->boolean('accounted')->default(false)->after('remark');
            $table->decimal('balance', 15, 2)->nullable()->after('accounted');
            $table->date('due_date')->nullable()->after('balance');
            $table->integer('installment_no')->nullable()->after('due_date');
            $table->string('status')->nullable()->after('installment_no');
            $table->date('paid_on')->nullable()->after('status');
            $table->boolean('print_flag')->default(false)->after('paid_on');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('rd_transactions', function (Blueprint $table) {
            $table->dropColumn([
                'amount_received',
                'remark',
                'accounted',
                'balance',
                'due_date',
                'installment_no',
                'status',
                'paid_on',
                'print_flag',
            ]);
        });
    }
};
