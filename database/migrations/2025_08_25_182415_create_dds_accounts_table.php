<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('dds_accounts', function (Blueprint $table) {
            $table->id();  // This is an auto-incrementing unsigned BIGINT column

            $table->unsignedBigInteger('member_id'); // FK to members table
            $table->string('member_name');
            $table->string('member_address')->nullable();
            $table->string('member_mobile', 15)->nullable();

            $table->unsignedBigInteger('minor_id')->nullable(); // FK to members table (nullable)

            $table->unsignedBigInteger('branch_id'); // FK to branches table
            $table->unsignedBigInteger('advisor_id')->nullable(); // FK to staff/advisors table
            $table->unsignedBigInteger('collection_advisor_id')->nullable(); // FK to staff/advisors table
            $table->unsignedBigInteger('scheme_id'); // FK to schemes table
            $table->decimal('dd_amount', 12, 2);
            $table->date('open_date');
            $table->boolean('tds_deduction')->default(false); // Yes/No
            $table->enum('account_type', ['single', 'joint'])->default('single');
            $table->boolean('nominee')->default(false); // Yes/No
            $table->timestamps();
            $table->foreign('member_id')
                ->references('id')->on('members')
                ->onDelete('cascade');
            $table->foreign('minor_id')
                ->references('id')->on('members')
                ->onDelete('set null'); // Make sure 'set null' is handled properly

            $table->foreign('branch_id')
                ->references('id')->on('branches')
                ->onDelete('cascade');

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('dds_accounts');
    }
};
