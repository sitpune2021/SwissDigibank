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
        Schema::table('users', function (Blueprint $table) {
            $table->integer('emp_id')->nullable(); // int(11), default 0
            $table->string('designation', 100)->nullable(); // varchar(100), nullable
            $table->string('username', 255)->nullable(); // varchar(255), nullable
            $table->integer('back_edate_days')->nullable(); // int(11), nullable
            $table->integer('branch_id')->nullable(); // int(11), nullable
            $table->enum('login_on_holidays', ['1', '0']); // enum, not null
            $table->enum('searchable_accounts', ['1', '0']); // enum, not null
            $table->enum('user_active', ['1', '0']); // enum, not null
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
