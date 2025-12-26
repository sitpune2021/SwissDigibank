<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('groups', function (Blueprint $table) {
            $table->id();

            // 1. Collection Center
            $table->foreignId('collection_center_id')
                ->nullable()
                ->constrained('collection_centers')
                ->nullOnDelete();

            // 2. Branch
            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->nullOnDelete();

            // 3. Open Date
            $table->date('open_date');

            // 4. Group Name
            $table->string('group_name');

            // 5. Group Number
            $table->string('group_no')->unique();

            // 6. Group Head (Member)
            $table->foreignId('group_head_member_id')
                ->constrained('members')
                ->restrictOnDelete();

            // 7. Group Cashier (Member)
            $table->foreignId('group_cashier_member_id')
                ->nullable()
                ->constrained('members')
                ->nullOnDelete();

            // 9. Group Active
            $table->boolean('is_active')
                ->default(true)
                ->comment('1 = Active, 0 = Inactive');

            $table->timestamps();

            // Optional but useful indexes
            $table->index('collection_center_id');
            $table->index('branch_id');
            $table->index('group_head_member_id');
            $table->index('group_cashier_member_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('groups');
    }
};
