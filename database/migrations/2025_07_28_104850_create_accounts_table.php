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

            // Account Type and Number
            $table->enum('account_type', ['SAVING', 'CURRENT']);
            $table->string('account_no')->index(); // Index as per your structure
            $table->string('firm_name')->nullable();

            // Foreign Keys
            $table->foreignId('member_id')->nullable()->constrained('members');
            $table->unsignedBigInteger('minor_id')->nullable()->default(1); // Foreign key optional
            $table->foreignId('branch_id')->constrained('branches');
            $table->unsignedBigInteger('advisor_id')->nullable();
            $table->foreignId('scheme_id')->nullable()->constrained('schemes');

            // Account Meta
            $table->date('open_date');
            $table->decimal('amount_deposit', 12, 2)->nullable();

            // Account Holder Type
            $table->enum('account_holder_type', ['single', 'joint']);

            // Joint Members & Operation Mode
            $table->string('joint_member1')->nullable();
            $table->string('joint_member2')->nullable();
            $table->enum('mode_of_operation', ['single', 'jointly', 'either_or_survivor'])->nullable();

            // Transaction Info
            $table->dateTime('transaction_date');
            $table->enum('payment_mode', ['cash', 'online', 'cheque']);

             //  Approve Status Field
            $table->enum('approve_status', ['0', '1','2'])->default('0');
            $table->string('remarks')->nullable();

            // Timestamps
            $table->softDeletes();
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
