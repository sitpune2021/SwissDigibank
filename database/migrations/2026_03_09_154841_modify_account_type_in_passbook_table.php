<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::statement("
            ALTER TABLE passbook 
            MODIFY account_type ENUM(
                'Saving',
                'Current',
                'RD Accounts',
                'DD Accounts',
                'FD Accounts',
                'MIS Accounts',
                'DDS Accounts',
                'Gold Account',
                'Property Account',
                'Deposit Account',
                'Business Account',
                'CCOD Account',
                'Daily / Weekly Account',
                'Personal Account',
                'Vehicle Account',
                'Fixed Account'
            )
        ");
    }

    public function down(): void
    {
        DB::statement("
            ALTER TABLE passbook 
            MODIFY account_type ENUM(
                'Saving',
                'Current',
                'RD Accounts',
                'DD Accounts',
                'FD Accounts',
                'MIS Accounts',
                'DDS Accounts'
            )
        ");
    }
};
