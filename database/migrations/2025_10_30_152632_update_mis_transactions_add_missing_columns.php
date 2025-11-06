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
       Schema::table('mis_transactions', function (Blueprint $table) {
        if (!Schema::hasColumn('mis_transactions', 'transaction_type')) {
                $table->enum('transaction_type', ['credit', 'debit'])->nullable()->after('amount')->comment('Transfer type');
            }

             if (!Schema::hasColumn('mis_transactions', 'transaction_no')) {
                $table->string('transaction_no')->nullable()->after('transfer_date')->comment('UTR or transaction number');
            }

            if (!Schema::hasColumn('mis_transactions', 'transaction_date')) {
                $table->date('transaction_date')->after('transaction_no')->nullable();
            }

            if (!Schema::hasColumn('mis_transactions', 'cheque_bank_name')) {
                $table->string('cheque_bank_name')->nullable()->after('credited')->comment('Bank name for cheque');
            }

            if (!Schema::hasColumn('mis_transactions', 'approve_status')) {
                $table->enum('approve_status', ['approved', 'disapproved', 'pending'])->default('pending')->after('cheque_date')->comment('Cheque approval status');
            }

            if (!Schema::hasColumn('mis_transactions', 'amount_received')) {
                $table->decimal('amount_received', 15, 2)->nullable()->after('approve_status');
            }

            if (!Schema::hasColumn('mis_transactions', 'remark')) {
                $table->string('remark')->nullable()->after('amount_received');
            }

            if (!Schema::hasColumn('mis_transactions', 'accounted')) {
                $table->tinyInteger('accounted')->default(0)->after('remark');
            }
            if (!Schema::hasColumn('mis_transactions', 'status')) {
                $table->string('status')->nullable()->after('accounted');
            }

            if (!Schema::hasColumn('mis_transactions', 'paid_on')) {
                $table->date('paid_on')->nullable()->after('status');
            }

            if (!Schema::hasColumn('mis_transactions', 'print_flag')) {
                $table->tinyInteger('print_flag')->default(0)->after('paid_on');
            }
       });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('mis_transactions', function (Blueprint $table) {
            $cols = [
                'transaction_type', 'transaction_no','transaction_date', 'cheque_bank_name',
                'approve_status', 'amount_received', 'remark',
                'accounted',  'status', 'paid_on', 'print_flag'
            ];
            foreach ($cols as $col) {
                if (Schema::hasColumn('mis_transactions', $col)) {
                    $table->dropColumn($col);
                }
            }
        });
    }
};
