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
        Schema::create('fd_accounts', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('member_id');
            $table->unsignedBigInteger('minor_id')->nullable();

            $table->unsignedBigInteger('branch_id')->nullable();
            $table->unsignedBigInteger('staff_id')->nullable();

            $table->date('open_date')->nullable();
            $table->integer('tenure_year')->nullable();
            $table->integer('tenure_month')->nullable();
            $table->integer('tenure_days')->nullable();
            $table->decimal('fd_amount', 15, 2)->nullable();
            $table->string('interest_payout_type')->nullable();
            $table->boolean('tds_deduction')->default(false);
            $table->boolean('senior_citizen')->default(false);
            $table->string('account_type')->nullable();

            $table->json('nominees')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fd_accounts');
    }
};
