<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('misaccounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained('members');
            $table->string('member_name')->nullable();
            $table->string('member_address')->nullable();
            $table->string('member_mobile', 15)->nullable();
            $table->foreignId('minor_id')->nullable()->constrained('minors');
            $table->foreignId('branch_id')->constrained('branches');
            $table->unsignedBigInteger('advisor_id')->nullable();
            $table->unsignedBigInteger('joint_member_id')->nullable();
            $table->date('open_date');
            $table->integer('tenure_year')->nullable();
            $table->integer('tenure_month')->nullable();
            $table->integer('tenure_day')->nullable();
            $table->decimal('mis_amount', 12, 2);
            $table->string('interest_payout_type');
            $table->string('tds_deduction');
            $table->string('senior_citizen');
            $table->string('account_type');
            $table->string('nominee')->nullable(); // now as string
            $table->decimal('final_amount', 12, 2)->nullable();
            $table->date('transaction_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('misaccounts', function (Blueprint $table) {
            if (Schema::hasColumn('misaccounts', 'nominee')) {
                $table->dropColumn('nominee');
            }
        });
    }
};
