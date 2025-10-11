<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMisaccountNomineesTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('misaccount_nominees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('mis_account_id');
           $table->string('nominee_name');
            $table->string('nominee_relation');
    $table->text('nominee_address')->nullable();
            $table->timestamps();

            $table->foreign('mis_account_id')
                  ->references('id')
                  ->on('misaccounts')
                  ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('misaccount_nominees');
    }
}
