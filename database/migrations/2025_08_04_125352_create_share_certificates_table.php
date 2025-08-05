<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
{
    Schema::create('share_certificates', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('member_id');
        $table->unsignedBigInteger('branch_id');
        $table->string('certificate_no');
        $table->string('share_range');
        $table->timestamps();

        $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
        $table->foreign('branch_id')->references('id')->on('branches')->onDelete('cascade');
    });
}

    public function down(): void
    {
        Schema::dropIfExists('share_certificates');
    }
};
