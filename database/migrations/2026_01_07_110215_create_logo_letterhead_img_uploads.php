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
        Schema::create('logo_letterhead_img_uploads', function (Blueprint $table) {
            $table->id();
            $table->string('type'); // 'logo' or 'letterhead'
            $table->string('image_path'); // relative path to public/assets/images/admin_imgs
            $table->unsignedBigInteger('uploaded_by'); // Super Admin who uploaded
            $table->timestamps();

            // Foreign key
            $table->foreign('uploaded_by')
                  ->references('id')
                  ->on('users')
                  ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('logo_letterhead_img_uploads');
    }
};
