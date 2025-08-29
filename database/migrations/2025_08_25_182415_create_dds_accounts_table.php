<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dds_accounts', function (Blueprint $table) {
            $table->id();

            // Member details
            $table->unsignedBigInteger('member_id'); // FK to members table
            $table->string('member_name');
            $table->string('member_address')->nullable();
            $table->string('member_mobile', 15)->nullable();

            // Minor (if any)
            $table->unsignedBigInteger('minor_id')->nullable(); // FK to members table (if minor)

            // Branch & Staff
            $table->unsignedBigInteger('branch_id'); // FK to branches table
            $table->unsignedBigInteger('advisor_id')->nullable(); // FK to staff/advisors table
            $table->unsignedBigInteger('collection_advisor_id')->nullable(); // FK to staff/advisors table

            // Scheme
            $table->unsignedBigInteger('scheme_id'); // FK to schemes table
            $table->decimal('dd_amount', 12, 2);

            // Dates
            $table->date('open_date');

            // Options
            $table->boolean('tds_deduction')->default(false); // Yes/No
            $table->enum('account_type', ['single', 'joint'])->default('single');
            $table->boolean('nominee')->default(false); // Yes/No

            $table->timestamps();

            // ✅ Foreign keys (with proper null handling)
            $table->foreign('member_id')
                ->references('id')->on('members')
                ->cascadeOnDelete();

            $table->foreign('minor_id')
                ->references('id')->on('members')
                ->nullOnDelete();

            $table->foreign('branch_id')
                ->references('id')->on('branches')
                ->cascadeOnDelete();

            $table->foreign('advisor_id')
                ->references('id')->on('staff')
                ->nullOnDelete();

            $table->foreign('collection_advisor_id')
                ->references('id')->on('staff')
                ->nullOnDelete();

            $table->foreign('scheme_id')
                ->references('id')->on('schemes')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dds_accounts');
    }
};
