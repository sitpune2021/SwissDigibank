<?php

namespace App\Exports;

use App\Models\MortgageLoanApplication;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class LinePropertExport implements FromCollection, WithHeadings
{
   public function collection()
    {
        // Sirf id aur status column fetch karenge
        return MortgageLoanApplication::select('id', 'status')->get();
    }

    public function headings(): array
    {
        return [
            'LOAN APPLICATION NO',
            'LOAN APPLICATION STATUS',
            'LOAN ACCOUNT NO',
            'LOAN ACCOUNT STATUS',
            'PROPERTY TYPE',
            'EXPECTED VALUE',
            'REGISTERED',
        ];
    }
}
