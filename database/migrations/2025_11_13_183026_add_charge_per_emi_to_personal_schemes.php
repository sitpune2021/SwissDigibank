<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        Schema::table('personal_schemes', function (Blueprint $table) {
            // add new integer column (tinyint) with default 1 (ON EMI)
            $table->tinyInteger('charge_per_emi')->default(1)->after('charges_per_emi_type');
        });

        // Map old text values to new integer column
        // adjust strings if your old values differ (e.g. "On EMI", "ON_EMI")
        DB::table('personal_schemes')->where('charges_per_emi_type', 'ON EMI')->update(['charge_per_emi' => 1]);
        DB::table('personal_schemes')->where('charges_per_emi_type', 'ON PRINCIPAL')->update(['charge_per_emi' => 0]);

        // also handle possible existing numeric strings or other cases
        DB::table('personal_schemes')->where('charges_per_emi_type', '1')->update(['charge_per_emi' => 1]);
        DB::table('personal_schemes')->where('charges_per_emi_type', '0')->update(['charge_per_emi' => 0]);

        // fallback: if still NULL, set default 1
        DB::table('personal_schemes')->whereNull('charge_per_emi')->update(['charge_per_emi' => 1]);

        // now drop old column (optional -- keep commented until you're sure)
        Schema::table('personal_schemes', function (Blueprint $table) {
            $table->dropColumn('charges_per_emi_type');
        });
    }

    public function down()
    {
        Schema::table('personal_schemes', function (Blueprint $table) {
            // recreate old column as string
            $table->string('charges_per_emi_type')->nullable()->after('charge_per_emi');
        });

        // reverse map numeric back to text
        DB::table('personal_schemes')->where('charge_per_emi', 1)->update(['charges_per_emi_type' => 'ON EMI']);
        DB::table('personal_schemes')->where('charge_per_emi', 0)->update(['charges_per_emi_type' => 'ON PRINCIPAL']);

        // drop new numeric column
        Schema::table('personal_schemes', function (Blueprint $table) {
            $table->dropColumn('charge_per_emi');
        });
    }
};
