<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up()
    {
        Schema::create('locker_lists', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('branch_id');
            $table->string('locker_no');
            $table->string('locker_name');
            $table->decimal('monthly_charges', 10, 2);

            // New default columns
            $table->unsignedBigInteger('member_id')->default(0);
            $table->tinyInteger('assigned')->default(0); // 0 = not assigned, 1 = assigned
            $table->tinyInteger('status')->default(0);   // 0 = inactive / available, 1 = active

            $table->timestamps();

            // Foreign key
            $table->foreign('branch_id')
                ->references('id')->on('branches')
                ->onDelete('cascade');
        });
    }

  
    public function down(): void
    {
        Schema::dropIfExists('locker_lists');
    }
    
};
