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
        Schema::create('rd_accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->foreignId('minor_id')->nullable()->constrained('minors');
            $table->foreignId('branch_id')->constrained('branches');
            $table->string('advisor_staff')->nullable();
            $table->string('collection_advisor_staff')->nullable();
            $table->string('scheme');
            $table->decimal('rd_amount', 10, 2);
            $table->date('open_date');
            $table->enum('tds', ['yes', 'no'])->comment('TDS Deduction');
            $table->enum('account_type', ['single', 'joint']);
            $table->string('joint_savings_account')->nullable();
            $table->foreignId('nominee_id')->nullable()->constrained('account_nominees');
            $table->enum('payment_mode', ['cash', 'onlineTr', 'cheque', 'savingAcc'])->comment('Mode of payment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rd_accounts');
    }
};
