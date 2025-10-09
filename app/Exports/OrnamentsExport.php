<?php

namespace App\Exports;

use App\Models\LoanOrnament;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class OrnamentsExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return LoanOrnament::query()
            ->join('loan_applications', 'loan_applications.id', '=', 'loan_ornaments.application_id')
            ->join('branches', 'branches.id', '=', 'loan_applications.branch_id')
            ->join('members', 'members.id', '=', 'loan_applications.member_id')
            ->select(
                'branches.branch_name as BRANCH_NAME',
                'members.id as MEMBER_NO',
                'members.member_info_first_name as MEMBER_NAME',
                'loan_applications.id as APPLICATION_NO',
                'loan_ornaments.item_type as ITEM_TYPE',
                'loan_ornaments.item_name as ITEM_NAME',
                'loan_ornaments.no_of_items as TOTAL_ITEMS',
                'loan_ornaments.value_per_gram as VALUE_PER_GRAM',
                'loan_ornaments.net_weight as NET_WEIGHT',
                'loan_ornaments.tunch as TUNCH',
                'loan_ornaments.fine_weight as FINE_WEIGHT',
                'loan_ornaments.total_value as TOTAL_VALUE',
                'loan_ornaments.status as STATUS',
                'loan_ornaments.remark as REMARK'
            )
            ->get();
    }

    public function headings(): array
    {
        return [
            'BRANCH NAME',
            'MEMBER NO',
            'MEMBER NAME',
            'APPLICATION NO',
            'ITEM TYPE',
            'ITEM NAME',
            'TOTAL ITEMS',
            'VALUE PER GRAM (INR)',
            'NET WEIGHT (gm)',
            'TUNCH (%)',
            'FINE WEIGHT (gm)',
            'TOTAL VALUE (INR)',
            'STATUS',
            'REMARK',
        ];
    }
}
