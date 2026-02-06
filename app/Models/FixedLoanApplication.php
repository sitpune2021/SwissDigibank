<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FixedLoanApplication extends Model
{
    use HasFactory;
    
    protected $fillable = [

        // 🔹 Basic Application Info
        'application_date',
        'application_no',
        'member_id',
        'branch_id',
        'advisor_id',

        // 🔹 Co-Applicants
        'co_applicant_1_id',
        'relation_co_applicant_1',
        'co_applicant_2_id',
        'relation_co_applicant_2',

        // 🔹 Guarantors
        'guarantor_1_id',
        'relation_guarantor_1',
        'guarantor_2_id',
        'relation_guarantor_2',
        'guarantor_3_id',
        'relation_guarantor_3',
        'guarantor_4_id',
        'relation_guarantor_4',

        // 🔹 Loan & Scheme
        'scheme_id',              // optional / nullable
        'credit_period',
        'net_loan_amount',
        'purpose_of_loan',

        'stamp_duty',
        'fitness_fee',
        'insurance_fee',
        'credited',

        // 🔹 EMI & Tenure
        'tenure_value',
        'loan_amount',
        'emi_collection',
        'emi_amount',

        // 🔹 Calculated Fields (FINAL values only)
        'charge_per_emi',
        'net_emi_with_charges',
        'total_recovered_amount',
    ];


public function member()
{
    return $this->belongsTo(Member::class, 'member_id');
}

public function coApplicant1()
{
    return $this->belongsTo(Member::class, 'co_applicant_1_id');
}

public function guarantor1()
{
    return $this->belongsTo(Member::class, 'guarantor_1_id');
}

public function guarantor2()
{
    return $this->belongsTo(Member::class, 'guarantor_2_id');
}

public function guarantor3()
{
    return $this->belongsTo(Member::class, 'guarantor_3_id');
}

public function guarantor4()
{
    return $this->belongsTo(Member::class, 'guarantor_4_id');
}

public function branch()
{
    return $this->belongsTo(Branch::class, 'branch_id');
}

public function scheme()
{
    return $this->belongsTo(DailyWeeklyScheme::class, 'scheme_id');
}

    public function DailyWeeklyLoanTransaction()
    {
        return $this->hasMany(DailyWeeklyLoanTransaction::class, 'loan_id', 'id');
    }

    public function emiPayments()
    {
        return $this->hasMany(DailyWeeklyLoanTransaction::class, 'loan_id', 'id');
    }


}
