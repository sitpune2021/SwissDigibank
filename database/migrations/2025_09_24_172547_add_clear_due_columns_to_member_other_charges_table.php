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
        Schema::table('member_other_charges', function (Blueprint $table) {
            $table->decimal('charges_due', 10, 2)->nullable()->after('state');
            $table->decimal('waived_amount', 10, 2)->nullable()->after('charges_due');
            $table->decimal('gst_rate', 5, 2)->default(18.00)->after('waived_amount');
            $table->decimal('total_amount', 10, 2)->nullable()->after('gst_rate');
            $table->decimal('rounding_off', 10, 2)->nullable()->after('total_amount');
            $table->decimal('net_amount', 10, 2)->nullable()->after('rounding_off');
            $table->text('clear_due_remarks')->nullable()->after('net_amount');
            $table->enum('pay_mode', ['Cash', 'Online', 'Cheque'])->nullable()->after('clear_due_remarks');
            $table->date('transfer_date')->nullable()->after('pay_mode');
            $table->string('utr_no')->nullable()->after('transfer_date');
            $table->enum('transfer_mode', ['IMPS', 'VPA', 'NEFT/RTGS'])->nullable()->after('utr_no');
            $table->boolean('credited_in_account')->default(false)->after('transfer_mode');
            $table->unsignedBigInteger('bank_id')->nullable()->after('credited_in_account');
            $table->string('cheque_no')->nullable()->after('bank_id');
            $table->date('cheque_date')->nullable()->after('cheque_no');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('member_other_charges', function (Blueprint $table) {
            // Drop added columns
            $table->dropColumn([
                'charges_due',
                'waived_amount',
                'gst_rate',
                'total_amount',
                'rounding_off',
                'net_amount',
                'clear_due_remarks',
                'pay_mode',
                'transfer_date',
                'utr_no',
                'transfer_mode',
                'credited_in_account',
                'bank_id',
                'cheque_no',
                'cheque_date',
            ]);
        });
    }
};
