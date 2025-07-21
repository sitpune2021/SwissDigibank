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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();

            // Basic Details
            $table->enum('account_type', ['SAVING', 'CURRENT']);
            $table->string('account_no')->unique();
            $table->string('firm_name')->nullable(); // Optional for individuals

            // Foreign Keys
            $table->foreignId('member_id')->constrained('members');
            // $table->foreignId('minor_id')->nullable()->constrained('members');
            $table->unsignedBigInteger('minor_id')->nullable()->default(1);

            $table->foreignId('branch_id')->constrained('branches');
            $table->foreignId('advisor_id')->nullable()->constrained('users'); // Staff or advisor
            $table->foreignId('scheme_id')->nullable()->constrained('schemes');

            // Account Meta
            $table->date('open_date');
            $table->decimal('amount_deposit', 12, 2);

            // Joint Members & Mode
            $table->string('joint_member1')->nullable();
            $table->string('joint_member2')->nullable();
            $table->string('mode_of_operation')->nullable();

            // Payment Details
            $table->dateTime('transaction_date');
            $table->enum('payment_mode', ['cash', 'online', 'cheque']);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
