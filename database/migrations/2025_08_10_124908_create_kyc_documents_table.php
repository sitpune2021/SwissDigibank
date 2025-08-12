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
        Schema::create('kyc_documents', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('member_id')->nullable();
            $table->unsignedBigInteger('promoter_id')->nullable();

            $table->string('document_category'); // e.g., 'photo', 'signature', 'id_proof'
            $table->string('document_type')->nullable(); // e.g., 'Aadhaar Card', 'Passport'
            $table->string('file_path');
            $table->string('type'); // optional: e.g., 'member', 'promoter' (can remove if redundant)
            $table->timestamps();

            // Foreign keys
            $table->foreign('member_id')->references('id')->on('members')->onDelete('cascade');
            $table->foreign('promoter_id')->references('id')->on('promotors')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('kyc_documents');
    }
};
