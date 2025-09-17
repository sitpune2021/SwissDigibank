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
        Schema::table('companies', function (Blueprint $table) {
             $table->text('about_company')->nullable()->change();
            $table->string('company_category', 255)->nullable()->change();
            $table->string('company_class', 255)->nullable()->change();
            $table->string('contact_email', 255)->nullable()->change();
            $table->string('cin_no', 255)->nullable()->change();
            $table->date('incorporation_date')->nullable()->change();
            $table->string('incorporation_state', 255)->nullable()->change();
            $table->string('incorporation_country', 255)->nullable()->change();
            $table->decimal('authorized_capital', 15, 2)->nullable()->change();
            $table->decimal('paid_up_capital', 15, 2)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('companies', function (Blueprint $table) {
                        $table->text('about_company')->nullable(false)->change();
            $table->string('company_category', 255)->nullable(false)->change();
            $table->string('company_class', 255)->nullable(false)->change();
            $table->string('contact_email', 255)->nullable(false)->change();
            $table->string('cin_no', 255)->nullable(false)->change();
            $table->date('incorporation_date')->nullable(false)->change();
            $table->string('incorporation_state', 255)->nullable(false)->change();
            $table->string('incorporation_country', 255)->nullable(false)->change();
            $table->decimal('authorized_capital', 15, 2)->nullable(false)->change();
            $table->decimal('paid_up_capital', 15, 2)->nullable(false)->change();
        });
    }
};
