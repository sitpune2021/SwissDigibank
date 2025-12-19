<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('bank_account', function (Blueprint $table) {
            $table->id();
            $table->foreignId('bank_id')
                ->nullable()
                ->constrained('banks')
                ->nullOnDelete();

            $table->foreignId('account_id')
                ->nullable()
                ->constrained('accounts')
                ->nullOnDelete();

            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            $table->date('account_open_date')->nullable();
            $table->string('account_no')->nullable();
            $table->string('ifsc_code', 20)->nullable();
            $table->string('account_type')->nullable();
            $table->text('address')->nullable();

            $table->boolean('account_active')->nullable();
            $table->boolean('use_for_printing')->nullable();
            $table->boolean('accounting_bank')->nullable();
            $table->timestamps();
        });
    }
    public function down(): void
    {
        Schema::dropIfExists('bank_account');
    }
};
